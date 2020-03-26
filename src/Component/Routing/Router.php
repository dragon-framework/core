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
        $this->router = new AltoRouter;

        $this->addRoutes( $fs->include( Directory::DIRECTORY_CONFIG . "routes.php" ) );
    }

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