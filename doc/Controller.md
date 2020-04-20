# Controller Methods

- [Create a controller](#create-a-controller)
- [Methods](#methods)
    - Rendering
        - [render()](#method-render)
    - Request
        - [request()](#method-request)
    - Routes
        - [redirect()](#method-redirect)
        - [redirectToRoute()](#method-redirectToRoute)
        - [generateUrl()](#method-generateUrl)
    - Flash Message / Data
        - [setFlashBag()](#method-setFlashBag)
        - [getFlashBag()](#method-getFlashBag)
        - [setFlashData()](#method-setFlashData)
        - [getFlashData()](#method-getFlashData)
    - Database
        - [setDatabaseStatement()](#method-setDatabaseStatement)
        - [find()](#method-find)
        - [findBy()](#method-findBy)
        - [findAll()](#method-findAll)
        - [insert()](#method-insert)
        - [update()](#method-update)
        - [lastId()](#method-lastId)
    - Security
        - [user()](#method-user)
        - [isAnonymous()](#method-isAnonymous)
        - [isAuthenticated()](#method-isAuthenticated)
        - [hasRoles()](#method-hasRoles)
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

### Rendering

#### render() {#method-render}

Rendering a HTML view

```php
$this->render(string $template [, array $params=array()]);
```

template
: The file name in the theme directory `src/Templates`.

params
: Passing parameters from controller to the template.

### Request

#### request() {#method-request}

Return the Request module

```php
$this->request()
```

_See the documentation of [`Request`](Request.md) for more info._

### Routes

#### redirect() {#method-redirect}

Redirect the user to the URI.

```php
$this->redirect(string $uri);
```

uri
: URI address you want to redirect the user

#### redirectToRoute() {#method-redirectToRoute}

Redirect the user with a defined route.

```php
$this->redirectToRoute(string $routeName [, array $params=array()[, bool $absolute=false]]);
```

routeName
: The name of the route.

params
: Route parameters.

absolute
: If true, will generate the absolute URL.

#### generateUrl() {#method-generateUrl}

Generate URL with a defined route.

```php
$this->generateUrl(string $routeName [, array $params=array() [, bool $absolute=false]]);
```

routeName
: The name of the route.

params
: Route parameters.

absolute
: If true, will generate the absolute URL.

### Flash Message / Data

#### setFlashBag() {#method-setFlashBag}

Define a flash message.

```php
$this->setFlashBag(string $state, string $message[, bool $override=true])
```

state
: State of message. Values : `success`, `warning`, `danger`, `info`, `primary`, `secondary`, `light`, `dark`.

message
: The message

override
: if false, the message will not override flashbag if already defined.

#### getFlashBag() {#method-getFlashBag}

Read a flash message.

```php
$this->getFlashBag();
```

#### setFlashData() {#method-setFlashData}

Define flash data.

```php
$this->setFlashData(array $data);
```

data
: Array of data.

#### getFlashData() {#method-getFlashData}

Read flash data.

```php
$this->getFlashData();
```

### Database

#### setDatabaseStatement() {#method-setDatabaseStatement}

Define the name of database statement to select database config before query.

```php
$this->setDatabaseStatement(string $statement);
```

statement
: The name of statement. see Database configuration.

#### find() {#method-find}

Set query to find one of entity by id.

```php
$this->find(int $id[, ?array $columns=null]);
```

id
: ID of the entity you want to find.

columns
: Returned columns. Default: *.

#### findBy() {#method-findBy}

Set query to find one of entity by parameters.

```php
$this->findBy(array $criteria[, ?string $relation=Query::RELATION_AND[, ?array $columns=null]]);
```

criteria
: Array of criterias (Parts WHERE)

relation
: Relation type between criterias. Default AND.

columns
: Returned columns. Default: *.

#### findAll() {#method-findAll}

Set query to find entities by parameters.

```php
$this->findAll(array $options=[]);
```

options
: Search options

#### insert() {#method-insert}

Insert an entity.

```php
$this->insert(array $data);
```

data
: Array of sata you want to insert

#### update() {#method-update}

Update an entity.

```php
$this->update(array $options);
```

options
: Update options

#### lastId() {#method-lastId}

Retrieve the last ID inserted.

```php
$this->lastId();
```

### Security

#### user() {#method-user}

Get user data. Return false if user is not authenticated.

```php
$this->user();
```

#### isAnonymous() {#method-isAnonymous}

Return true if user is not authenticated.

```php
$this->isAnonymous();
```

#### isAuthenticated() {#method-isAuthenticated}

Return true if user is authenticated.

```php
$this->isAuthenticated();
```

#### hasRoles() {#method-hasRoles}

Return an array with user roles.

```php
$this->hasRoles();
```

#### isGranted() {#method-isGranted}

Return true if the acces is allowed for the user.

```php
$this->isGranted();
```
