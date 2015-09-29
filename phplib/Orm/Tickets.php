<?

class Orm_Tickets {

    const TICKETS_TABLE_NAME = "tickets";

    /** @var PDO */
    private static $tickets_pdo;

    /** @var PDOStatement */
    private static $replace_statement;

    /** @var PDOStatement */
    private static $select_statement;

    /**
     * @return int
     */
    public static function getTicket() {
        $pdo = self::getPreparedPdo();
        self::$replace_statement->execute();
        self::$select_statement->execute();

        $ticket = (int) self::$select_statement->fetchColumn();
        if ($ticket === 0) {
            throw new RuntimeException("Unable to get ticket from ticket server!");
        }

        return $ticket;
    }

    /**
     * @return PDO
     */
    private static function getPreparedPdo() {
        if (self::$tickets_pdo === null) {
            self::$tickets_pdo = Db::getPdo();
            self::preparePdo();
        }

        return self::$tickets_pdo;
    }

    private static function preparePdo() {
        $pdo = self::$tickets_pdo;

        $tickets_table_name = self::TICKETS_TABLE_NAME;
        $sql = "REPLACE INTO $tickets_table_name (stub) VALUES ('a');";
        self::$replace_statement = $pdo->prepare($sql);
        if (self::$replace_statement === false) {
            throw new RuntimeException("Unable to prepare PDO statement");
        }

        $sql = "SELECT LAST_INSERT_ID();";
        self::$select_statement = $pdo->prepare($sql);
        if (self::$select_statement === false) {
            throw new RuntimeException("Unable to prepare PDO statement");
        }
    }

}