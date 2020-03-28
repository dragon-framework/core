<?php
/**
 * $app = new Dragon\Kernel;
 * 
 * $app->routing->getBase();
 * $app->routing->getRoutes();
 * $app->routing->getRouter();
 */
namespace Dragon\Component\Routing\Bridge;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Routing\Builder\Builder;

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

    /**
     * Get the router
     *
     * @return void
     */
    public function getRouter()
    {
        return $this->_getRouter();
    }
}