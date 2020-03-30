<?php 
namespace Dragon\Bridge;

use Dragon\Component\FileSystem\FileSystem;

abstract class Bridge
{
    /**
     * The Bridge Register
     *
     * @var array
     */
    private $register;

    public function __construct()
    {
        $fs = new FileSystem;
        $this->register = $fs->include( __DIR__ . "/Register.php" );
    }
    
    /**
     * @param string $key
     * @param array $arguments
     * @return void
     */
    public function __call(string $key, array $arguments)
    {
        return $this->register[ $key ]->getBridge( $arguments );
    }
}