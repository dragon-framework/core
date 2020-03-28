<?php
/**
 * $app = new Dragon\Kernel;
 * 
 * $app->config->getConfig();
 * $app->config->getConfig(title);
 */
namespace Dragon\Component\Config;

use Dragon\Bridge\BridgeInterface;
use Exception;

class Bridge extends Builder implements BridgeInterface
{
    /**
     * The Brige method
     *
     * @return self
     */
    public function getBridge(): self
    {
        return $this;
    }

    /**
     * Get config
     *
     * @param string|null $key
     * @return void
     */
    public function getConfig(?string $key = null)
    {
        $config = $this->config;

        if (!empty($key))
        {
            if (!isset($config[$key]))
            {
                throw new Exception("The index $key is not defined in your config.");
            }

            return $config[$key];
        }

        return $config;
    }
}