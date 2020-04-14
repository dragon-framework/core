<?php 
namespace Dragon\Component\Security;

use Dragon\Component\Security\Definition;

class Builder 
{

    /**
     * Routes definition
     *
     * @var \Definition
     */
    private $definition;

    public function __construct()
    {
        $this->definition = new Definition;
    }


    // Bridge Methods
    // --
    
    /**
     * Get config value by the key
     *
     * @param string $key
     * @return void
     */
    public function get(string $key)
    {
        return $this->definition->get( $key );
    }
    
}