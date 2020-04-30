<?php return [

    '_register' => [
        'path'          => "/register",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#register",
        'methods'       => ["GET", "POST"],
        'guards'        => [ROLE_ANONYMOUS],
    ],

    '_login' => [
        'path'          => "/login",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#login",
        'methods'       => ["GET", "POST"],
        'guards'        => [ROLE_ANONYMOUS],
    ],

    '_logout' => [
        'path'          => "/logout",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#logout",
        'methods'       => ["GET"],
        'guards'        => [ROLE_ANONYMOUS],
    ],

    '_authentication' => [
        'path'          => "/login/[:token]",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#login",
        'methods'       => ["GET"],
        'guards'        => [ROLE_ANONYMOUS],
    ],

    '_forgotten_username' => [
        'path'          => "/forgotten-username",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#forgotten_username",
        'methods'       => ["GET", "POST"],
        'guards'        => [ROLE_ANONYMOUS],
    ],

    '_forgot_password' => [
        'path'          => "/forgot-password",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#forgot_password",
        'methods'       => ["GET", "POST"],
        'guards'        => [ROLE_USER],
    ],

    '_reset_password' => [
        'path'          => "/reset-password",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#reset_password",
        'methods'       => ["GET", "POST"],
        'guards'        => [ROLE_USER],
    ],

    // '_profile' => [
    //     'path'          => "/profile",
    //     'controller'    => "Dragon\\Component\\Security\\SecurityController#profile",
    //     'methods'       => ["GET"],
    //     'guards'        => [ROLE_USER],
    // ],

    '_activation' => [
        'path'          => "/activation/[:token]",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#activation",
        'methods'       => ["GET"],
        'guards'        => [ROLE_ANONYMOUS],
    ],

];