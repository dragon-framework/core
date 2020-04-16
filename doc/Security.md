# Security

- [Configuration](#configuration)

## Configuration {#configuration}

Create the `config/security.php` based on `config/security-dist.php`.

|Key|Type|Default|Description|
|--|--|--|--|
|`authentication`|`bool`|true|Activate security module.|
|`authentication_strategy`|`string`|"email"|Define the security strategy<br>Values : `password`|`email`|`2fa`.|
|`authentication_property`|`string`|"email"|User propety used to identify the user.|
|`registration_allowed`|`bool`|false|If true, anybody can create an account to the application.|
|`registration_default_roles`|`array`|[]|Define defaults roles for new members.|
|`login_redirect`|`string`|"_profile"|The name of the route you want to redirect after user log in.|
|`logout_redirect`|`string`|"_login"|The name of the route you want to redirect after user log out.|
