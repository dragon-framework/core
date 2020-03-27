<?php 
namespace Dragon\Bridge;

abstract class Bridge
{
    private $register;

    public function __construct()
    {
        $this->register = include "Register.php";
    }
    
    /**
     * Config Bridge
     *
     * @param string|null $key
     * @return void
     */
    public function __call($name, $arguments)
    {
        return $this->register[$name]->getBridge( $arguments );
    }
}