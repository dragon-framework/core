<?php
namespace Dragon\Component\Database\Connect;

use Dragon\Component\Database\Definition;

class Connect 
{
    private $definition;

    public function __construct()
    {
        $this->definition = new Definition;
    }
}