<?php
namespace Dragon\Component\Mailer;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Mailer\Builder;

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