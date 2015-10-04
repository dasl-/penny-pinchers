<?

class Model_Session extends Model_Base {

    /** @var string the name of the table */
    const TABLE_NAME = "sessions";

    /** @var string the column name of the pk. */
    const PRIMARY_KEY = "session_id";

    /**
     * This defines the model's schema.
     * @return array
     */
    public static function getTypeMap() {
        return [
            'session_id' => self::FIELD_INT,
            'user_id' => self::FIELD_INT,
            'session_string' => self::FIELD_STRING,
            'create_date' => self::FIELD_EPOCH,
            'update_date' => self::FIELD_EPOCH,
        ];
    }

    /**
     * @param  int $user_id
     * @return Model_Session
     */
    public static function createNew($user_id) {
        $session = new self();
        $session->user_id = $user_id;
        $session->session_string = self::getSessionString();
        $session->store();
        return $session;
    }
    /**
     * @return string
     */
    private static function getSessionString() {
        $length = 150;
        $random_bytes = openssl_random_pseudo_bytes($length, $is_crypto_strong);
        if (!$is_crypto_strong) {
            throw new RuntimeException(
                "Unable to use crypotographically strong algorithm to generate session string."
            );
        }
        $random_hex = bin2hex($random_bytes);
        return $random_hex;
    }
}

class Finder_Session extends Finder_Base {

    public function registerManagedQueries() {
        $table = Model_Session::TABLE_NAME;

        $query = "SELECT * FROM $table WHERE user_id = :user_id AND session_string = :session_string";
        $this->registerManagedQuery("findByUserIdAndSessionString", $query, null, self::RETURN_SINGLE);

        $query = "DELETE FROM $table WHERE session_id = :session_id";
        $this->registerManagedQuery("delete", $query, null, self::RETURN_NONE);
    }

    /**
     * @param  int $user_id
     * @param  string $session_string
     * @return Model_Session
     */
    public function findByUserIdAndSessionString($user_id, $session_string) {
        $params = [
            ':user_id' => $user_id,
            ':session_string' => $session_string,
        ];

        $session = $this->doManagedQuery("findByUserIdAndSessionString", $params);
        return $session;
    }

    /**
     * @param  int $session_id
     */
    public function delete($session_id) {
        $params = [
            ':session_id' => $session_id,
        ];
        $this->doManagedQuery("delete", $params);
    }

}
