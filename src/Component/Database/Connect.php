<?php
namespace Dragon\Component\Database;

use Dragon\Component\Database\Definition;

class Connect 
{
    private $definition;

    public function __construct()
    {
        $this->definition = new Definition;
    }
}