<?php
namespace Dragon\Component\Config\Builder;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Builder
{
    /**
     * Config filename
     */
    const FILE_CONFIG       = Directory::DIRECTORY_CONFIG . "config.php";
    const FILE_CONFIG_DEV   = Directory::DIRECTORY_CONFIG . "config-dev.php";
    const FILE_CONFIG_TEST  = Directory::DIRECTORY_CONFIG . "config-test.php";

    /**
     * The App config
     *
     * @var array
     */
    private $conf = [];

    public function __construct()
    {
        $this->compile();
    }

    /**
     * Retrieve and compile config definition
     *
     * @return self
     */
    private function compile(): self
    {
        $fs = new FileSystem;

        $this
            // Default Dragon config
            ->merge( $fs->include( __DIR__ . "/../Resources/Config.php" ) ?? [] )

            // // Custom config
            ->merge( $fs->include( self::FILE_CONFIG ) ?? [] )

            // DevEnv config
            ->merge( $fs->include( self::FILE_CONFIG_DEV ) ?? [])

            // TestEnv Config
            ->merge( $fs->include( self::FILE_CONFIG_TEST ) ?? [])
        ;

        return $this;
    }

    /**
     * Merge $input array to the $conf
     *
     * @param array $input
     * @return self
     */
    private function merge(array $input): self
    {
        if (is_array($input))
        {
            $this->conf = array_merge( $this->conf, $input );
        }

        return $this;
    }

    // Bridge Methods
    // --
    
    /**
     * Get config value by the key
     *
     * @param string $key
     * @return void
     */
    public function get(string $key)
    {
        return $this->conf[$key] ?? null;
    }
}