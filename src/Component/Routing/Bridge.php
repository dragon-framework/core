<?php
/**
 * $app = new Dragon\Kernel;
 * 
 * $app->routing->getBase();
 * $app->routing->getRoutes();
 */
namespace Dragon\Component\Routing;

use Dragon\Bridge\BridgeInterface;

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
     * Get the routing base
     *
     * @return void
     */
    public function getBase()
    {
        return $this->_getBase();
    }

    /**
     * Get the routing routes
     *
     * @return void
     */
    public function getRoutes()
    {
        return $this->_getRoutes();
    }
}