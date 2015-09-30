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
            'create_date' => self::FIELD_EPOCH,
            'update_date' => self::FIELD_EPOCH,
        ];
    }
}

class Finder_User extends Finder_Base {

    /** @var int Hide confessions that have more than this many complaints */
    const COMPLAINT_HIDE_THRESHOLD = 2;

    /** @var string */
    const ORDER_BY_COMMENT_TIME = 'last_comment_date';

    /** @var string */
    const ORDER_BY_SECRET_TIME = 'create_date';

    /** @var string */
    const ORDER_BY_COMMENT_COUNT = 'comments';

    public function registerManagedQueries() {
        $table = Model_User::TABLE_NAME;

        $query = "SELECT * FROM $table WHERE user_name = :user_name";
        $this->registerManagedQuery("findByUserName", $query, null, self::RETURN_SINGLE);
    }

    /**
     * @param  string|int $user_name_or_id
     * @return Model_User
     */
    public function findByUserNameOrId($user_name_or_id) {
        $params = [
            ':user_name' => $user_name_or_id,
        ];

        $user = $this->doManagedQuery("findByUserName", $params);
        if (!$user) {
            $user = $this->findRecord($user_name_or_id);
        }
        return $user;
    }

}
