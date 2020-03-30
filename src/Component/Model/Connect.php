<?php 
namespace Dragon\Component\Model;

class Connect 
{
    private static $db = [];

    public static function getDb(string $handle)
    {
        if (!isset( self::$db[$handle] ))
        {
            self::setDb($handle);
        }

        return self::$db[$handle];
    }

    public static function setDb(string $handle)
    {
        $databases = getApp()->config()->getConfig('databases');


        dump($databases);
    }
}