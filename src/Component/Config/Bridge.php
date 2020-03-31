<?php
namespace Dragon\Component\Config;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Config\Builder;

class Bridge extends Builder implements BridgeInterface
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