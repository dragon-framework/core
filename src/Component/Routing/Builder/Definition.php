<?php
namespace Dragon\Component\Routing\Builder;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Definition
{
    /**
     * Routes input definition file
     */
    const SOURCE = Directory::DIRECTORY_CONFIG . "routes.php";

    /**
     * Routes final definition
     *
     * @var array
     */
    private $definitions = [];

    public function __construct()
    {
        $this->set();
    }

    /**
     * Routes definition setter
     *
     * @return self
     */
    private function set(): self
    {
        $fs = new FileSystem;

        if ($fs->isFile(self::SOURCE))
        {
            $this->definitions = $this->format( $fs->include( self::SOURCE ) ?? [] );
        }

        return $this;
    }

    /**
     * Routes definition getter
     *
     * @return array
     */
    public function get(): array
    {
        return $this->definitions;
    }

    private function format(array $definitions, ?string $path=null, ?string $name=null)
    {
        $output = [];

        foreach ($definitions as $route_name => $route_params)
        {
            // Route Name
            // --

            // Route path
            // --

            // Callable Parts
            // --

            // Allowed Methods
            // --






            // // Route allowed methods


            // $allowed_methods = isset( $route_params['methods'] ) 
            //     ? implode("|",  $route_params['methods']) 
            //     : "GET";
                
            // $path.= $route_params['path'];

            // $callableParts = $route_params['controller'];

            // $route_name = null != $name 
            //     ? $name.":".$route_name 
            //     : $route_name;

            // if (isset($route['children']) && is_array($route['children']))
            // {

            // }
            // else
            // {

            // }


        }

        return $output;
    }


}


        // private function builder(array $routes, ?string $path=null, ?string $name=null)
        // {
        //     $_routes = [];
    
        //     foreach ($routes as $route_name => $route)
        //     {
        //         $method     = isset($route['methods']) ? implode("|", $route['methods']) : "GET";
        //         $route_path = $path != null ? $path.$route['path'] : $route['path'];
        //         $controller = $route['controller'];
        //         $route_name = $name != null ? $name.":".$route_name : $route_name;
    
        //         if (isset($route['children']) && is_array($route['children']))
        //         {
        //             $_routes = array_merge($_routes, $this->builder($route['children'], $route_path, $route_name));
        //         }
        //         else
        //         {
        //             array_push($_routes, [
        //                 $method,
        //                 $route_path,
        //                 $controller,
        //                 $route_name
        //             ]);
        //         }
        //     }
    
        //     return $_routes;
        // }