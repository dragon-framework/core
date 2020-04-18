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

    '_login' => [
        'path'          => "/login",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#login",
        'methods'       => ["GET", "POST"],
    ],

    '_authentication' => [
        'path'          => "/login/[:token]",
        'controller'    => "Dragon\\Component\\Security\\SecurityController#login",
        'methods'       => ["GET"],
    ]

];

return array_merge(
    $routes_Documentation,
    $routes_Security
);
