<?

class Model_Charge extends Model {

    /** @var string the name of the table */
    const TABLE_NAME = "charges";

    /** @var string the column name of the pk. */
    const PRIMARY_KEY = "charge_id";

    /**
     * This defines the model's schema.
     * @return array
     */
    public static function getTypeMap() {
        return [
            'charge_id' => self::FIELD_INT,
            'user_id' => self::FIELD_INT,
            'amount' => self::FIELD_INT,
            'description' => self::FIELD_STRING,
            'charge_date' => self::FIELD_EPOCH,
            'create_date' => self::FIELD_EPOCH,
            'update_date' => self::FIELD_EPOCH,
        ];
    }
}

class Finder_Charge extends Finder {

    public function __construct() {
        parent::__construct();

        $table = Model_Charge::TABLE_NAME;
        $query = "SELECT * FROM $table WHERE user_id = :user_id";
        $this->registerManagedQuery("findByUserId", $query, null, self::RETURN_MANY);

        $query = "DELETE FROM $table WHERE charge_id = :charge_id";
        $this->registerManagedQuery("delete", $query, null, self::RETURN_NONE);
    }

    /**
     * @param  int $user_id
     * @return Model_Charge[]
     */
    public function findByUserId($user_id) {
        $params = [
            ':user_id' => $user_id,
        ];
        return $this->doManagedQuery("findByUserId", $params);
    }

    /**
     * Delete the charge.
     * @param int $charge_id
     */
    public function delete($charge_id) {
        $params = array(
            ':charge_id' => $charge_id,
        );

        $this->doManagedQuery("delete", $params);
    }

}
