<?php 
namespace Dragon\Component\Routing;

use Dragon\Component\Errors\Error404\Controller as Error404;

class Matcher 
{
    public function __construct()
    {
        $match = getApp()->routing()->getRouter()->match(); 

        if ($match)
        {
            $callableParts = explode('#', $match['target']);
			// Retire l'optionnel suffixe 'Controller', pour le remettre ci-dessous
			$controllerName = ucfirst(str_replace('Controller', '', $callableParts[0]));
			$methodName = $callableParts[1];
			$controllerFullName = 'App\\Controllers\\'.$controllerName.'Controller';
			
			$controller = new $controllerFullName();
			
			// Appelle la méthode, en lui passant les paramètres d'URL en arguments 
			call_user_func_array(array($controller, $methodName), $match['params']);
        }

        else
        {
            new Error404;
        }
    }
}