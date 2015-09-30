<?php

class Model_Charge extends Model_Base {

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

class Finder_Charge extends Finder_Base {

    protected function registerManagedQueries() {
        $table = Model_Charge::TABLE_NAME;
        $query = "SELECT * FROM $table WHERE user_id = :user_id";
        $this->registerManagedQuery("findByUserId", $query, null, self::RETURN_MANY);

        $query = "DELETE FROM $table WHERE charge_id = :charge_id";
        $this->registerManagedQuery("delete", $query, null, self::RETURN_NONE);

        $query = "SELECT user_id, sum(amount) as total_charges FROM $table GROUP BY user_id";
        $this->registerManagedQuery("findTotalChargesByUserId", $query, null, self::RETURN_ARRAY);
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

    /**
     * Find sum of all charges grouped by user_id
     * @return array
     */
    public function findTotalChargesByUserId() {

        $charges = $this->doManagedQuery("findTotalChargesByUserId");
        $total_charges_by_user_id = [];
        foreach ($charges as $user_info) {
            $user_id = $user_info["user_id"];
            $total_charges = $user_info["total_charges"];
            $total_charges_by_user_id[$user_id] = $total_charges;
        }
        return $total_charges_by_user_id;
    }

}
