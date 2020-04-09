<?php
namespace Dragon\Component\Routing;

use Dragon\Component\Directory\Directory;
use Dragon\Component\FileSystem\FileSystem;

class Definition
{
    /**
     * Routes input definition file
     */
    const SOURCE = Directory::DIRECTORY_APP_CONFIG . "routes.php";

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

            $_path = $_params['path'];

            if (null != $path)
            {
                $_path = $path.$_path;
            }


            // Callable Parts
            // --

            $_callableParts = $_params['controller'];


            // Allowed Methods
            // --

            $_methods = "GET";

            if (isset( $_params['methods'] ))
            {
                $_methods = implode("|", $_params['methods']);
            }

            // --

            if (isset( $_params['children'] ) && is_array( $_params['children'] ))
            {
                $output = array_merge($output, $this->format( $_params['children'], $_path, $_name ));
            }
            else
            {
                array_push($output, [$_methods, $_path, $_callableParts, $_name]);
            }
        }

        return $output;
    }

}