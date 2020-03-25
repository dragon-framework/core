<?php 
namespace Dragon;

use Dragon\Component\Config\Bridge as ConfigBridge;

class Bridge
{
    /**
     * Config Bridge
     *
     * @param string|null $key
     * @return void
     */
    public function config(?string $key = null)
    {
        $bridge = new ConfigBridge;
        
        return $bridge->config( $key );
    }
}