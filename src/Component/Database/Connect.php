<?php
namespace Dragon\Component\Database;

use Dragon\Component\Database\Definition;

class Connect 
{
    /**
     * Database config definition
     *
     * @var array
     */
    private $definition;

    /**
     * Database Handle
     *
     * @var \PDO[]
     */
    private $dbh = [];

    public function __construct()
    {
        $this->definition = new Definition;
    }

    public function getDefinition(string $key)
    {
        return $this->definition->get( $key );
    }

    protected function getDbh(string $key)
    {
        if (!isset($this->dbh[$key]))
        {
            return $this->newDbh($key);
        }

        return $this->dbh[$key];
    }

    private function newDbh(string $key)
    {
        $config = $this->definition->get( $key );
        
        if ($config)
        {
            try {

                // Build the DSN
                // --

                // Database Type
                $dsn = $config['driver'].":";
    
                // Database Host
                $dsn.= "host=".$config['host'].";";
    
                // Database Name
                $dsn.= "dbname=".$config['schema'].";";
                
                // Database Port
                if (isset($config['port']))
                {
                    $dsn.= "port=".$config['port'].";";
                }
    
                // Database Charset
                if (isset($config['charset']))
                {
                    $dsn.= "charset=".$config['charset'].";";
                }
    
                
                // Make the DBH
                // --

                return $this->dbh[$key] = new \PDO($dsn, $config['user'], $config['pass']);
            }
            catch (\PDOException $e)
            {
                die( $e->getMessage() );
            }
        }
    }
}