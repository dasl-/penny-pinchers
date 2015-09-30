<?

class Orm_Db {

    /** @var PDO */
    private static $pdo;

    /**
     * @return PDO
     */
    public static function getPdo() {
        if (!self::$pdo) {
            $db_config = $GLOBALS["secrets"]["db_config"];
            $host = $db_config["db_host"];
            $db = $db_config["db_name"];
            $user = $db_config["db_user"];
            $password = $db_config["db_password"];
            $port = $db_config["db_port"];
            self::$pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $password);
        }
        return self::$pdo;
    }

}