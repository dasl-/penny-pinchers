<?

class Authorizer {

    /** @var boolean */
    private static $is_authenticated;

    /** @var Model_User */
    private static $logged_in_user;

    /** @var Model_Session */
    private static $session = false;

	/**
	 * @param Model_Session $session
	 */
	public static function setSessionCookieFromSession($session) {
        $value = json_encode([
            "user_id" => $session->user_id,
            "session_string" => $session->session_string,
        ]);
		$expire = time() + 60 * 60 * 24 * 365 * 10; // 10 years

        self::setSessionCookie($value, $expire);
	}

	public static function logout() {
		$session = self::getSession();
        if ($session) {
            Finder_Session::getFinder()->delete($session->session_id);
        }
        self::$logged_in_user = null;
        self::$session = false;
		self::setSessionCookie("", 0);
	}

	/**
	 * @return boolean
	 */
	public static function isAuthenticated() {
        if (self::$is_authenticated !== null) {
            return self::$is_authenticated;
        }

        $session = self::getSession();
        if ($session) {
            self::$is_authenticated = true;
            self::$logged_in_user = Finder_User::getFinder()->findRecord($session->user_id);
            if (!self::$logged_in_user) {
                self::logout();
                throw new RuntimeException("Unable to find authenticated user record.");
            }
        } else {
            self::$is_authenticated = false;
        }
        return self::$is_authenticated;
	}

    /**
     * @return Model_User
     */
    public static function getLoggedInUser() {
        if (!self::isAuthenticated()) {
            return null;
        }
        return self::$logged_in_user;
    }

	/**
	 * @return Model_Session
	 */
	private static function getSession() {
        if (self::$session !== false) {
            return self::$session;
        }

        if (!isset($_COOKIE['session'])) {
            self::$session = null;
            return self::$session;
        }

        $authentication = json_decode($_COOKIE['session'], true);
        $user_id = isset($authentication["user_id"]) ? $authentication["user_id"] : "";
        $session_string = isset($authentication["session_string"]) ? $authentication["session_string"] : "";
        self::$session = Finder_Session::getFinder()->findByUserIdAndSessionString($user_id, $session_string);
        return self::$session;
	}

	private static function setSessionCookie($value, $expire) {
        // Make the cookie specific to the subdomain.
        $domain = str_replace(['www.', '/'], '', $_SERVER['HTTP_HOST']);

        // TODO: use SSL here
        $success = setcookie("session", $value, $expire, "/", $domain);
        if (!$success) {
        	throw new RuntimeException("Unable to set session cookie.");
        }
	}

}
