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

    /**
     * Get the config for all databases
     *
     * @return array
     */
    public function getDefinition(?string $key = null): array
    {
        return $this->definition->get();
    }

    public function getConnexions()
    {
        // return $this->_getConnexion($handle);
    }

    public function getConnexion(string $handle)
    {
        // return $this->_getConnexion($handle);
    }
}