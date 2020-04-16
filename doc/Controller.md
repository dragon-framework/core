# Controller Methods

- [Create a controller](#create-a-controller)
- [Methods](#methods)
    - [render()](#method-render)
    - [request()](#method-request)
    - [redirect()](#method-redirect)
    - [redirectToRoute()](#method-redirectToRoute)
    - [generateUrl()](#method-generateUrl)
    - [setFlashBag()](#method-setFlashBag)
    - [getFlashBag()](#method-getFlashBag)
    - [setFlashData()](#method-setFlashData)
    - [getFlashData()](#method-getFlashData)
    - [setDatabaseStatementDefinition()](#method-setDatabaseStatementDefinition)
    - [getModel()](#method-getModel)
    - [find()](#method-find)
    - [findAll()](#method-findAll)
    - [isGranted()](#method-isGranted)

## Create a controller {#create-a-controller}

Create a controller in the appropriate directory :

`src/Controllers/Api/`
: For API or WebService based application.

`src/Controllers/BackOffice/`
: For the admin part of the application

`src/Controllers/FrontOffice/`
: For the public part of the application

### Example

```php
// Use the abstract controller
use Dragon\Component\Controller\AbstractController;

// Create the controller
class DefaultController extends AbstractController
{
    // Create methods
    public function index()
    {
        // ...
        return $this->render("homepage/index.html");
    }
}
```

## Methods {#methods}

### render() {#method-render}

Rendering a HTML view

`$this->render(string $template [, array $params=array()]);`

template
: The file name in the theme directory `src/Templates`.

params
: Passing parameters from controller to the template.

### request() {#method-request}

Return the Request module

`$this->request()`

_See the documentation of [`Request`](Request.md) for more info._

### redirect() {#method-redirect}

Redirect the user to the URI.

`$this->redirect(string $uri);`

uri
: URI address you want to redirect the user

### redirectToRoute() {#method-redirectToRoute}

Redirect the user with a defined route.

`$this->redirectToRoute(string $routeName [, array $params=array()[, bool $absolute=false]]);`

routeName
: The name of the route.

params
: Route parameters.

absolute
: If true, will generate the absolute URL.

### generateUrl() {#method-generateUrl}

Generate URL with a defined route.

`$this->generateUrl(string $routeName [, array $params=array() [, bool $absolute=false]]);`

routeName
: The name of the route.

params
: Route parameters.

absolute
: If true, will generate the absolute URL.

### setFlashBag() {#method-setFlashBag}

### getFlashBag() {#method-getFlashBag}

### setFlashData() {#method-setFlashData}

### getFlashData() {#method-getFlashData}


### setDatabaseStatementDefinition() {#method-setDatabaseStatementDefinition}



`$this->setDatabaseStatementDefinition()`

### getModel() {#method-getModel}



`$this->getModel()`

### find() {#method-find}



`$this-find()>`

### findAll() {#method-findAll}



`$this->findAll()`

### isGranted() {#method-isGranted}



`$this->isGranted()`
