<?php 
namespace Dragon\Component\Controller;

use Dragon\Component\Directory\Directory;
// use Dragon\Component\Model\AbstractModel;
use League\Uri\Uri;

abstract class AbstractController 
{
    /**
     * The name of the child controller class
     *
     * @var string
     */
    private $childControllerName;

	public function __construct()
	{
		$this->setChildControllerName();
    }

    /**
     * Set the name of the controller
     * e.g.: BooksController -> Books
     *
     * @return self
     */
    private function setChildControllerName(): self
    {
        // Get the child controller classname
        $childClassName = get_class($this);

        $className = str_replace('Controller', '', $childClassName);
        $className = explode('\\', $className);
        $className = ltrim(preg_replace('/[A-Z]/', '_$0', end($className)), '_');
        
        $this->childControllerName = $className;

        return $this;
    }


    // Rendering methods
    // --

    /**
     * Render an HTML view
     *
     * @param string $template file frome the themes directory
     * @param array $params
     * @return void
     */
    protected function render(string $template, array $params=array())
    {
        // Build the current Theme path
        // --

        $current_theme_name = getApp()->config()->get('theme');
        $current_theme_dir = Directory::DIRECTORY_THEMES . $current_theme_name;


        // Template Engine
        // --

        $loader = new \Twig\Loader\FilesystemLoader($current_theme_dir);
        $twig = new \Twig\Environment($loader, [
            // 'cache' => './path/to/compilation_cache',
        ]);


        // Output the view
        // --

        echo $twig->render($template, $params);
        exit;
    }


    // Routes & URL
    // --

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
    public function redirectToRoute(string $routeName, array $params=array(), bool $absolute=false)
    {
        $uri = $this->generateUrl($routeName, $params, $absolute);
        $this->redirect($uri);
    }

    /**
     * Generate URL by the route name
     *
     * @param string $routeName
     * @param array $params
     * @param boolean $absolute
     * @return string
     */
    public function generateUrl(string $routeName, array $params=array(), bool $absolute=false)
    {
        $app    = getApp();
        $router = $app->routing()->getRouter();
        $url    = $router->generate($routeName, $params);

        if ($absolute)
        {
            $u = Uri::createFromServer($_SERVER);
            $base = json_decode(json_encode($u));
            $base = substr($base, -1) == "/" ? substr($base, 0, -1) : null;

            $url = $base . $url;
        }

        return $url;
    }


    // Model Queries
    // --

    /**
     * Undocumented function
     *
     * @return void
     */
    private function getModel()
    {
        $modelName = $this->childControllerName;
        $modelNamespace = "\\App\\Models\\".$modelName."Model";

        if (class_exists($modelNamespace))
        {
            return new $modelNamespace;
        }

        return false;
    }
    


    protected function find($id)
    {
        $model = $this->getModel();

        if ($model)
        {
            return $model->find($id);
        }
    }
    // protected function findAll(array $options=AbstractModel::DEFAULT_FINDALL_OPTIONS)
    protected function findAll(array $options=[])
    {
        $model = $this->getModel();

        if ($model)
        {
            return $model->findAll($options);
        }
    }
    // TODO: insert
    // TODO: update
    // TODO: delete
}