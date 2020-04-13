<?php 
namespace Dragon\Component\Environnement;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Environnement\Builder;

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