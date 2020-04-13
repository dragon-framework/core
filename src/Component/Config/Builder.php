<?php
namespace Dragon\Component\Config;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Builder
{
    const CONFIG_TITLE              = "title";
    const CONFIG_ENVIRONNEMENT      = "environnement";
    const CONFIG_SESSION            = "session";
    const DEV_CONFIG_HOSTS          = "dev-hosts";

    /**
     * Config filename
     */
    const APP_CONFIG        = Directory::DIRECTORY_APP_CONFIG . "config.php";
    const CORE_CONFIG       = Directory::DIRECTORY_CORE_CONFIG . "Config.php";
    const APP_CONFIG_DEV    = Directory::DIRECTORY_APP_CONFIG . "config-dev.php";
    const CORE_CONFIG_DEV   = Directory::DIRECTORY_CORE_CONFIG . "Dev.php";
    const APP_CONFIG_TEST   = Directory::DIRECTORY_APP_CONFIG . "config-test.php";

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

        // Get Global config
        $this
            ->merge( $fs->include( self::CORE_CONFIG ) ?? [] )
            ->merge( $fs->include( self::APP_CONFIG ) ?? [] )
        ;

        // Get Dev config
        $this
            ->mergeDev( $fs->include( self::CORE_CONFIG_DEV ) ?? [] )
            ->mergeDev( $fs->include( self::APP_CONFIG_DEV ) ?? [] )
        ;

        // TestEnv Config
        // $this->merge( $fs->include( self::APP_CONFIG_TEST ) ?? []);

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