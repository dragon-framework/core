<?php
namespace Dragon\Component\Config\Builder;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Builder
{
    const FILE_CONFIG       = Directory::DIRECTORY_CONFIG . "config.php";
    const FILE_CONFIG_DEV   = Directory::DIRECTORY_CONFIG . "config-dev.php";
    const FILE_CONFIG_TEST  = Directory::DIRECTORY_CONFIG . "config-test.php";
    const FILE_DATABASE     = Directory::DIRECTORY_CONFIG . "database.php";

    /**
     * The App config
     *
     * @var array
     */
    protected $config = [];

    public function __construct()
    {
        $fs = new FileSystem;

        $this
            ->addConfig( $fs->include( __DIR__ . "/Base.php" ) ?? [] )
            ->addConfig( $fs->include( self::FILE_CONFIG ) ?? [])
            ->addConfig( $fs->include( self::FILE_CONFIG_DEV ) ?? [])
            ->addConfig( $fs->include( self::FILE_CONFIG_TEST ) ?? [])
            ->addConfig( $fs->include( self::FILE_DATABASE ) ?? [])
        ;
    }

    /**
     * Merge config array
     *
     * @param array $params
     * @return self
     */
    private function addConfig(array $params): self
    {
        if (is_array($params))
        {
            $this->config = array_merge(
                $this->config,
                $params
            );
        }

        return $this;
    }
}