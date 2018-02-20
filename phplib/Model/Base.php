<?php

/**
 * Base class that the ORM classes extend
 */
abstract class Model_Base {

    const FIELD_INT = 'int';
    const FIELD_STRING = 'string';
    const FIELD_EPOCH = 'epoch';
    const FIELD_BOOLEAN = 'boolean';

    /** @var string the name of the table. subclasses should override this. */
    const TABLE_NAME = "override me in subclasses";

    /** @var string the column name of the pk. subclasses should override this. */
    const PRIMARY_KEY = "override me in subclasses";

    private $fields = [];
    private $dirty_fields = [];

    /** @var boolean determines if ->store() should do an update or an insert */
    public $is_new = true;

    public final function __construct() {
        if (self::TABLE_NAME === static::TABLE_NAME) {
            throw new RuntimeException("Subclasses must override TABLE_NAME.");
        }
        if (self::PRIMARY_KEY === static::PRIMARY_KEY) {
            throw new RuntimeException("Subclasses must override PRIMARY_KEY.");
        }

        foreach (static::getTypeMap() as $field_name => $field_type) {
            $this->fields[$field_name] = null;
        }
    }

    /**
     * We use magic methods in order to support keeping track of "dirty fields"
     * @param string $field_name
     * @param mixed $field_value
     */
    public function __set($field_name, $field_value) {
        $should_dirty = true;
        if (!isset(static::getTypeMap()[$field_name])) {
            throw new RuntimeException("Trying to __set undeclared field: '$field_name' to " .
                "value: '$field_value'");
        }

        $this->fields[$field_name] = $field_value;

        if ($should_dirty) {
            $this->dirty_fields[] = $field_name;
        }
    }

    /**
     * We use magic methods in order to support keeping track of "dirty fields"
     * @param  string $field_name
     * @return mixed
     */
    public function __get($field_name) {
        if (!isset(static::getTypeMap()[$field_name])) {
            throw new RuntimeException("Trying to __get undeclared field: '$field_name'");
        }

        return $this->fields[$field_name];
    }

    /**
     * Store the model values in the DB
     * @return boolean true on success, false on failure
     * @todo : make all the pre-existing update statements undirty fields after executing?
     */
    public function store() {
        $model_class = get_class($this);
        $model_name = substr($model_class, 6);
        $finder_class = "Finder_$model_name";

        $pk = static::PRIMARY_KEY;
        $table = static::TABLE_NAME;

        if (!$this->is_new) {
            // we are doing an update
            if (!$this->dirty_fields) {
                return;
            }

            sort($this->dirty_fields);

            // TODO: probably not worth doing all this crap to make it a prepared statement...
            //      It will most likely only get used once, so no use saving it for future use.
            // TODO: I don't think we escape strings on update. Not that we are updating any strings
            //      at the moment, but still...
            list($query_name, $update_clause, $update_values) = array_reduce(
                $this->dirty_fields,
                function($carry, $field_name) {
                    $carry[0] .= "$field_name,";
                    $carry[1] .= "$field_name = :$field_name,";
                    $carry[2][":$field_name"] = $this->$field_name;
                    return $carry;
                },
                ["store_update_{$this->$pk}_", "", [":$pk" => $this->$pk]]
            );
            $query_name = rtrim($query_name, ",");
            $update_clause = rtrim($update_clause, ",");
            $query = "UPDATE $table SET $update_clause WHERE $pk = :$pk";

            $finder = $finder_class::getFinder();
            $finder->maybeRegisterManagedQuery($query_name, $query, [], Finder_Base::RETURN_NONE);
            $finder->doManagedQuery($query_name, $update_values);
        } else {
            // we are doing an insert
            $params = [];
            $now = time();
            foreach ($this->fields as $field_name => $field_value) {
                if ($field_name === $pk) {
                        if (!$field_value) {
                            $this->$pk = Orm_Tickets::getTicket();
                        }
                        $params[":$pk"] = $this->$pk;
                    continue;
                } else if (($field_name === "create_date" && !$this->create_date) ||
                    ($field_name === "update_date" && !$this->update_date)
                ) {
                    $params[":$field_name"] = $now;
                } else {
                    $params[":$field_name"] = Sanitize::unescape($field_value); // store unescaped values in the DB
                }
            }

            $finder_class::getFinder()->doManagedQuery("insertRecord", $params);
        }

        $this->undirtyFields();
        $this->is_new = false;
    }

