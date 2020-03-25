<?php 
namespace Dragon;

use Dragon\Component\Config\Bridge as ConfigBridge;

class Bridge
{
    public function config(?string $key = null)
    {
        $bridge = new ConfigBridge;
        return $bridge->config( $key );
    }
}