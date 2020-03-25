<?php
namespace Dragon\Component\Config;

use Dragon\Component\Directory\Directory;

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
        $this->addConfig( $this->includeConfig( __DIR__ . "/Base.php" ) );
        $this->addConfig( $this->includeConfig( Directory::DIRECTORY_CONFIG . "config.php" ) );
        $this->addConfig( $this->includeConfig( Directory::DIRECTORY_CONFIG . "config-dev.php" ) );
        $this->addConfig( $this->includeConfig( Directory::DIRECTORY_CONFIG . "config-test.php" ) );
    }

    private function includeConfig(string $file)
    {
        if (file_exists($file))
        {
            return require_once $file;
        }

        return [];
    }

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

    // public function getConfig(): array
    // {
    //     return $this->config;
    // }
}