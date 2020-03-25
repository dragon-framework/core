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
		// Config files
		$config_file = self::DIRECTORY . "config.php";
		$config_dev  = self::DIRECTORY . "config-dev.php";
        $config_test = self::DIRECTORY . "config-test.php";
        

        if (file_exists($config_file))
        {
            $this->config = array_merge(
                $this->config,
                require_once $config_file
            );
        }

        if (file_exists($config_dev))
        {
            $this->config = array_merge(
                $this->config,
                require_once $config_dev
            );
        }

        if (file_exists($config_test))
        {
            $this->config = array_merge(
                $this->config,
                require_once $config_test
            );
        }
    }

    public function getConfig()
    {
        return $this->config;
    }
}