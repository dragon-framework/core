<?php 
namespace Dragon\Component\Request;

class Request 
{
    private $data;
    private $method;

    public function __call(string $key, array $arguments)
    {
        $methodName = "get" . ucfirst(strtolower($key));

        return $this->$methodName();
    }

    public function get(string $key)
    {
        $data = $this->data[$this->method][$key] ?? null;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);

        $this->method = null;

        return $data;
    }

    
    // Host
    // --

    public function getBase(): ?string
    {
        $base = $this->getScheme();
        $base.= "://";
        $base.= $this->getHostname();

        if ($port = $this->getPort())
        {
            $base.= ":". $port;
        }
        
        return $base;
    }

    private function getScheme(): ?string
    {
        $scheme = "http";
        $scheme.= !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? "s" : null;

        return $scheme;
    }

    private function getHostname(): ?string
    {
        return $_SERVER['SERVER_NAME'] ?? null;
    }

    private function getPort(): ?string
    {
        return $_SERVER['SERVER_PORT'] ?? null;
    }

    private function getUri(): ?string
    {
        return $_SERVER['REQUEST_URI'] ?? null;
    }

    private function getPath(): ?string
    {
        $data = explode("?", $this->getUri());

        return $data[0];
    }


    // Data
    // --

    private function getQuery(): ?self
    {
        $method = "query";

        // Get data from $_GET
        if (isset($_GET))
        {
            $this->data[$method] = $_GET;

            unset($_GET);
        }

        // Get data from active route params
        $route = getApp()->routing()->getActive();

        if (isset($route['params']))
        {
            $this->data[$method] = array_merge($this->data[$method], $route['params']);
        }

        $this->method = $method;

        return $this;
    }

    private function getRequest(): self
    {
        $method = "request";

        if (isset($_POST) )
        {
            $this->data[$method] = $_POST;
    
            unset($_POST);
        }

        $this->method = $method;

        return $this;
    }


    // Methods
    // --

    private function getMethod(): ?string
    {
        return $_SERVER['REQUEST_METHOD'] ?? null;
    }

    public function isGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === "GET";
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === "POST";
    }

    
    // User Agent
    // --

    private function getAgent(): ?string
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? null;
    }

    
    // Referer
    // --

    private function getReferer(): ?string
    {
        return $_SERVER['HTTP_REFERER'] ?? null;
    }
}
