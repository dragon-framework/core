<?php
namespace Dragon\Component\Security;

use Dragon\Component\FileSystem\FileSystem;

class Definition
{
    const DEFAULTS_RESOURCES = __DIR__ . DS . "Defaults.php";

    /**
     * Security definitions
     *
     * @var array
     */
    private $definitions = [];

    /**
     * FileSystem instance
     *
     * @var FileSystem
     */
    private $fs;

    public function __construct()
    {
        $this->fs = new FileSystem;
        $this->compile();
    }

    /**
     * Read config files and compile the config definition
     *
     * @return self
     */
    private function compile(): self
    {
        // Get default defintion
        $this->definitions = array_merge($this->definitions, $this->fs->include( self::DEFAULTS_RESOURCES ) ?? []);

        // Get app definition

        return $this;
    }

    /**
     * Return the compiled definition
     *
     * @return array
     */
    public function get( string $key )
    {
        return $this->definitions[ $key ] ?? null;
    }
}