<?php

class Model_Thought extends Model_Base {
    const TABLE_NAME = 'thoughts';
    const PRIMARY_KEY = 'thought_id';

    public static function getTypeMap() {
        return [
            'thought_id' => self::FIELD_INT,
            'user_id' => self::FIELD_INT,
            'charge_id' => self::FIELD_INT,
            'title' => self::FIELD_STRING,
            'text' => self::FIELD_STRING,
            'upvotes' => self::FIELD_INT,
            'deleted' => self::FIELD_BOOLEAN,
            'create_date' => self::FIELD_EPOCH,
            'update_date' => self::FIELD_EPOCH,
        ];
    }
}

class Finder_Thought extends Finder_Base {
    protected function registerManagedQueries() {
        $table = Model_Thought::TABLE_NAME;

        $query = "SELECT * FROM $table ORDER BY create_date DESC";
        $this->registerManagedQuery('findRecentThoughts', $query, ['limit' => 10]);

        $query = "SELECT * FROM $table WHERE charge_id=:charge_id ORDER BY create_date DESC";
        $this->registerManagedQuery('findRecentThoughtsForChargeId', $query);
    }

    public function findRecentThoughts() {
        return $this->doManagedQuery('findRecentThoughts');
    }

    public function findRecentThoughtsForChargeId($charge_id) {
        $params = [
            ':charge_id' => $charge_id,
        ];

        return $this->doManagedQuery('findRecentThoughtsForChargeId', $params);
    }
}