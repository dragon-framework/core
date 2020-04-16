<?php
namespace Dragon\Component\Database;

use PDO;
use Dragon\Component\Database\Statements;

abstract class Query 
{
    /**
     * Default statement name
     * 
     * @var string
     */
    const STATEMENT         = "main";

    /**
     * Select Distinct
     * 
     * @var string
     */
    const DISTINCT          = "disctinct";

    /**
     * Criteria for WHERE
     */
    const CRITERIAS         = "criterias";

    /**
     * Columns for SELECT
     */
    const COLUMNS           = "columns";

    /**
     * Order By
     */
    const ORDERBY           = "orderBy";
    const ORDERDIR_ASC      = "ASC";
    const ORDERDIR_DESC     = "DESC";
    const LIMIT             = "limit";
    const OFFSET            = "offset";
    const RELATION          = "relation";
    
    const RELATION_AND      = "AND";
    const RELATION_OR       = "OR";

    const EQUAL             = "=";
    const GREATER_THAN      = ">";
    const LESS_THAN         = "<";
    const GREATER_OR_EQUAL  = ">=";
    const LESS_OR_EQUAL     = "<=";
    const NOT_EQUAL         = "<>";
    const NOT               = "!=";

    const BINDING_VALUE     = "bindValue";
    const BINDING_PARAM     = "bindParam";

    const FETCH_LAZY        = \PDO::FETCH_LAZY;
    const FETCH_ASSOC       = \PDO::FETCH_ASSOC;
    const FETCH_NAMED       = \PDO::FETCH_NAMED;
    const FETCH_NUM         = \PDO::FETCH_NUM;
    const FETCH_BOTH        = \PDO::FETCH_BOTH;
    const FETCH_OBJ         = \PDO::FETCH_OBJ;
    const FETCH_BOUND       = \PDO::FETCH_BOUND;
    const FETCH_COLUMN      = \PDO::FETCH_COLUMN;
    const FETCH_CLASS       = \PDO::FETCH_CLASS;
    const FETCH_INTO        = \PDO::FETCH_INTO;
    const FETCH_FUNC        = \PDO::FETCH_FUNC;
    const FETCH_GROUP       = \PDO::FETCH_GROUP;
    const FETCH_UNIQUE      = \PDO::FETCH_UNIQUE;
    const FETCH_KEY_PAIR    = \PDO::FETCH_KEY_PAIR;
    const FETCH_CLASSTYPE   = \PDO::FETCH_CLASSTYPE;
    const FETCH_SERIALIZE   = \PDO::FETCH_SERIALIZE;
    const FETCH_PROPS_LATE  = \PDO::FETCH_PROPS_LATE;

    const PARAM_BOOL        = \PDO::PARAM_BOOL; 
    const PARAM_LOB         = \PDO::PARAM_LOB; 
    const PARAM_INT         = \PDO::PARAM_INT; 
    const PARAM_NULL        = \PDO::PARAM_NULL; 
    const PARAM_STR         = \PDO::PARAM_STR; 

    /**
     * Database Statement Definition
     * it's The value of the "statement" parameter in the database conf.
     *
     * @var string
     */
    private $statementId = self::STATEMENT;

    /**
     * Current statement parameters (defined in config/database.php)
     *
     * @var array
     */
    private $statement;

    /**
     * Table name
     *
     * @var string
     */
    private $table;

    /**
     * The database bridge
     *
     * @var array
     */
    private $bridge;

    /**
     * Table prefix
     *
     * @var string
     */
    private $prefix;

    private $fetchMode;

    /**
     * Query Options
     *
     * @var array
     */
    private $options;

    public function __construct()
    {
        // Get the database bridge
        $this->bridge = getApp()->database();

        if (!$this->bridge->hasStatement())
        {
            // Exception appear if user try to execute query with no statement parameters
            throw new \Exception("No database statement...");
        }
    }

    /**
     * Set the Database Statement
     *
     * @param string $statementId
     * @return self
     */
    public function setStatementId(string $statementId): self
    {
        if (!$this->bridge->isValidStatement($statementId))
        {
            // Appear when the statement name is not defined in config/database.php
            throw new \Exception("The database statement name \"$statementId\" is not valid.");
        }

        $this->statementId = $statementId;

        return $this;
    }

