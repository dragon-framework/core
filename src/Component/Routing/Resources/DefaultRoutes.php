<?php 
return [

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
    ],

];
