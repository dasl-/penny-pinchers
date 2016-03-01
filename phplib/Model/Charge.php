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

    const MIN_CHARGE_DATE = 0;
    const MAX_CHARGE_DATE = 2147483647; // MySQL signed int max.

    protected function registerManagedQueries() {
        $table = Model_Charge::TABLE_NAME;
        $query = "SELECT * FROM $table WHERE user_id = :user_id AND charge_date >= :start_date AND " .
            "charge_date <= :end_date ORDER BY charge_date ASC";
        $this->registerManagedQuery("findByUserIdAndChargeDates", $query, null, self::RETURN_MANY);

        $query = "DELETE FROM $table WHERE charge_id = :charge_id";
        $this->registerManagedQuery("delete", $query, null, self::RETURN_NONE);

        $query = "SELECT user_id, sum(amount) as total_charges FROM $table WHERE " .
            "charge_date >= :start_date AND charge_date <= :end_date GROUP BY user_id";
        $this->registerManagedQuery("findTotalChargesByUserIdForChargeDates", $query, null, self::RETURN_ARRAY);

        $query = "SELECT * FROM $table ORDER BY create_date DESC LIMIT 10";
        $this->registerManagedQuery("findRecentlyAddedCharges", $query);
    }

    /**
     * Use $start_date and $end_date to only find charges between those dates.
     * One or both can be null, in which it is unlimited in that direction.
     * @param  int $user_id
     * @param int $start_date
     * @param int $end_date
     * @return Model_Charge[]
     */
    public function findByUserIdAndChargeDates($user_id, $start_date = null, $end_date = null) {
        if ($start_date === null) {
            $start_date = self::MIN_CHARGE_DATE;
        }
        if ($end_date === null) {
            $end_date = self::MAX_CHARGE_DATE;
        }
        $params = [
            ":user_id" => $user_id,
            ":start_date" => $start_date,
            ":end_date" => $end_date,
        ];
        return $this->doManagedQuery("findByUserIdAndChargeDates", $params);
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
     * Use $start_date and $end_date to only find charges between those dates.
     * One or both can be null, in which it is unlimited in that direction.
     * @param int $start_date
     * @param int $end_date
     * @return array
     */
    public function findTotalChargesPerPersonByUserIdForChargeDates($start_date = null, $end_date = null) {
        if ($start_date === null) {
            $start_date = self::MIN_CHARGE_DATE;
        }
        if ($end_date === null) {
            $end_date = self::MAX_CHARGE_DATE;
        }
        $params = [
            ":start_date" => $start_date,
            ":end_date" => $end_date,
        ];
        $charges = $this->doManagedQuery("findTotalChargesByUserIdForChargeDates", $params);
        $total_charges_by_user_id = [];
        foreach ($charges as $user_info) {
            $user_id = $user_info["user_id"];
            if ($user_id == 107) {
                $total_charges = $user_info["total_charges"] / 2; // Jamie and Elara
            } else {
                $total_charges = $user_info["total_charges"];
            }
            $total_charges_by_user_id[$user_id] = $total_charges;
        }
        return $total_charges_by_user_id;
    }

    public function findRecentlyAddedCharges() {
        return $this->doManagedQuery("findRecentlyAddedCharges");
    }

}
