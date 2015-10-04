<?

class Env {

	/**
	 * @return boolean
	 */
	public static function isProd() {
		return self::getDomain() === "pp.smellslikefail.co";
	}

	/**
	 * @return boolean
	 */
	public static function isDev() {
		$domain = self::getDomain();
		if ($domain !== "pp.smellslikefail.co") {
			// it's not prod!
			return true;
		}
		return false;
	}

	/**
	 * @return string
	 */
	public static function getEnvString() {
		return str_replace(["."], "_", self::getDomain());
	}

	/**
	 * @return string
	 */
	public static function getDomain() {
		return str_replace(['www.', '/'], '', $_SERVER['HTTP_HOST']);
	}

}
