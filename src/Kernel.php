<?php 

namespace Dragon;

use Dragon\Bridge\Bridge;
use Dragon\Component\Routing\Matcher;

class Kernel extends Bridge
{
    public function run()
    {
        if ($this->config()->get('session'))
        {
            session_start();
        }

        $match = new Matcher;
        $match->match();
    }
}