<?php 

namespace Dragon;

use Dragon\Bridge\Bridge;
use Dragon\Component\Environment\Definition as EnvironmentDefinition;
use Dragon\Component\Routing\Matcher;

class Kernel extends Bridge
{
    public function __construct()
    {
        parent::__construct();

        dump( $this->config()->get('environment') );

        // Error Reporting
        // --

        if ($this->config()->get('environment') != EnvironmentDefinition::EXECUTION_MODE_DEV )
        {
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            error_reporting(0);
        }
        else
        {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }


        // PHP Session
        // --

        if ($this->config()->get('session'))
        {
            session_start();
        }
    }

    public function run()
    {
        $match = new Matcher;
        $match->match();
    }
}