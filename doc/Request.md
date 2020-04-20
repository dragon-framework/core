# Request 

Use `$this->request()` in your controller files.

- [base()](#methods-base)
- [hostname()](#methods-hostname)
- [port()](#methods-port)
- [uri()](#methods-uri)
- [path()](#methods-path)
- [query()](#methods-query)
- [request()](#methods-request)
- [scheme()](#methods-scheme)
- [method()](#methods-method)
- [agent()](#methods-agent)
- [referer()](#methods-referer)
- [isGet()](#methods-isGet)
- [isPost()](#methods-isPost)

## base() {#methods-base}

Return the base of the request.

```php
$this->request()->base();
```

## hostname() {#methods-hostname}

Return the host name of the request.

```php
$this->request()->hostname();
```

## port() {#methods-port}

Return the Port number of the request.

```php
$this->request()->port();
```

## uri() {#methods-uri}

Return the uri of the request.

```php
$this->request()->uri();
```

## path() {#methods-path}

Return the path of the request.

```php
$this->request()->path();
```

## query() {#methods-query}

Return value of the parameter "email" from a request by GET method.

```php
$this->request()->query()->get('email');
```

## request() {#methods-request}

Return value of the parameter "email" from a request by POST method.

```php
$this->request()->request()->get('email');
```

## scheme() {#methods-scheme}

Return the scheme of the request.

```php
$this->request()->scheme();
```

## method() {#methods-method}

Return the name of HTTP Method of the request.

```php
$this->request()->method();
```

## agent() {#methods-agent}

Return the User-Agent.

```php
$this->request()->agent();
```

## referer() {#methods-referer}

Retrun the referer.

```php
$this->request()->referer();
```

## isGet() {#methods-isGet}

Return true if HTTP Method is GET.

```php
$this->request()->isGet();
```

## isPost() {#methods-isPost}

Return true if HTTP Method is POST.

```php
$this->request()->isPost();
```
