<?php
namespace Dragon\Component\Database\Bridge;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Database\Connect\Connect;

class Bridge extends Connect implements BridgeInterface
{
    /**
     * The Brige method
     *
     * @return self
     */
    public function getBridge(): self
    {
        return $this;
    }
}