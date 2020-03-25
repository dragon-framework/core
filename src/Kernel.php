<?php 

namespace Dragon;

// use Exception;

class Kernel extends Bridge
{
    /**
     * The App config
     *
     * @var array
     */
    private $config;

    public function __construct()
    {
        $this->config = new \Dragon\Component\Config\Builder;
    }




    // public function config(?string $key = null)
    // {
    //     $config = $this->config->getConfig();

    //     if (!empty($key))
    //     {
    //         if (!isset($config[$key]))
    //         {
    //             throw new Exception("The index $key is not defined in your config.");
    //         }

    //         return $config[$key];
    //     }

    //     return $config;
    // }




    public function run()
    {
        // Session
        $this->config('session') ? session_start() : null;

        return "Run thE aPP";
    }
}