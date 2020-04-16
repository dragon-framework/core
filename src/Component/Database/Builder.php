<?php
namespace Dragon\Component\Database;

use Dragon\Component\Database\Statements;

class Builder 
{
    /**
     * Database statements
     *
     * @var array
     */
    protected $statements;

    /**
     * Database Handle
     *
     * @var \PDO
     */
    private $dbh = [];

    public function __construct()
    {
        // Get database statements
        $this->statements = new Statements;
    }

    /**
     * Get a statement parameters
     *
     * @param string $statement
     * @return array
     */
    public function getStatement(string $statement): ?array
    {
        return $this->statements->get( $statement );
    }

    /**
     * Return a database handle
     *
     * @param string $statement name of the statement
     * @return void
     */
    protected function getDbh(string $statement): \PDO
    {
        if (!isset($this->dbh[$statement]))
        {
            return $this->newDbh($statement);
        }

        return $this->dbh[$statement];
    }

    private function newDbh(string $key)
    {
        $config = $this->getStatement( $key );

        if ($config)
        {
            try {

                // Build the DSN
                // --

                // Database Type
                $dsn = $config[ Statements::PARAM_DRIVER ].":";
    
                // Database Host
                $dsn.= "host=".$config[ Statements::PARAM_HOST ].";";
    
                // Database Name
                $dsn.= "dbname=".$config[ Statements::PARAM_DBNAME ].";";
                
                // Database Port
                if (isset($config[ Statements::PARAM_PORT ]))
                {
                    $dsn.= "port=".$config[ Statements::PARAM_PORT ].";";
                }
    
                // Database Charset
                if (isset($config[ Statements::PARAM_CHARSET ]))
                {
                    $dsn.= "charset=".$config[ Statements::PARAM_CHARSET ].";";
                }
    
                
                // Make the DBH
                // --

                return $this->dbh[$key] = new \PDO($dsn, $config[ Statements::PARAM_USER ], $config[ Statements::PARAM_PASS ]);
            }
            catch (\PDOException $e)
            {
                die( $e->getMessage() );
            }
        }
    }
}