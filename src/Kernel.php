<?php 

namespace Dragon;

use Dragon\Bridge\Bridge;
use Dragon\Component\Routing\Matcher\Match;

class Kernel extends Bridge
{
    public function run()
    {
        // Session
        $this->config('session') ? session_start() : null;

        $match = new Match;
        $match->match();
    }
}