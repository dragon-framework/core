<?php
namespace Dragon\Component\Routing;

use Dragon\Bridge\BridgeInterface;

class Bridge extends Router implements BridgeInterface
{
    public function getBridge(): array
    {
        return [
            'base' => $this->getBase(),
            'router' => $this->getRouter(),
        ];
    }
}