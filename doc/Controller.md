# Controller Methods

## Exemple

```php
use Dragon\Component\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index()
    {
        // ...
        return $this->render("homepage/index.html");
    }
}
```

## Methods

### render()

```php
$this->render(string $template [, array $params=array()]);
```

- **template** The file name in the theme directory `default/hompage.html`.
- **params** Passing parameters from controller to the template.

### redirect()

```php
$this->redirect(string $uri);
```

- **uri**

### redirectToRoute()

```php
$this->redirectToRoute(string $routeName [, array $params=array()]);
```

- **routeName**
- **params**

### generateUrl()

```php
$this->generateUrl(string $routeName [, array $params=array() [, bool $absolute=false]]);
```

- **routeName**
- **params**
- **absolute**
