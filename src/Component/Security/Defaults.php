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
    'redirect_on_activation' => "_login",

    'activation' => true,
    'activation_delayed' => 0,

    'password_min_lenght' => 8,
    'password_encoder' => "default",

    // Email Authetication token
    'authentication_token_expiration' => 900,

    'activation_token_expiration' => 172800, // 48 h
    
];