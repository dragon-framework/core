<?php
namespace Dragon\Component\Routing;

use AltoRouter;
use Dragon\Component\Request\Request;
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

    /**
     * Undocumented variable
     *
     * @var Request
     */
    private $request;

    public function __construct()
    {
        $this->definition = new Definition;
        $this->router = new AltoRouter;
        $this->request = new Request;

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

    /**
     * Get the active route
     *
     * @return void
     */
    public function getActive()
    {
        return $this->router->match();
    }

    /**
     * Is route active
     *
     * @param string $routeName
     * @return boolean
     */
    public function isActive(string $routeName): bool
    {
        $route = $this->getActive();

        return $routeName == $route['name'];
    }

    public function generateUrl(string $name, array $params=[], bool $absolute=false): string
    {
        $url = "";
        
        if ($absolute)
        {
            $url.= $this->request->get('base');
        }

        $url.= $this->router->generate($name, $params);

        return $url;
    }
}
