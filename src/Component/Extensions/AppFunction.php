<?php 
namespace Dragon\Component\Extensions;

class AppFunction
{
    public function getFunctions(): array
    {
        return [
            'app'
        ];
    }

    public function app()
    {
        return getApp();
    }
}