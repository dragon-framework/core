<?php
namespace Dragon\Component\Database;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Database\Connect;

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
     * dbh getter
     *
     * @param string $key
     * @return void
     */
    public function dbh(string $key)
    {
        return $this->getDbh($key);
    }
}