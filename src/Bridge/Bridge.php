<?php 
namespace Dragon\Bridge;

abstract class Bridge
{
    /**
     * Config Bridge
     *
     * @param string|null $key
     * @return void
     */
    public function config(?string $key = null)
    {
        return (new \Dragon\Component\Config\Bridge)->getBridge( $key );
    }
}