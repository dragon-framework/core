<?php
namespace Dragon\Component\Config;

use Dragon\Component\Config\Definition;
use Dragon\Component\Environment\Definition as EnvironmentDefinition;
use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Builder
{
    /**
     * Config filename
     */
    const APP_CONFIG        = Directory::DIRECTORY_APP_CONFIG . "config/config.php";
    const CORE_CONFIG       = Directory::DIRECTORY_CORE_CONFIG . "Config.php";
    const APP_CONFIG_DEV    = Directory::DIRECTORY_APP_CONFIG . "config/config-dev.php";
    const CORE_CONFIG_DEV   = Directory::DIRECTORY_CORE_CONFIG . "Dev.php";
    // const APP_CONFIG_TEST   = Directory::DIRECTORY_APP_CONFIG . "config-test.php";

    /**
     * The App config
     *
     * @var array
     */
    private $conf = [];
    private $configDev = [];
    private $configTest = [];

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

        // Get Global Config
        $this
            ->merge( $fs->include( self::CORE_CONFIG ) ?? [] )
            ->merge( $fs->include( self::APP_CONFIG ) ?? [] )
        ;

        // Get Dev Config
        $this
            ->mergeDev( $fs->include( self::CORE_CONFIG_DEV ) ?? [] )
            ->mergeDev( $fs->include( self::APP_CONFIG_DEV ) ?? [] )
        ;

        // Get Test Config
        // $this->merge( $fs->include( self::APP_CONFIG_TEST ) ?? []);

        $this->reconf();

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

    /**
     * Merge $input array to the $confDev
     *
     * @param array $input
     * @return self
     */
    private function mergeDev(array $input): self
    {
        foreach ($this->configDev as $key => $value)
        {
            foreach ($input as $newKey => $newValue)
            {
                if ($newKey == $key && is_array($value) && is_array($newValue))
                {
                    $this->configDev[$key] = array_merge($this->configDev[$key], $newValue);
                    unset($input[$newKey]);
                }
            }
        }

        $this->configDev = array_merge( $this->configDev, $input );

        // Merge dev config to the global config
        $this->merge( $this->configDev );

        return $this;
    }

    private function reconf(): self
    {
        // Auto Define Environment Execution
        if (is_array($this->conf[ Definition::DEV_CONFIG_HOSTS ]) && $this->conf[ Definition::DEV_CONFIG_ADEX ] ?? false)
        {
            if (
                !empty($_SERVER['SERVER_NAME']) &&
                in_array($_SERVER['SERVER_NAME'], $this->conf[ Definition::DEV_CONFIG_HOSTS ])
            ) {
                $this->conf['environment'] = EnvironmentDefinition::EXECUTION_MODE_DEV;
            }
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