    public function undirtyFields() {
        $this->dirty_fields = [];
    }

    /**
     * This defines the model's schema.
     * @return array
     */
    public static function getTypeMap() {
        throw new RuntimeException("Subclasses must override this.");
    }

}

/**
 * Base class that the Finder classes extend
 */
abstract class Finder_Base {

    const RETURN_MANY = 'return_many';
    const RETURN_SINGLE = 'return_single';
    const RETURN_COUNT = 'return_count';
    const RETURN_NONE = 'return_none';
    const RETURN_ARRAY = 'return_array'; // for ad-hoc array results that will not be mapped to a model instance.

    const QUERY_LIMIT = 'query_limit';
    const QUERY_OFFSET = 'query_offset';

    /** @var string regex for matching a sql update statement */
    const SQL_UPDATE_STATEMENT_REGEX = "/^(\s)*UPDATE(\s)+[^\s]+(\s)+SET(\s)+/i";

    /** @var string the name of the model class for this finder */
    private $model_class;

    /** @var Orm_ManagedQuery[] */
    private $managed_queries = [];

    /** @var Finder_Base[], singleton instances */
    private static $finders = [];

    private final function __construct() {
        $query = $this->getFindRecordSql();
        $this->registerManagedQuery("findRecord", $query, null, self::RETURN_SINGLE);

        $insert_query = $this->getInsertSql();
        $this->registerManagedQuery("insertRecord", $insert_query, null, self::RETURN_NONE);

        $this->registerManagedQueries();
    }

    /**
     * Maintains singleton instance
     * Example, to get the User finder, you could call this in one of three ways:
     *
     *    $finder = Finder_User::getFinder();
     *    $finder = Finder_Base::getFinder("User");
     *    $finder = Finder_Base::getFinder("Finder_User");
     *
     * @param string $class_name The class name of the finder you want to get.
     * @return Finder_Base
     */
    public static function getFinder($class_name = null) {
        if ($class_name) {
            if (!String_Util::startsWith("Finder_", $class_name)) {
                $class_name = "Finder_$class_name";
            }
        } else {
            $class_name = get_called_class();
        }
        if (!isset(self::$finders[$class_name])) {
            self::$finders[$class_name] = new $class_name();
        }
        return self::$finders[$class_name];
    }

    /**
     * Subclasses may override this to register their queries.
     * @return
     */
    protected function registerManagedQueries() {

    }

    public function getFindRecordSql() {
        $finder_class = get_class($this);
        $this->model_class = "Model" . substr($finder_class, 6);
        $model_class = $this->model_class;

        $table = $model_class::TABLE_NAME;
        $pk_column = $model_class::PRIMARY_KEY;
        $query = "SELECT * FROM $table WHERE $pk_column = :pk";
        return $query;
    }

    public function getInsertSql() {
        $finder_class = get_class($this);
        $this->model_class = "Model" . substr($finder_class, 6);
        $model_class = $this->model_class;

        $table = $model_class::TABLE_NAME;
        $pk_column = $model_class::PRIMARY_KEY;

        $update_fields = array();
        foreach ($model_class::getTypeMap() as $field_name => $field_value) {
            $update_fields[$field_name] = ":$field_name";
        }
        $insert_fields = $update_fields;

        $update_field_names = array_keys($update_fields);
        $insert_field_names = array_keys($insert_fields);

        $insert_field_names = "(" . implode(",", $insert_field_names) . ")";
        $insert_field_placeholders = "(" . implode(",", $insert_fields) . ")";
        $insert_query = "INSERT INTO $table $insert_field_names VALUES $insert_field_placeholders";
        return $insert_query;
    }

    /**
     * Find the unique record by its primary key
     * @param  mixed $pk the primary key
     * @return Model|null null if none found.
     */
    public function findRecord($pk) {
        return $this->doManagedQuery("findRecord", array(":pk" => $pk));
    }

    /**
     * Maybe register a managed query.
     * @param  string $name
     * @param  string $query sql with placeholders
     * @param  array $query_options used to specify LIMIT or OFFSET params.
     * @param  string $results_type the return type
     * @return boolean
     */
    public function maybeRegisterManagedQuery($name, $query, $query_options = [], $results_type = self::RETURN_MANY) {
        try {
            $this->registerManagedQuery($name, $query, $query_options, $results_type);
        } catch (Orm_ManagedQueryRegistrationException $e) {
            return false;
        }

        return true;
    }

