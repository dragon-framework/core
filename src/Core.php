<?php 

namespace Dragon;

use Exception;

class Core
{
	const DIRECTORY_APP = './../app/';
	const DIRECTORY_SRC = './../src/';
    const DIRECTORY_ROOT = './../public/';
    


    /**
     * The App config
     *
     * @var array
     */
    private $config;

    public function __construct()
    {
        $this->config = new \Dragon\Component\Config;
    }


    public function getConfig()
    {
        return $this->config->getConfig();
    }

    public function run()
    {
        return "Run thE aPP";
    }
}