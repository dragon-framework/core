<?php
namespace Dragon\Component\Database;

use Dragon\Bridge\BridgeInterface;
use Dragon\Component\Database\Builder;

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
     * return the database Handle
     *
     * @param string $statement The statement name
     * @return void
     */
    public function dbh(string $statement)
    {
        return $this->getDbh($statement);
    }

    /**
     * Return true if config has statement
     *
     * @return boolean
     */
    public function hasStatement(): bool
    {
        return $this->statements->hasStatement();
    }

    public function isValidStatement(string $statementId)
    {
        return $this->statements->isValid($statementId);
    }
}