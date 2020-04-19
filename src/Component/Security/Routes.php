<?php return [

    '_register' => [
        'path'          => "/register",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#register",
        'methods'       => ["GET", "POST"],
    ],

    '_login' => [
        'path'          => "/login",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#login",
        'methods'       => ["GET", "POST"],
    ],

    '_logout' => [
        'path'          => "/logout",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#logout",
        'methods'       => ["GET"],
    ],

    '_authentication' => [
        'path'          => "/login/[:token]",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#login",
        'methods'       => ["GET"],
    ],

    '_forgotten_username' => [
        'path'          => "/forgotten-username",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#forgotten_username",
        'methods'       => ["GET", "POST"],
    ],

    '_forgotten_password' => [
        'path'          => "/forgotten-password",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#forgotten_password",
        'methods'       => ["GET", "POST"],
    ],

    '_reset_password' => [
        'path'          => "/reset-password",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#reset_password",
        'methods'       => ["GET", "POST"],
    ],

    '_profile' => [
        'path'          => "/profile",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#profile",
        'methods'       => ["GET"],
    ],

    '_activation' => [
        'path'          => "/activation/[:token]",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#activation",
        'methods'       => ["GET"],
    ],

];