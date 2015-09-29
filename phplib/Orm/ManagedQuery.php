<?

class Orm_ManagedQuery {

    /** @var PDOStatement */
    public $statement;

    /**
     * One of the Finder constants, i.e. Finder::RETURN_MANY
     * @var string
     */
    public $results_type;

    /** @var int */
    public $limit;

    /** @var int */
    public $offset;

}
