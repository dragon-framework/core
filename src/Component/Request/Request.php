<?php 
namespace Dragon\Component\Request;

class Request 
{
    public function get(string $key)
    {
        $methodName = "get" . ucfirst(strtolower($key));

        return $this->$methodName();
    }

    
    // Host
    // --

    private function getBase(): ?string
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

    private function getQuery(): ?string
    {
        return $_SERVER['QUERY_STRING'] ?? null;
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
