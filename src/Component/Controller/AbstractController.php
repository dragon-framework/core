<?php 
namespace Dragon\Component\Controller;

use Dragon\Component\Directory\Directory;
use Dragon\Component\Model\AbstractModel;

abstract class AbstractController 
{
    private $controllerName;


	public function __construct()
	{
		$this->setControllerClassName();
		// $this->dbh = ConnectionModel::getDbh();
    }

    private function setControllerClassName(): self
    {
        $className = get_class($this);

        // Retire le Model et les antislashes et converti en underscore_case (snake_case)
        $class = str_replace('Controller', '', $className);
        $class = explode('\\', $class);
        $class = ltrim(preg_replace('/[A-Z]/', '_$0', end($class)), '_');
        
        $this->controllerName = $class;

        return $this;
    }

    protected function render(string $template, array $params=array())
    {
        $themes_dir     = Directory::DIRECTORY_THEMES;
        $theme_name     = getApp()->config()->getConfig('theme');
        $theme_dir      = $themes_dir.$theme_name;

        $loader = new \Twig\Loader\FilesystemLoader($theme_dir);
        $twig = new \Twig\Environment($loader, [
            // 'cache' => './path/to/compilation_cache',
        ]);

        echo $twig->render($template, $params);
        exit;
    }

    /**
     * Make an HTTP Redirect
     *
     * @param string $uri
     * @return void
     */
    public function redirect(string $uri)
    {
        header("location: $uri");
        exit;
    }

    /**
     * Make an HTTP Redirect by a route name
     *
     * @param string $routeName
     * @param array $params
     * @return void
     */
    public function redirectToRoute(string $routeName, array $params=array())
    {
        $uri = ""; // TODO: Make redirect to route
        $this->redirect($uri);
    }

    /**
     * Generate URL by the route name
     *
     * @param string $routeName
     * @param array $params
     * @param boolean $absolute
     * @return void
     */
    public function generateUrl(string $routeName, array $params=array(), bool $absolute=false)
    {
        $app    = getApp();
        $router = $app->routing()->getRouter();
        $url    = $router->generate($routeName, $params);

        if ($absolute)
        {
            $u = \League\Url\Url::createFromServer($_SERVER);
            $url = $u->getBaseUrl() . $url;
        }

        return $url;
    }



    private function getModel()
    {
        $modelName = "\\App\\Models\\".$this->controllerName."Model";
        return new $modelName;
    }
    
    protected function find($id)
    {
        return $this->getModel()->find($id);
    }
    protected function findAll(array $options=AbstractModel::DEFAULT_FINDALL_OPTIONS)
    {
        return $this->getModel()->findAll($options);
    }
}