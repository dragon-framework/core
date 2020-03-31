<?php
namespace Dragon\Component\Routing;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Routing\Builder;

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

    /**
     * Magical Get
     *
     * @param string $key
     * @return void
     */
    public function get(string $key)
    {
        $methodName = "get" . ucfirst(strtolower($key));

        return $this->$methodName();
    }
}