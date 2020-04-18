<?php return [

    'table' => "users",

    'authentication' => true,
    'authentication_strategy' => "email",
    'authentication_property' => "email",

    'registration_allowed' => false,
    'registration_default_roles' => [],
    'authentication_on_registration' => false,

    'redirect_on_login' => "_profile",
    'redirect_on_logout' => "_login",
    'redirect_on_registration' => "_login",
    
];