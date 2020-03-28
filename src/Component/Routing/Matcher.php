<?php 
namespace Dragon\Component\Routing;

class Matcher 
{
    public function __construct()
    {
       
        dump( getApp()->routing->getRoutes(); ); 
    }
}