    /**
     * Register a managed query.
     * @param  string $name
     * @param  string $query sql with placeholders
     * @param  array $query_options used to specify LIMIT or OFFSET params.
     * @param  string $results_type the return type
     */
    protected function registerManagedQuery($name, $query, $query_options = [], $results_type = self::RETURN_MANY)
    {
        if (isset($this->managed_queries[$name])) {
            throw new Orm_ManagedQueryRegistrationException("Managed query: $name has already been registered!");
        }

        $managed_query = new Orm_ManagedQuery();
        $managed_query->results_type = $results_type;

        if (is_array($query_options)) {
            if (isset($query_options['limit'])) {
                $query .= " LIMIT {$query_options['limit']}";
                $managed_query->limit = $query_options['limit'];
            }
            if (isset($query_options['offset'])) {
                $query .= " OFFSET {$query_options['offset']}";
                $managed_query->offset = $query_options['offset'];
            }
        }

        // automatically set the update_date for any UPDATE queries
        $query = preg_replace(self::SQL_UPDATE_STATEMENT_REGEX, '$0update_date = :update_date, ', $query);

        $pdo = Orm_Db::getPdo();

        $managed_query->statement = $pdo->prepare($query);
        if ($managed_query->statement === false) {
            throw new RuntimeException("Unable to prepare PDO statement");
        }

        $this->managed_queries[$name] = $managed_query;
    }

    /**
     * @param  string $query_name
     * @param  array $params sql params to be bound to the prepared statement
     * @return array|Model|null|int RETURN_MANY returns array, RETURN_SINGLE returns a Model or null,
     *                                          RETURN_COUNT returns an int, RETURN_NONE returns null.
     */
    public function doManagedQuery($query_name, array $params = array()) {
        $managed_query = $this->managed_queries[$query_name];
        $statement = $managed_query->statement;
        $results_type = $managed_query->results_type;

        if (preg_match(self::SQL_UPDATE_STATEMENT_REGEX, $statement->queryString)) {
            // automatically populate update_date for update statements
            $params[":update_date"] = time();
        }

        foreach ($params as $key => $value) {
            $data_type = PDO::PARAM_STR;
            if ($key == $managed_query->limit || $key == $managed_query->offset) {
                $data_type = PDO::PARAM_INT;
            }

            if ($statement->bindValue($key, $value, $data_type) === false) {
                throw new RuntimeException("Unable to bind key: $key to value: $value");
            }
        }

        $execute_result = $statement->execute();
        if ($execute_result === false) {
            throw new RuntimeException("Unable to execute PDO statement");
        }

        switch ($results_type) {
            case self::RETURN_MANY:
                $results = (array) $statement->fetchAll();
                $mapped_results = array();
                foreach ($results as $result) {
                    $mapped_results[] = $this->mapToModel($result);
                }
                return $mapped_results;
            case self::RETURN_SINGLE:
                $result = $statement->fetch();
                if (!$result) {
                    return null;
                }
                return $this->mapToModel((array) $result);
            case self::RETURN_COUNT:
                $results = $statement->fetchColumn();
                return (int) $results;
            case self::RETURN_NONE:
                return;
            case self::RETURN_ARRAY:
                return (array) $statement->fetchAll();
            default:
                throw new RuntimeException("Unsupported results_type: $results_type");
        }
    }

    /**
     * @param  array $result
     * @return Model|null
     */
    private function mapToModel($result) {
        if (!$result) {
            return null;
        }

        $model = new $this->model_class();
        $model->is_new = false;
        $model_class = $this->model_class;
        $model_type_map = $model_class::getTypeMap();

        foreach ($model_type_map as $field_name => $field_type) {
            switch ($field_type) {
                case Model_Base::FIELD_INT:
                case Model_Base::FIELD_EPOCH:
                    $model->$field_name = (int) $result[$field_name];
                    break;
                case Model_Base::FIELD_BOOLEAN:
                    $model->$field_name = (boolean) $result[$field_name];
                    break;
                case Model_Base::FIELD_STRING:
                    $model->$field_name = (string) Sanitize::escape($result[$field_name]);
                    break;
                default:
                    throw new RuntimeException("Unsupported model field type: $field_type");
            }
        }

        $model->undirtyFields();
        return $model;
    }

}
