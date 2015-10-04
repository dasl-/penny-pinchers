<?

class Api_Users_Login extends Api_Endpoint {

    /**
     * @return array An associative array that will be turned into json as the response.
     */
    protected function handleRequestInternal() {
        $user_name = $this->request->getPost("user_name");
        $user = Finder_User::getFinder()->findByUserName($user_name);
        if (!$user) {
            $this->response->setStatusCode(Http::STATUS_CODE_BAD_REQUEST);
            return [
                "error_message" => "No user with user name '$user_name' exists.",
            ];
        }

        $password = $this->request->getPostRaw("password");
        if (!password_verify($password, $user->password_hash)) {
            $this->response->setStatusCode(Http::STATUS_CODE_UNAUTHORIZED);
            return [
                "error_message" => "Bad user name or password.",
            ];
        }

        $session = Model_Session::createNew($user->user_id);
        Authorizer::setSessionCookieFromSession($session);
        return [
            "user_id" => $user->user_id,
        ];
    }

    protected function doesEndpointRequireAuthentication() {
        return false;
    }

}
