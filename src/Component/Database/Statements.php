<?php
namespace Dragon\Component\Database;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Statements
{
    const PARAM_STATEMENT   = "statement";
    const PARAM_DRIVER      = "driver";
    const PARAM_HOST        = "host";
    const PARAM_PORT        = "port";
    const PARAM_DBNAME      = "dbname";
    const PARAM_UNIXSOCKET  = "unixsocket";
    const PARAM_USER        = "user";
    const PARAM_PASS        = "pass";
    const PARAM_CHARSET     = "charset";
    const PARAM_PREFIX      = "prefix";
    const PARAM_FETCHMODE   = "fetchmode";

    /**
     * Database final definition
     *
     * @var array
     */
    private $statements = [];

    public function __construct()
    {
        $fs = new FileSystem;

        $this->statements = $this->validate( $fs->include( Directory::DIRECTORY_APP_CONFIG . "databases/databases.php" ) ?? [] );
    }

    /**
     * Database config validation
     *
     * @param array $statements
     * @return array
     */
    private function validate(array $statements): array
    {
        $output = [];

        foreach ($statements as $statement)
        {
            if (isset($statement[ self::PARAM_STATEMENT ]))
            {
                $_statement = [];

                $_statement[ self::PARAM_DRIVER ]    = $statement[ self::PARAM_DRIVER ] ?? "mysql";
                $_statement[ self::PARAM_HOST ]      = $statement[ self::PARAM_HOST ] ?? null;
                $_statement[ self::PARAM_PORT ]      = $statement[ self::PARAM_PORT ] ?? null;
                $_statement[ self::PARAM_DBNAME ]    = $statement[ self::PARAM_DBNAME ] ?? null;
                $_statement[ self::PARAM_USER ]      = $statement[ self::PARAM_USER ] ?? null;
                $_statement[ self::PARAM_PASS ]      = $statement[ self::PARAM_PASS ] ?? null;
                $_statement[ self::PARAM_CHARSET ]   = $statement[ self::PARAM_CHARSET ] ?? "utf8";
                $_statement[ self::PARAM_PREFIX ]    = $statement[ self::PARAM_PREFIX ] ?? null;
                $_statement[ self::PARAM_FETCHMODE ] = $statement[ self::PARAM_FETCHMODE ] ?? null; // TODO: array, assoc, object

                $output[ $statement[ self::PARAM_STATEMENT ] ] = $_statement;
            }
        }

        return $output;
    }
    
    /**
     * Get one statement
     *
     * @return array
     */
    public function get(string $statement): ?array
    {
        return $this->statements[$statement] ?? null;
    }

    /**
     * Return true if config has statement
     *
     * @return boolean
     */
    public function hasStatement(): bool
    {
        return !empty($this->statements);
    }

    /**
     * Return true if statement is valid (defined in config/database.php)
     *
     * @param string $statement name
     * @return boolean
     */
    public function isValid(string $statement): bool
    {
        return isset($this->statements[$statement]);
    }

}
