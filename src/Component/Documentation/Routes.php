<?php return [
    '_doc' => [
        'path'          => "/documentation",
        'children'      => [

            'index' => [
                'path'          => "",
                'controller'    => "Dragon\\Component\\Documentation\\Controller#index",
                'methods'       => ["GET"],
            ],

            'section' => [
                'path'          => "/[:section]/[:md5]",
                'controller'    => "Dragon\\Component\\Documentation\\Controller#section",
                'methods'       => ["GET"],
            ],

            'examples' => [
                'path'          => "/examples",
                'controller'    => "Dragon\\Component\\Documentation\\Controller#examples",
                'methods'       => ["GET"],
            ],

        ]
    ]
];