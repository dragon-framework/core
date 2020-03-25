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
        $this
            ->addConfig( $this->getConfigFile( __DIR__ . "/Base.php" ) )
            ->addConfig( $this->getConfigFile( Directory::DIRECTORY_CONFIG . "config.php" ) )
            ->addConfig( $this->getConfigFile( Directory::DIRECTORY_CONFIG . "config-dev.php" ) )
            ->addConfig( $this->getConfigFile( Directory::DIRECTORY_CONFIG . "config-test.php" ) )
        ;
    }

    /**
     * Get the config file
     *
     * @param string $file
     * @return void
     */
    private function getConfigFile(string $file): array
    {
        return file_exists($file) ? include $file : [];
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