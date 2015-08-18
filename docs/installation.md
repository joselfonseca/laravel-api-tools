# Laravel Api Tools Installation

To instal this package, please open your composer.json file and add the dependency

```json
	"require": {
	    ...
	    "joselfonseca/laravel-api-tools" : "1.2.*"
	    ...
	}
```
Once you add the dependency, in the console run:

```bash
	composer update
```

Once all the dependencies have been installed, open the file config/app.php and add the service provider at the end of the file.

```php
	'providers': [
	    ...
	    Joselfonseca\LaravelApiTools\LaravelApiToolsServiceProvider::class,
	    ...
	]
```
Lastly publish the configuration file for laravel api tools and dingo by running these 2 commands:

```bash
	php artisan vendor:publish --provider="Joselfonseca\LaravelApiTools\LaravelApiToolsServiceProvider"
	php artisan vendor:publish --provider="Dingo\Api\Provider\LaravelServiceProvider"
```

Laravel API Tools is now installed.

