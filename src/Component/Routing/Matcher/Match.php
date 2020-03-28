<?php 
namespace Dragon\Component\Routing\Matcher;

use Dragon\Component\Errors\Error404\Controller as Error404;
use Dragon\Component\Welcomer\WelcomeController;

class Match 
{
    private $match;

    public function __construct()
    {
        $this->match = getApp()->routing()->getRouter()->match(); 
    }

    public function match()
    {
        switch (true)
        {
            // No route for "/"
            case null == $this->match && $_SERVER['REQUEST_URI'] == "/":
                $controller             = new WelcomeController();
                $method                 = "welcome";
                $params                 = [];
                break;

            case $this->match:
                $callableParts          = explode('#', $this->match['target']);
                $controllerName         = ucfirst(str_replace('Controller', '', $callableParts[0]));
                $controllerNamespace    = 'App\\Controllers\\'.$controllerName.'Controller';
                $controller             = new $controllerNamespace();
                $method                 = $callableParts[1] ?? "index";
                $params                 = $this->match['params'];
                break;
            
            default:
                new Error404;
        }
        
        call_user_func_array(array($controller, $method), $params);
    }
}