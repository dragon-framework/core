<?php 

namespace Dragon;

use Dragon\Bridge\Bridge;
use Dragon\Component\Routing\Matcher\Match;

class Kernel extends Bridge
{
    public function run()
    {
        if ($this->config()->get('session'))
        {
            session_start();
        }

        $match = new Match;
        $match->match();
    }
}