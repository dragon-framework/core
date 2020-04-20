<?php
namespace Dragon\Component\Routing;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Definition
{
    /**
     * Routes input definition file
     */
    // const APP_SOURCE = Directory::DIRECTORY_APP_CONFIG . "routes/routes.php";
    // const APP_SOURCE = Directory::DIRECTORY_APP_CONFIG . "routes/api-routes.php";
    // const APP_SOURCE = Directory::DIRECTORY_APP_CONFIG . "routes/admin-routes.php";
    // const CORE_SOURCE = __DIR__ . DS . "Resources" . DS . "DefaultRoutes.php";

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

        $this->definitions = array_merge($this->definitions, $this->format( "public", $fs->include( __DIR__ . DS . "Resources" . DS . "DefaultRoutes.php" ) ?? [] ));
        $this->definitions = array_merge($this->definitions, $this->format( "public", $fs->include( Directory::DIRECTORY_APP_CONFIG . "routes/routes.php" ) ?? [] ));
        $this->definitions = array_merge($this->definitions, $this->format( "admin", $fs->include( Directory::DIRECTORY_APP_CONFIG . "routes/admin-routes.php" ) ?? [] ));
        $this->definitions = array_merge($this->definitions, $this->format( "api", $fs->include( Directory::DIRECTORY_APP_CONFIG . "routes/api-routes.php" ) ?? [] ));

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

    private function format(string $target, array $definitions, ?string $path=null, ?string $name=null)
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


            // Guard / Access Control
            // --

            $_guards = [ROLE_ANONYMOUS];

            if (isset( $_params['guards'] ))
            {
                $_guards = $_params['guards'];
            }


            // --

            if (isset( $_params['children'] ) && is_array( $_params['children'] ))
            {
                $output = array_merge($output, $this->format( $target, $_params['children'], $_path, $_name ));
            }
            else
            {
                $_callableParts_separator = "#";

                list($_class, $method) = explode($_callableParts_separator, $_callableParts);
                $_class = ucfirst(preg_replace("/Controller$/", '', $_class));
                $_class.= 'Controller';

                switch ($target) 
                {
                    case 'admin':
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
                            "admin:".$_name,
                            $_guards,
                        ];
                        break;

                    case 'api':
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
                            "api:".$_name,
                            $_guards,
                        ];
                        break;

                    case 'public':
                    default:
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
                            $_name,
                            $_guards,
                        ];
                        break;
                }

                array_push($output, $route);
            }
        }

        return $output;
    }

}
