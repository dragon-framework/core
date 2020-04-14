<?php 
return [

    /**
     * Documentation
     */

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


    /**
     * Security
     */

    '_login' => [
        'path'          => "/login",
        'controller'    => "Dragon\\Component\\Security\\Controller#login",
        'methods'       => ["GET", "POST"],
        // 'targets'       => ["admin"],
    ],

];
