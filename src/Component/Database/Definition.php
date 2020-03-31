<?php
namespace Dragon\Component\Database;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Definition
{
    /**
     * Databases input definition file
     */
    const SOURCE = Directory::DIRECTORY_CONFIG . "databases.php";

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
    public function get(): array
    {
        return $this->definitions;
    }

    private function validate(array $definitions)
    {
        foreach ($definitions as $database)
        {
            if (isset($database['handle']))
            {
                $_database = [];

                $_database['type']      = $database['type'] ?? "mysql";
                $_database['host']      = $database['host'] ?? null;
                $_database['port']      = $database['port'] ?? null;
                $_database['schema']    = $database['schema'] ?? null;
                $_database['user']      = $database['user'] ?? null;
                $_database['pass']      = $database['pass'] ?? null;
                $_database['charset']   = $database['charset'] ?? "utf8";
                $_database['prefix']    = $database['prefix'] ?? null;
                $_database['fetchMode'] = $database['fetch-mode'] ?? null; // TODO: array, assoc, object

                $this->definition[ $database['handle'] ] = $_database;
            }
        }
        
        return $this;
    }

}