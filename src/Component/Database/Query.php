<?php
namespace Dragon\Component\Database;

abstract class Query 
{
    const ORDER_BY      = "orderBy";
    const ORDER_DIR     = "orderDir";
    const LIMIT         = "limit";
    const OFFSET        = "offset";
    const AND           = "AND";
    const OR            = "OR";

    public function find($id)
    {
        dump("Query Find ....");
    }

    public function findAll(?array $options=[])
    {
        $options = array_merge([
            self::ORDER_BY  => '',
            self::ORDER_DIR => 'ASC',
            self::LIMIT     => null,
            self::OFFSET    => null,
        ], $options);

        // dump (getApp()->model()->getConnexion('main') );
        // dump (getApp()->model()->getDatabases() );
        // dump (getApp()->model()->getDatabase('main') );
        dump("Abstract Model Query Find All ....");
    }

    public function findBy()
    {
        dump("Abstract Model Query Find By ....");
    }

    public function search()
    {
        dump("Abstract Model Query Search ....");
    }

    public function delete()
    {
        dump("Abstract Model Query Delete ....");
    }

    public function insert()
    {
        dump("Abstract Model Query Insert ....");
    }

    public function update()
    {
        dump("Abstract Model Query Update ....");
    }
}