    protected function preFetch()
    {
        // Set the current statement
        $this->setStatement();

        // set the table prefix
        $this->setPrefix();

        // Set the table name from class call
        $this->setTableByClass();

        $this->setFetchMode();
    }

    /**
     * Set the current statement (params)
     *
     * @return self
     */
    private function setStatement(): self
    {
        $this->statement = $this->bridge->getStatement( $this->statementId );

        return $this;
    }

    /**
     * Set the table prefix
     *
     * @return self
     */
    private function setPrefix(): self
    {
        $this->prefix = $this->statement['prefix'];

        return $this;
    }

    /**
     * Automatically Define the table name
     *
     * @return self
     */
    private function setTableByClass(): self
    {
        if (empty($this->table))
        {
			$className = get_class($this);

			$tableName = str_replace('Model', '', $className);
			$tableName = explode('\\', $tableName);
			$tableName = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', end($tableName))), '_');
        }
        else
        {
			$tableName = $this->table;
        }

        $this->table = $this->prefix . $tableName;
        
        return $this;
    }

    /**
     * Redefine the table
     *
     * @param string $name
     * @return self
     */
    public function setTable(string $name): self
    {
        $this->table = $this->prefix . $name;

        return $this;
    }

    /**
     * Set fetch mode
     *
     * @return self
     */
    private function setFetchMode(): self
    {
        $this->fetchMode = $this->statement[ Statements::PARAM_FETCHMODE];

        return $this;
    }

    /**
     * Set the Database Handle ($dbh)
     *
     * @return void
     */
    private function dbh()
    {
        return $this->bridge->dbh( $this->statementId );
    }


    // Query Methods
    // --

    /**
     * Find One by ID
     *
     * @param integer $id
     * @return void
     */
    public function find(int $id, ?array $columns=null)
    {
        return $this->findBy([[
            'key'       => "id",
            'value'     => $id,
            'type'      => Query::PARAM_INT,
            'relation'  => Query::EQUAL,
        ]], null, $columns);
    }

    /**
     * Find One by params
     *
     * @return void
     */
    public function findBy(array $criterias, ?string $relation=self::RELATION_AND, ?array $columns=null)
    {
        return $this->findAll([
            self::CRITERIAS => $criterias,
            self::RELATION  => $relation,
            self::COLUMNS   => $columns
        ], true);
    }

    public function findAll(?array $options=[], $single=false)
    {
        $this->preFetch();

        $options = array_merge([
            self::DISTINCT  => false,
            self::COLUMNS   => [],
            self::CRITERIAS => [],
            self::RELATION  => self::RELATION_AND,
            self::ORDERBY   => [],
            self::LIMIT     => null,
            self::OFFSET    => null,
        ], $options);

        // dump( $options );

        // Format SQL parts
        $columns = $this->format_SelectColumns($options[ self::COLUMNS ]);
        $criterias = $this->format_WhereCriteria($options[ self::CRITERIAS ]);

        // Define SQL
        $sql = $this->Select( $columns, $options[ self::DISTINCT ] );
        $sql.= $this->From( $this->table );
        $sql.= $this->Where( $criterias, $options[ self::RELATION ] );
        $sql.= $this->OrderBy( $options[ self::ORDERBY ] );
        $sql.= $this->Limit( $options[ self::LIMIT ], $options[ self::OFFSET ] );

        // Sql Qtatement
        $stmt = $this->dbh()->prepare($sql);

        // Binding values
        foreach ($criterias as $criteria)
        {
            $stmt->bindValue(":".$criteria['key'], $criteria['value'], $criteria['type']);
        }

        // Execute the query
        $stmt->execute();

        return $single 
            ? $stmt->fetch( $this->fetchMode ) 
            : $stmt->fetchAll( $this->fetchMode )
        ;
    }


    

