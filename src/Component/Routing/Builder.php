<?php
namespace Dragon\Component\Routing;

use AltoRouter;
use Dragon\Component\Routing\Definition;

class Builder
{
    /**
     * Server Base
     *
     * @var string
     */
    private $base;

    /**
     * Router engine
     *
     * @var \AltoRouter
     */
    private $router;

    /**
     * Routes definition
     *
     * @var \Definition
     */
    private $definition;

    // private $routes = [];

    public function __construct()
    {
        $this->definition = new Definition;
        $this->router = new AltoRouter;

        $this->setBase();
        $this->setRoutes();

        $this->router->setBasePath( $this->getBase() );
        $this->router->addRoutes( $this->getRoutes() );
        
    }
    
    /**
     * Set the route Base (ex: "/app/")
     *
     * @return self
     */
    private function setBase(): self
    {
        $this->base = empty($_SERVER['BASE']) ? '' : $_SERVER['BASE'];

        return $this;
    }

    /**
     * Get the route base
     * @bridgeAccess
     *
     * @return void
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set routes from $routes definition
     *
     * @return self
     */
    private function setRoutes(): self
    {
        $this->routes = $this->definition->get();
        
        return $this;
    }

    /**
     * Get formated routes
     *
     * @return void
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * Get the router
     *
     * @return void
     */
    public function getRouter()
    {
        return $this->router;
    }
}