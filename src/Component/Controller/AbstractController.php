<?php 
namespace Dragon\Component\Controller;

// use Dragon\Component\Directory\Directory;
use Dragon\Component\Database\Query;
use Dragon\Component\Flash\FlashBag;
use Dragon\Component\Flash\FlashData;
use Dragon\Component\Request\Request;
use Dragon\Component\Views\Render;
use League\Uri\Uri;

abstract class AbstractController 
{
    /**
     * The name of the child controller class
     *
     * @var string
     */
    private $controllerChildName;

    /**
     * Default databse statement name
     *
     * @var string
     */
    private $statetmentId = Query::STATEMENT;

    /**
     * FlashBag instance
     *
     * @var FlashBag
     */
    private $flashbag;

    /**
     * FlashData instance
     *
     * @var FlashData
     */
    private $flashdata;

	public function __construct()
	{
        $this->setControllerChildName();

        $this->flashbag = new FlashBag;
        $this->flashdata = new FlashData;

    }
    
    public function __destruct()
    {
        if (session_id())
        {
            $routing= getApp()->routing();
            $active = $routing->get('active');
            $params = $active['params'] ?? [];
            $name   = $routing->get('name');
            $uri    = $routing->generateUrl($name, $params, true);

            $_SESSION['_REFERER'] = $uri;
        }
    }

    /**
     * Set the name of the controller
     * e.g.: BooksController -> Books
     *
     * @return self
     */
    private function setControllerChildName(): self
    {
        // Get the child controller classname
        $childClassName = get_class($this);

        $className = str_replace('Controller', '', $childClassName);
        $className = explode('\\', $className);
        $className = ltrim(preg_replace('/[A-Z]/', '_$0', end($className)), '_');
        
        $this->controllerChildName = $className;

        return $this;
    }


    // Rendering methods
    // --

    /**
     * Rendering a HTML view
     *
     * @param string $template file frome the themes directory
     * @param array $params
     * @return void
     */
    protected function render(string $template, array $params=array())
    {
        $render = new Render;

        echo $render->render($template, $params);
        
        // exit;
    }


    // Request
    // --

    public function request()
    {
        return new Request;
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
        return getApp()->routing()->generateUrl($routeName, $params, $absolute);
    }


    // Flash
    // --

    public function setFlashBag(string $state, string $message): self
    {
        $this->flashbag->setFlashBag($state, $message);

        return $this;
    }

    public function getFlashBag(): array
    {
        return $this->flashbag->getFlashBag();
    }

    public function setFlashData(array $data): self
    {
        $this->flashdata->setFlashData($data);

        return $this;
    }

    public function getFlashData(): array
    {
        return $this->flashdata->getFlashData();
    }


    // Model Queries
    // --
    
    /**
     * Reset the Database Statement
     *
     * @param string $dsd
     * @return void
     */
    protected function setDatabaseStatement(string $statement)
    {
        $this->statetmentId = $statement;
    }

    /**
     * Create Model instance
     *
     * @return void
     */
    private function getModel()
    {
        // Retrieve the name of the child controller
        $controllerChildName = $this->controllerChildName;

        // Generate the NameSpace of the Model class
        $modelClassNamespace = "\\App\\Models\\".$controllerChildName."Model";

        // Check if the Model Class exists
        if (class_exists($modelClassNamespace))
        {
            // Create the instance of the Model
            $model = new $modelClassNamespace;

            // Change the statetement
            $model->setStatementId( $this->statetmentId );

            return $model;
        }

        return false;
    }

    /**
     * Find one by $id
     *
     * @param integer $id
     * @param array|null $columns
     * @return void
     */
    protected function find(int $id, ?array $columns=null)
    {
        $model = $this->getModel();

        if ($model)
        {
            return $model->find($id, $columns);
        }

        return false;
    }

    /**
     * Find one by criteria
     *
     * @param array $criteria
     * @param string|null $relation
     * @param array|null $columns
     * @return void
     */
    protected function findBy(array $criteria, ?string $relation=Query::RELATION_AND, ?array $columns=null)
    {
        $model = $this->getModel();

        if ($model)
        {
            return $model->findBy($criteria, $relation, $columns);
        }

        return false;
    }

    /**
     * Find all with options
     *
     * @param array $options
     * @return void
     */
    protected function findAll(array $options=[])
    {
        $model = $this->getModel();

        if ($model)
        {
            return $model->findAll($options);
        }

        return false;
    }

    /**
     * Insert into database
     *
     * @param array $data
     * @return void
     */
    protected function insert(array $data)
    {
        $model = $this->getModel();

        if ($model)
        {
            return $model->insert($data);
        }

        return false;
    }

    /**
     * Update database
     *
     * @param array $options
     * @return void
     */
    // protected function update(array $options)
    // {
    //     $model = $this->getModel();

    //     if ($model)
    //     {
    //         return $model->update($options);
    //     }

    //     return false;
    // }

    /**
     * Find all with options
     *
     * @param array $options
     * @return void
     */
    protected function lastId(): int
    {
        $model = $this->getModel();

        if ($model)
        {
            return $model->lastId();
        }

        return 0;
    }

    // TODO: delete








    // Security
    // --

    /**
     * Return user data or empty array
     *
     * @return array
     */
    public function user(): array
    {
        return getApp()->security()->user();
    }

    /**
     * Return true if user is not authenticated
     *
     * @return boolean
     */
    public function isAnonymous(): bool
    {
        return getApp()->security()->isAnonymous();
    }

    /**
     * Return true if user is authenticated
     *
     * @return boolean
     */
    public function isAuthenticated(): bool
    {
        return getApp()->security()->isAuthenticated();
    }

    /**
     * Return true if user has role defined in $roles
     *
     * @param string|array $roles
     * @return boolean
     */
    public function hasRole(string $role): bool
    {
        return getApp()->security()->hasRole($role);
    }

    /**
     * Is access granted
     *
     * @return boolean
     */
    public function isGranted(): bool
    {
        foreach (getApp()->routing()->get('guards') as $guard)
        {
            if ($this->hasRole($guard))
            {
                return true;
            }
        }

        return false;
    }
}
