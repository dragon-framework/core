<?php
namespace Dragon\Component\Config;

class Builder
{
    /**
     * Path of the config directory
     */
    const DIRECTORY = \Dragon\Core::DIRECTORY_APP . "config/";

    /**
     * The App config
     *
     * @var array
     */
    private $config = [];

    public function __construct()
    {

        $this->addConfig( $this->includeConfig( "Base.php" ) );
        $this->addConfig( $this->includeConfig( self::DIRECTORY . "config.php" ) );
        $this->addConfig( $this->includeConfig( self::DIRECTORY . "config-dev.php" ) );
        $this->addConfig( $this->includeConfig( self::DIRECTORY . "config-test.php" ) );
    }

    private function includeConfig(string $file)
    {
        if (file_exists($file))
        {
            return require_once $file;
        }

        return false;
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

    public function getConfig(): array
    {
        return $this->config;
    }
}