<?

class Model_User extends Model_Base {

    /** @var string the name of the table */
    const TABLE_NAME = "users";

    /** @var string the column name of the pk. */
    const PRIMARY_KEY = "user_id";

    /**
     * This defines the model's schema.
     * @return array
     */
    public static function getTypeMap() {
        return [
            'user_id' => self::FIELD_INT,
            'user_name' => self::FIELD_STRING,
            'password_hash' => self::FIELD_STRING,
            'create_date' => self::FIELD_EPOCH,
            'update_date' => self::FIELD_EPOCH,
        ];
    }
}

class Finder_User extends Finder_Base {

    const ORDER_BY_USER_NAME_ASC = "order_by_user_name_asc";

    public function registerManagedQueries() {
        $table = Model_User::TABLE_NAME;

        $query = "SELECT * FROM $table WHERE user_name = :user_name";
        $this->registerManagedQuery("findByUserName", $query, null, self::RETURN_SINGLE);

        $query = "SELECT * FROM $table ORDER BY user_name ASC";
        $this->registerManagedQuery("findAllOrderByUserNameAsc", $query, null, self::RETURN_MANY);
    }

    /**
     * @param  string|int $user_name_or_id
     * @return Model_User
     */
    public function findByUserNameOrId($user_name_or_id) {
        $user = $this->findByUserName($user_name_or_id);
        if (!$user) {
            $user = $this->findRecord($user_name_or_id);
        }
        return $user;
    }

    /**
     * @param  string $user_name
     * @return Model_User
     */
    public function findByUserName($user_name) {
        $params = [
            ':user_name' => $user_name,
        ];

        $user = $this->doManagedQuery("findByUserName", $params);
        return $user;
    }

    public function findAll($order_by = self::ORDER_BY_USER_NAME_ASC) {
        switch ($order_by) {
            default:
                $query = "findAllOrderByUserNameAsc";
                break;
        }
        return $this->doManagedQuery($query);
    }

}
