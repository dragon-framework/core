<?php
namespace Dragon\Component\Database;

use PDO;

abstract class Query 
{
    const STATEMENT         = "main";
    const ORDER_BY          = "orderBy";
    const ORDER_DIR         = "orderDir";
    const LIMIT             = "limit";
    const OFFSET            = "offset";
    const AND               = "AND";
    const OR                = "OR";

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

    /**
     * Database Statement Definition
     * it's The value of the "statement" parameter in the database conf.
     *
     * @var string
     */
    private $dsd = self::STATEMENT;

    /**
     * Table name
     *
     * @var string
     */
    private $table;

    public function __construct()
    {
		$this->setTableFromClassName();
    }

    /**
     * Set teh Database Statement Definition
     *
     * @param string $dsd
     * @return self
     */
    public function setDatabaseStatementDefinition(string $dsd): self
    {
        $this->dsd = $dsd;

        return $this;
    }

    /**
     * Ret the Database Handle ($dbh)
     *
     * @return void
     */
    private function dbh()
    {
        return getApp()->database()->dbh( $this->dsd );
    }

    /**
     * Define the table name
     *
     * @return self
     */
    private function setTableFromClassName(): self
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

        $tablePrefix = getApp()->database()->getDefinition( $this->dsd )['prefix'];

        $this->table = $tablePrefix . $tableName;
        
        return $this;
    }





    public function find($id)
    {
        dump("Query Find ....");
    }

    /**
     * Faind All
     *
     * @param array|null $options
     * @return void
     */
    public function findAll(?array $options=[])
    {
        // Merge defaulyt options
        $options = array_merge([
            self::ORDER_BY  => '',
            self::ORDER_DIR => 'ASC',
            self::LIMIT     => null,
            self::OFFSET    => null,
        ], $options);

        // SQL definition
        $sql = 'SELECT * FROM '. $this->table;

        if (!empty($options[self::ORDER_BY]))
        {
            if(!preg_match('#^[a-zA-Z0-9_$]+$#', $options[self::ORDER_BY]))
            {
				die('Error: invalid orderBy param');
            }
            
			$orderDir = strtoupper($options[self::ORDER_DIR]);
            if($orderDir != 'ASC' && $orderDir != 'DESC')
            {
				die('Error: invalid orderDir param');
            }
            
            if ($options[self::LIMIT] && !is_int($options[self::LIMIT]))
            {
				die('Error: invalid limit param');
            }
            
            if ($options[self::OFFSET] && !is_int($options[self::OFFSET]))
            {
				die('Error: invalid offset param');
			}

            $sql .= ' ORDER BY '.$options[self::ORDER_BY].' '.$options[self::ORDER_DIR];
            
        }

        if ($options[self::LIMIT])
        {
            $sql .= ' LIMIT '.$options[self::LIMIT];
            
            if($options[self::OFFSET])
            {
                $sql .= ' OFFSET '.$options[self::OFFSET];
            }
        }

        // Query fetch mode
        $fetchMode = getApp()->database()->getDefinition( $this->dsd )['fetchMode'];

        $sth = $this->dbh()->prepare($sql);
        $sth->execute();

        return $sth->fetchAll( $fetchMode );
    }

    public function findBy()
    {
        dump("Abstract Model Query Find By ....");
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
}