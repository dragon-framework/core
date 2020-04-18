<?php 

$routes_Documentation = [
    '_doc' => [
        'path'          => "/documentation",
        'children'      => [
            'index'     => [
                'path'          => "",
                'controller'    => "Dragon\\Component\\Documentation\\Controller#index",
                'methods'       => ["GET"],
                // 'targets'       => ["public"]
            ],
            'section'   => [
                'path'          => "/[:section]/[:md5]",
                'controller'    => "Dragon\\Component\\Documentation\\Controller#section",
                'methods'       => ["GET"],
                // 'targets'       => ["public"]
            ]
        ]
    ]
];

$routes_Security = [

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

];

return array_merge(
    $routes_Documentation,
    $routes_Security
);
