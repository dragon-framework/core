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
                $methodName     = "welcome";
                $controller     = new WelcomeController();

                // echo "Dragon Welcom page";
                break;

            
            case $this->match:
                $callableParts  = explode('#', $this->match['target']);
                $controllerName = ucfirst(str_replace('Controller', '', $callableParts[0]));
                $methodName     = $callableParts[1];

                $controller     = 'App\\Controllers\\'.$controllerName.'Controller';
                $controller     = new $controller();
                
            break;
            
            default:
            new Error404;
        }
        
        call_user_func_array(array($controller, $methodName), $this->match['params']);
    }
}