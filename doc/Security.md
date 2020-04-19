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

#### Registration strategy

|Key|Type|Default|Description|
|--|--|--|--|
|`registration_allowed`|`bool`|false|If true, anybody can create an account to the application.|
|`registration_default_roles`|`array`|[]|Define defaults roles for new members.|
|`authentication_on_registration`|`bool`|false|Automaticaly log in the user after registration.|

#### Password strategy

|Key|Type|Default|Description|
|--|--|--|--|
|`password_min_lenght`|`integer`|8|.|
|`password_encoder`|`string`|"default"|Define the algorythm to use to hash the password.|

#### Redirection after event

|Key|Type|Default|Description|
|--|--|--|--|
|`redirect_on_login`|`string`|"_profile"|Route to redirect user after login.|
|`redirect_on_logout`|`string`|"_login"|Route to redirect user after logout.|
|`redirect_on_registration`|`string`|"_login"|Route to redirect user after registration.|

#### Activation strategy

|Key|Type|Default|Description|
|--|--|--|--|
|`activation`|`bool`|false|Registration need activation.|
|`activation_delayed`|`integer`|0|Delay (in minute) before user must activate his account to accede to the service.|

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
