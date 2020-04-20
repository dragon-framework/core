<?php return [

    '_register' => [
        'path'          => "/register",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#register",
        'methods'       => ["GET", "POST"],
        'guards'        => ["ANONYMOUS"],
    ],

    '_login' => [
        'path'          => "/login",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#login",
        'methods'       => ["GET", "POST"],
        'guards'        => ["ANONYMOUS"],
    ],

    '_logout' => [
        'path'          => "/logout",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#logout",
        'methods'       => ["GET"],
        'guards'        => ["ANONYMOUS"],
    ],

    '_authentication' => [
        'path'          => "/login/[:token]",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#login",
        'methods'       => ["GET"],
        'guards'        => ["ANONYMOUS"],
    ],

    '_forgotten_username' => [
        'path'          => "/forgotten-username",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#forgotten_username",
        'methods'       => ["GET", "POST"],
        'guards'        => ["ANONYMOUS"],
    ],

    '_forgotten_password' => [
        'path'          => "/forgotten-password",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#forgotten_password",
        'methods'       => ["GET", "POST"],
        'guards'        => ["AUTHENTICATED"],
    ],

    '_reset_password' => [
        'path'          => "/reset-password",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#reset_password",
        'methods'       => ["GET", "POST"],
        'guards'        => ["AUTHENTICATED"],
    ],

    '_profile' => [
        'path'          => "/profile",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#profile",
        'methods'       => ["GET"],
        'guards'        => ["AUTHENTICATED"],
    ],

    '_activation' => [
        'path'          => "/activation/[:token]",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#activation",
        'methods'       => ["GET"],
        'guards'        => ["ANONYMOUS"],
    ],

];