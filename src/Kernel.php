<?php 

namespace Dragon;

use Dragon\Bridge\Bridge;

class Kernel extends Bridge
{
    public function run()
    {
        // Session
        $this->config('session') ? session_start() : null;

        return "Run thE aPP";
    }
}