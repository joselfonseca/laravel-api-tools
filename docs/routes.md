# Laravel Api Tools Routes

## API Prefix
As part of the configuration, you need to provide an API prefix to your routes, to do so, in your .env file add a API_PREFIX variable as shown below

```bash
	API_PREFIX=api
```

After having the prefix, the next thing you need to do is create your routes, since the package uses Dingo Api, you need to get an instance of the router and register the routes using dingo's router.

```php
	$api = app('Dingo\Api\Routing\Router');
	$api->version('v1', 'namespace' => 'Joselfonseca\LaravelAdminRest\Http\Controllers'], function ($api) {
	    $api->group(['prefix' => 'auth'], function($api) {
	        $api->post('login', 'Auth\AuthController@login');
	    });
	    $api->group(['protected' => true, 'providers' => ['jwt']], function($api) {
	        $api->resource('/users', 'Users\UserController');
	    });
	});
```

Now you can register all your routes inside the routes as shown above.

## API Versioning

You can version your resources by indicating the version number in the version group, if you have a new version for a route just create a new group and specify the version as shown below.

```php
	$api = app('Dingo\Api\Routing\Router');
	$api->version('v2', 'namespace' => 'Joselfonseca\LaravelAdminRest\Http\Controllers'], function ($api) {
	 
	});
```

If you want the same route to respond to version 1 and 2, you can pass an array with the versions as shown below.

```php
	$api = app('Dingo\Api\Routing\Router');
	$api->version(['v1', 'v2'], 'namespace' => 'Joselfonseca\LaravelAdminRest\Http\Controllers'], function ($api) {
	 
	});
```

## Middlewares

The package has 2 middlewares that may help you, the first one is 'Joselfonseca\LaravelApiTools\Http\Middleware\Cors' which will help you sole that very annoying Cross Domain issue, if you only want to accept request from your domain, do not add this middleware. The second is 'Joselfonseca\LaravelApiTools\Http\Middleware\CsrfTokenOff' which will ignore the CSRF validation for all the routes in the group API. Adding this 2 middlewares our routes should look like this:

```php
	$api->version('v1', ['middleware' => ['Joselfonseca\LaravelApiTools\Http\Middleware\Cors', 'Joselfonseca\LaravelApiTools\Http\Middleware\CsrfTokenOff']], function(){
	 
	});
```
To be able to use the CsrfTokenOff middleware, remove the VerifyCsrfToken middleware shipped with laravel. or you can just add your endpoints group to the except array in that group

For more information about routing you can visit [https://github.com/dingo/api/wiki/Creating-API-Endpoints](https://github.com/dingo/api/wiki/Creating-API-Endpoints)