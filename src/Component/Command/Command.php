<?php
namespace Dragon\Component\Command;

use Dragon\Kernel;

class Command extends Kernel
{
    public function __construct(array $params)
    {
        unset($params[0]);

        foreach ($params as $param)
        {
            $this->$param();
        }
    }

    public function serve()
    {
        exec("php -S ".$this->config('dev-host').":".$this->config('dev-port')." -t public/");
    }

}