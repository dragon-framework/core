# Security

- [Configuration](#configuration)
- [Routes](#routes)

## Configuration {#configuration}

Create the `config/security.php` based on `config/security-dist.php`.

|Key|Type|Default|Description|
|--|--|--|--|
|`authentication`|`bool`|true|Activate security module.|
|`authentication_strategy`|`string`|"email"|Define the security strategy<br>Values : `password`|`email`|`2fa`.|
|`authentication_property`|`string`|"email"|User propety used to identify the user.|
|`registration_allowed`|`bool`|false|If true, anybody can create an account to the application.|
|`registration_default_roles`|`array`|[]|Define defaults roles for new members.|
|`redirect_on_login`|`string`|"_profile"|The name of the route you want to redirect after user log in.|
|`redirect_on_logout`|`string`|"_login"|The name of the route you want to redirect after user log out.|

## Routes {#routes}

Routing definition for security section.

|Name|Methods|Path|Description|
|--|--|--|--|
|`_register`|`GET`,`POST`|`/register`|User registratrion.|
|`_login`|`GET`,`POST`|`/login`|User login (see login strategy).|
|`_logout`|`GET`|`/logout`|User logout.|
|`_authentication`|`GET`|`/login/[:token]`|Proceed to login (see login strategy).|
|`_forgotten_username`|`GET`,`POST`|`/forgotten-username`|Form to retrieve user name.|
|`_forgotten_password`|`GET`,`POST`|`/forgotten-password`|Form to retrieve password.|
|`_reset_password`|`GET`,`POST`|`/reset-password`|Form to reset password.|
