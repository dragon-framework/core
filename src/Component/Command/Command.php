<?php
namespace Dragon\Component\Command;

class Command
{
    public function __construct(array $params)
    {
        print_r( $params );
    }
}