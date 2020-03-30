<?php
namespace Dragon\Component\Routing\Bridge;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Routing\Builder\Builder;

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