<?php
namespace Dragon\Component\Database;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Definition
{
    /**
     * Databases input definition file
     */
    const SOURCE = Directory::DIRECTORY_APP_CONFIG . "databases.php";

    /**
     * Database final definition
     *
     * @var array
     */
    private $definitions = [];

    public function __construct()
    {
        $this->set();
    }

    /**
     * Database definition setter
     *
     * @return self
     */
    private function set(): self
    {
        $fs = new FileSystem;
        
        if ($fs->isFile(self::SOURCE))
        {
            $this->definitions = $this->validate( $fs->include( self::SOURCE ) ?? [] );
        }
        
        return $this;
    }
    
    /**
     * Database definition getter
     *
     * @return array
     */
    public function get(string $key)
    {
        if (isset($this->definitions[$key]))
        {
            return $this->definitions[$key];
        }
        
        return false;
    }

    public function getAll()
    {
        return $this->definitions;
    }

    /**
     * Database config validation
     *
     * @param array $definitions
     * @return array
     */
    private function validate(array $definitions): array
    {
        $output = [];

        foreach ($definitions as $database)
        {
            if (isset($database['statement']))
            {
                $_database = [];

                $_database['driver']    = $database['driver'] ?? "mysql";
                $_database['host']      = $database['host'] ?? null;
                $_database['port']      = $database['port'] ?? null;
                $_database['schema']    = $database['schema'] ?? null;
                $_database['user']      = $database['user'] ?? null;
                $_database['pass']      = $database['pass'] ?? null;
                $_database['charset']   = $database['charset'] ?? "utf8";
                $_database['prefix']    = $database['prefix'] ?? null;
                $_database['fetchMode'] = $database['fetch-mode'] ?? null; // TODO: array, assoc, object

                $output[ $database['statement'] ] = $_database;
            }
        }
        
        return $output;
    }

}