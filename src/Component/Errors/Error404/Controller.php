<?php
namespace Dragon\Component\Errors\Error404;

class Controller 
{
    public function render()
    {
        header("HTTP/1.0 404 Not Found");
        
        dump("Render 404");
        exit;
    }
}