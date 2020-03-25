<?php 
namespace Dragon\Bridge;

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
        $bridge = new \Dragon\Component\Config\Bridge;
        
        return $bridge->config( $key );
    }
}