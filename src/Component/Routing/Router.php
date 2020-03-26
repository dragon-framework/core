<?php
namespace Dragon\Component\Routing;

use AltoRouter;
use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Router
{
    private $router;
    private $routes;

    public function __construct()
    {
        $fs = new FileSystem;

        $this->addRoutes( $fs->include( Directory::DIRECTORY_CONFIG . "routes.php" ) );

        $this->router = (new AltoRouter)
            ->setBasePath( $this->getBase() )
            ->addRoutes( $this->routes )
        ;
    }

    /**
     * Get the base of the route
     *
     * @return void
     */
    protected function getBase()
    {
        return empty($_SERVER['BASE']) ? '' : $_SERVER['BASE'];
    }

    /**
     * Get the router
     *
     * @return void
     */
    protected function getRouter()
    {
        return $this->router;
    }

    /**
     * Merge routes
     *
     * @param array $params
     * @return void
     */
    private function addRoutes(array $params)
    {
        if (is_array($params))
        {
            $this->routes = array_merge(
                $this->routes,
                $params
            );
        }

        return $this;
    }
}