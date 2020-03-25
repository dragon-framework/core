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
        return (new \Dragon\Component\Config\Bridge)->config( $key );
    }
}