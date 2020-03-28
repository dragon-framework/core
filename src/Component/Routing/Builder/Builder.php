<?php
namespace Dragon\Component\Routing\Builder;

use AltoRouter;
use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Builder
{
    private $base;
    private $router;
    private $routes = [];

    public function __construct()
    {
        $this->_setBase();
        $this->_setRoutes();

        $this->router = new AltoRouter;
        $this->router->setBasePath( $this->_getBase() );
        $this->router->addRoutes( $this->routes );
        
    }
    


    /**
     * Set the route Base (ex: "/app/")
     *
     * @return self
     */
    private function _setBase(): self
    {
        $this_base = empty($_SERVER['BASE']) ? '' : $_SERVER['BASE'];

        return $this;
    }

    /**
     * Get the route base
     *
     * @return void
     */
    protected function _getBase()
    {
        return $this->base;
    }



    /**
     * Set routes from $routes definition
     *
     * @return self
     */
    private function _setRoutes(): self
    {
        $this->routes = $this->builder( (new FileSystem)->include( Directory::DIRECTORY_CONFIG . "routes.php" ) );

        return $this;
    }

    /**
     * Get formated routes
     *
     * @return void
     */
    protected function _getRoutes()
    {
        return $this->routes;
    }



    /**
     * Get the router
     *
     * @return void
     */
    protected function _getRouter()
    {
        return $this->router;
    }



    private function builder(array $routes, ?string $path=null, ?string $name=null)
    {
        $_routes = [];

        foreach ($routes as $route_name => $route)
        {
            $method     = isset($route['methods']) ? implode("|", $route['methods']) : "GET";
            $route_path = $path != null ? $path.$route['path'] : $route['path'];
            $controller = $route['controller'];
            $route_name = $name != null ? $name.":".$route_name : $route_name;

            if (isset($route['children']) && is_array($route['children']))
            {
                $_routes = array_merge($_routes, $this->builder($route['children'], $route_path, $route_name));
            }
            else
            {
                array_push($_routes, [
                    $method,
                    $route_path,
                    $controller,
                    $route_name
                ]);
            }
        }

        return $_routes;
    }
}