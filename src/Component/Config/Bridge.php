<?php
namespace Dragon\Component\Config;

use Exception;

class Bridge extends Builder
{
    public function config(?string $key = null)
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