# Laravel API Tools - Authentication

You can restrict the access to endpoints by adding the protected parameter to the route group as shown below

```php
	$api->group(['protected' => true], function($api) {
	    $api->resource('/users', 'Users\UserController');
	});
```
Depending on the provider configured in the config/api.php file, an authorization header will be required to access the endpoint.

## Authentication Providers
Since this functionality is inherited from Dingo API, you can use Basic, JWT or oAuth2 and the authentication providers, for more info about the usage please visit  [https://github.com/dingo/api/wiki/Authentication](https://github.com/dingo/api/wiki/Authentication)

## Default Provider

The default providers are Basic and JWT. here is an example of a resource protected by JWT

```php
	$api->group(['protected' => true, 'providers' => ['jwt']], function($api) {
	    $api->resource('/users', 'Users\UserController');
	});
```