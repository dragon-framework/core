<?php 

use Dragon\Component\Config\Definition;

return [
    
    /**
     * Default DevHosts
     * 
     * @var array<string>
     */
    Definition::DEV_CONFIG_HOSTS => [
        "127.0.0.1",
        "localhost",
    ],
    
    /**
     * Default DevHosts
     * 
     * @var bool Default: true
     */
    Definition::DEV_CONFIG_ADEX => true,

];