    private function format_SelectColumns(?array $columns)
    {
        $str = null;

        if (is_array($columns))
        {
            foreach ($columns as $column)
            {
                if (!empty($str))
                {
                    $str.= ", ";
                }

                $str.= "`$column`";
            }
        }

        return $str ?? "*";
    }

    private function format_WhereCriteria(?array $criterias): array
    {
        $defaults = [
            'key'       => null,
            'value'     => null,
            'type'      => null,
            'relation'  => self::EQUAL
        ];

        foreach ($criterias as $key => $value)
        {
            if (is_array($value))
            {
                $criterias[$key] = array_merge($defaults, $value);
            }
            else
            {
                array_push($criterias, array_merge($defaults, [
                    'key' => $key,
                    'value' => $value,
                ]));

                unset($criterias[$key]);
            }
        }

        return $criterias;
    }


    // SQL Parts

    /**
     * Generate Select
     *
     * @param array $options
     * @return string
     */
    private function Select(string $columns, bool $distinct=false): string
    {
        $str = "SELECT ";

        if ($distinct)
        {
            $str.= "DISTINCT ";
        }

        $str.= $columns;

        return $str;
    }

    /**
     * Set From part
     *
     * @return void
     */
    private function From(string $table): string
    {
        return " FROM `$table`";
    }

    /**
     * Build the string for WHERE Part
     *
     * @param array $criterias
     * @return string
     */
    private function Where(array $criterias, ?string $relation=null): ?string
    {
        $str = null;

        $relation = $relation ?? self::RELATION_AND;

        foreach ($criterias as $key => $value)
        {
            if (!empty($str))
            {
                $str.= " ".$relation." ";
            }

            $key = $value['key'];
            $rel = $value['relation'];

            $str.= "`$key` $rel :$key";
            
        }
    
        if (!empty($str))
        {
            $str = " WHERE ".$str;
        }

        return $str;
    }

    /**
     * Generate Order By clause
     *
     * @param array $options
     * @return string
     */
    private function OrderBy($orderBy): string
    {
        $str = "";
        
        if (!is_array($orderBy))
        {
            $orderBy = [$orderBy => self::ORDERDIR_ASC];
        }

        foreach ($orderBy as $column => $direction)
        {
            // If $orderBy is a numerical array
            if (is_int($column) && $direction != self::ORDERDIR_ASC && $direction != self::ORDERDIR_DESC)
            {
                $column = $direction;
                $direction = self::ORDERDIR_ASC;
            }

            $direction = strtoupper($direction);

            if($direction != self::ORDERDIR_ASC && $direction != self::ORDERDIR_DESC)
            {
                die('Error: invalid orderDir param');
            }

            if (!empty($str))
            {
                $str.= ", ";
            }
            $str.= "`$column` $direction";
        }

        if (!empty($str))
        {
            $str = " ORDER BY ".$str;
        }

        return $str;
    }

    /**
     * Generate Limit and Offset Clauses
     *
     * @param array $options
     * @return string
     */
    private function Limit(?int $limit, ?int $offset): string
    {
        $str = "";

        if (null != $limit && !is_int($limit))
        {
            die('Error: invalid limit param');
        }
        
        if (null != $offset && !is_int($offset))
        {
            die('Error: invalid offset param');
        }
        
        if ($limit)
        {
            $str .= ' LIMIT '.$limit;
            
            if($offset)
            {
                $str .= ' OFFSET '.$offset;
            }
        }

        return $str;
    }












    public function search()
    {
        dump("Abstract Model Query Search ....");
    }

    public function delete()
    {
        dump("Abstract Model Query Delete ....");
    }

    public function insert()
    {
        dump("Abstract Model Query Insert ....");
    }

    public function update()
    {
        dump("Abstract Model Query Update ....");
    }

    public function count()
    {
        dump("Abstract Model Query Count ....");
    }



















    private function bindValues($sth, array $values): self
    {
        foreach ($values as $key => $value)
        {
            $sth->bindValue(":$key", $value);
        }

        return $this;
    }
    private function bindParams($sth, array $values): self
    {
        foreach ($values as $key => $value)
        {
            $sth->bindParam(":$key", $value);
        }

        return $this;
    }
}
