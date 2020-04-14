<?php 

use Dragon\Component\Config\Definition;
use Dragon\Component\Environment\Definition as EnvironmentDefinition;

return [

    /**
     * Default website title
     * 
     * @var string
     */
    Definition::CONFIG_TITLE => "",

    /**
     * Default execution environnement
     * 
     * @var string
     */
    Definition::CONFIG_ENVIRONMENT => EnvironmentDefinition::EXECUTION_MODE_PROD,
    
    /**
     * Default Session
     * 
     * @var bool
     */
    Definition::CONFIG_SESSION => true,

];