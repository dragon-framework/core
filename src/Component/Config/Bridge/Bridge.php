<?php
namespace Dragon\Component\Config\Bridge;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Config\Builder\Builder;

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