<?php
namespace Dragon\Component;

class Config
{
    const DIRECTORY = \Dragon\Core::DIRECTORY_APP . "config/";

    /**
     * The App config
     *
     * @var array
     */
    private $config = [];

    public function __construct()
    {
        $this->addConfig( self::DIRECTORY . "config.php" );
        $this->addConfig( self::DIRECTORY . "config-dev.php" );
        $this->addConfig( self::DIRECTORY . "config-test.php" );
    }

    private function addConfig(string $file): self
    {
        if (file_exists($file))
        {
            $params = require_once $file;

            if (is_array($params))
            {
                $this->config = array_merge(
                    $this->config,
                    $params
                );
            }
        }

        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}