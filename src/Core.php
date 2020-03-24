<?php 

namespace Dragon;

class Core
{
	const APP_DIR = './../app/';
	const SRC_DIR = './../src/';
    const WEB_DIR = './../web/';
    

    
    /**
     * The App config
     *
     * @var array
     */
    private $config = [];

    public function __construct()
    {


        echo "App Construct<br>";
        echo self::APP_DIR."<br>";

		// Config directory
		$dir = self::APP_DIR.'config/';
        echo $dir."<br>";



		// Config files
		$config      = $dir.'config.php';
		$config_dev  = $dir.'config_dev.php';
        $config_test = $dir.'config_test.php';
        

        include $config;
    }

    public function run()
    {
        return "Run thE aPP";
    }
}