<?php 
namespace Dragon\Component\Routing;

use Dragon\Component\Errors\Error404\Controller as Error404;
use Dragon\Component\Welcomer\WelcomeController;

class Matcher 
{
    /**
     * Is it a match between the HTTP Request path and the router path
     *
     * @var boolean
     */
    private $isMatch = false;

    /**
     * The current mathed route
     *
     * @var void
     */
    private $route;

    public function __construct()
    {
        $app = getApp();
        $this->route = $app->routing()->get('router')->match();
        $this->isMatch = $this->route ? true : false;
    }

    public function match()
    {
        switch (true)
        {
            // No route for the "/" path
            case null == $this->isMatch && $_SERVER['REQUEST_URI'] == "/":
                $controller             = new WelcomeController();
                $method                 = "welcome";
                $params                 = [];
                break;

            case $this->isMatch:
                $callableParts          = explode('#', $this->route['target']);
                // $controllerName         = ucfirst(str_replace('Controller', '', $callableParts[0]));
                $controllerName         = $callableParts[0];
                // $controllerNamespace    = 'App\\Controllers\\'.$controllerName.'Controller';
                // $controllerNamespace    = $controllerName.'Controller';
                $controllerNamespace    = $controllerName;
                $controller             = new $controllerNamespace();
                $method                 = $callableParts[1] ?? "index";
                $params                 = $this->route['params'];
                break;
            
            default:
                new Error404;
        }
        
        call_user_func_array(array($controller, $method), $params);
    }
}
