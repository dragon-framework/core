<?php 
namespace Dragon\Component\Routing;

use Dragon\Component\Errors\Error404\Controller as Error404;

class Matcher 
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
            case null === $this->match && $_SERVER['REQUEST_URI'] == "/":
                echo "Dragon Welcom page";
                break;

            case $this->match:
                $callableParts      = explode('#', $this->match['target']);
                $controllerName     = ucfirst(str_replace('Controller', '', $callableParts[0]));
                $methodName         = $callableParts[1];
                $controllerFullName = 'App\\Controllers\\'.$controllerName.'Controller';
                
                $controller         = new $controllerFullName();
                
                call_user_func_array(array($controller, $methodName), $this->match['params']);
                break;

            default:
                new Error404;
        }
    }
}