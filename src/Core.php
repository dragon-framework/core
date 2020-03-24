<?php 

namespace Dragon;

class Core
{
    /**
     * The App config
     *
     * @var array
     */
    private $config = [];

    public function __construct()
    {
        echo "App Construct";
    }

    public function run()
    {
        return "Run thE aPP";
    }
}