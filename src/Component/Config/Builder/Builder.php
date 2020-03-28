<?php
namespace Dragon\Component\Config\Builder;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Builder
{
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
            ->addConfig( $fs->include( Directory::DIRECTORY_CONFIG . "config.php" ) ?? [] )
            ->addConfig( $fs->include( Directory::DIRECTORY_CONFIG . "config-dev.php" ) ?? [] )
            ->addConfig( $fs->include( Directory::DIRECTORY_CONFIG . "config-test.php" ) ?? [] )
        ;
    }

    // /**
    //  * Get the config file
    //  *
    //  * @param string $file
    //  * @return void
    //  */
    // private function getConfigFile(string $file): array
    // {
    //     return file_exists($file) ? include $file : [];
    // }

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