<?php 
namespace Dragon\Component\Extensions;

class DumpFunction
{
    public function getFunctions(): array
    {
        return [
            'dump'
        ];
    }

    public function dump($data)
    {
        dump( $data );
    }
}