<?php return [

    'table' => "users",

    'authentication' => true,
    'authentication_strategy' => "email",
    'authentication_property' => "email",

    'registration_allowed' => false,
    'registration_default_roles' => [],

    'login_redirect' => "_profile",
    'logout_redirect' => "_login",
    
];