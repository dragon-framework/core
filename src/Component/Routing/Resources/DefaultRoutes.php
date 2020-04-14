<?php 
return [

    '_doc' => [
        'path'          => "/documentation",
        'children'      => [
            'index'     => [
                'path'          => "",
                'controller'    => "Dragon\\Component\\Controller\\DocController#index",
                'methods'       => ["GET"],
                // 'targets'       => ["public"]
            ],
            'section'   => [
                'path'          => "/[:section]/[:md5]",
                'controller'    => "Dragon\\Component\\Controller\\DocController#section",
                'methods'       => ["GET"],
                // 'targets'       => ["public"]
            ]
        ]
    ],

];
