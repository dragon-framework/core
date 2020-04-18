<?php 
namespace Dragon\Component\Request;

class Request 
{
    private $data;

    public function __call(string $key, array $arguments)
    {
        $methodName = "get" . ucfirst(strtolower($key));

        return $this->$methodName();
    }

    public function get(string $key)
    {
        $data = $this->data[$key] ?? null;
        $data = htmlspecialchars($data);

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
        // Get data from $_GET
        $this->data = $_GET;

        // Get data from active route params
        $route = getApp()->routing()->getActive();

        if (isset($route['params']))
        {
            $this->data = array_merge($this->data, $route['params']);
        }

        unset($_GET);
        
        return $this;
    }

    private function getRequest(): self
    {
        $this->data = $_POST;

        unset($_POST);

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
