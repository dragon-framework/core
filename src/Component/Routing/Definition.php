<?php
namespace Dragon\Component\Routing;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Definition
{
    /**
     * Routes input definition file
     */
    const APP_SOURCE = Directory::DIRECTORY_APP_CONFIG . "routes.php";
    const CORE_SOURCE = __DIR__ . DS . "Resources" . DS . "DefaultRoutes.php";

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

        $this->definitions = array_merge($this->definitions, $this->format( $fs->include( self::APP_SOURCE ) ?? [] ));
        $this->definitions = array_merge($this->definitions, $this->format( $fs->include( self::CORE_SOURCE ) ?? [] ));


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

        foreach ($definitions as $_name => $_params)
        {
            // Route Name
            // --

            if (null != $name)
            {
                $_name = $name.":".$_name;
            }


            // Route path
            // --

            $_path = $_params['path'] ?? null;

            if (null != $path)
            {
                $_path = $path.$_path;
            }


            // Callable Parts
            // --

            $_callableParts = $_params['controller'] ?? null;


            // Allowed Methods
            // --

            $_methods = "GET";

            if (isset( $_params['methods'] ))
            {
                $_methods = implode("|", $_params['methods']);
            }


            // Targets
            // --

            $_targets = ["public"];

            if (isset( $_params['targets'] ))
            {
                $_targets = $_params['targets'];
            }


            // --

            if (isset( $_params['children'] ) && is_array( $_params['children'] ))
            {
                $output = array_merge($output, $this->format( $_params['children'], $_path, $_name ));
            }
            else
            {
                $_callableParts_separator = "#";

                list($_class, $method) = explode($_callableParts_separator, $_callableParts);
                $_class = ucfirst(preg_replace("/Controller$/", '', $_class));
                $_class.= 'Controller';

                if (in_array("public", $_targets, true))
                {
                    $namespace = "App\\Controllers\\FrontOffice\\";
                    if (!class_exists($_class))
                    {
                        $class = $namespace.$_class;
                    }
                    else
                    {
                        $class = $_class;
                    }

                    $glue = $_callableParts_separator;
                    $_callableParts = implode($glue, [$class, $method]);

                    $route = [
                        $_methods, 
                        $_path, 
                        $_callableParts, 
                        $_name
                    ];
                    array_push($output, $route);
                }

                if (in_array("admin", $_targets, true))
                {
                    $namespace = "App\\Controllers\\BackOffice\\";
                    if (!class_exists($_class))
                    {
                        $class = $namespace.$_class;
                    }
                    else
                    {
                        $class = $_class;
                    }

                    $glue = $_callableParts_separator;
                    $_callableParts = implode($glue, [$class, $method]);

                    $route = [
                        $_methods, 
                        "/admin".$_path, 
                        $_callableParts, 
                        "admin:".$_name
                    ];

                    array_push($output, $route);
                }

                if (in_array("api", $_targets, true))
                {
                    $namespace = "App\\Controllers\\Api\\";
                    if (!class_exists($_class))
                    {
                        $class = $namespace.$_class;
                    }
                    else
                    {
                        $class = $_class;
                    }

                    $glue = $_callableParts_separator;
                    $_callableParts = implode($glue, [$class, $method]);

                    $route = [
                        $_methods, 
                        "/api".$_path, 
                        $_callableParts, 
                        "api:".$_name
                    ];

                    array_push($output, $route);
                }

            }
        }

        return $output;
    }

}
