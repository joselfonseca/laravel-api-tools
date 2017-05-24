laravel-api-tools
=================

[![Build Status](https://travis-ci.org/joselfonseca/laravel-api-tools.svg?branch=master)](https://travis-ci.org/joselfonseca/laravel-api-tools)
[![Latest Stable Version](https://poser.pugx.org/joselfonseca/laravel-api-tools/v/stable.svg)](https://packagist.org/packages/joselfonseca/laravel-api-tools) 
[![Total Downloads](https://poser.pugx.org/joselfonseca/laravel-api-tools/downloads.svg)](https://packagist.org/packages/joselfonseca/laravel-api-tools) 
[![Latest Unstable Version](https://poser.pugx.org/joselfonseca/laravel-api-tools/v/unstable.svg)](https://packagist.org/packages/joselfonseca/laravel-api-tools) 
[![License](https://poser.pugx.org/joselfonseca/laravel-api-tools/license.svg)](https://packagist.org/packages/joselfonseca/laravel-api-tools)

## Versions

Please note this is the 2.0 version which is a complete re write, if you are looking for the previous version with Dingo, check the 1.4 branch

## Installation

To install this update your composer.json file to require

```json
    "joselfonseca/laravel-api-tools" : "~2.0"
```
Once the dependencies have been downloaded, add the service provider to your config/app.php file

```php
    'providers' => [
        ...
        Joselfonseca\LaravelApiTools\Providers\LaravelApiToolsServiceProvider::class
        ...
    ]
```
You are done with the installation!

## Documentation

For documentation on this package, please visit the [docs folder](https://github.com/joselfonseca/laravel-api-tools/tree/2.2/docs).

## Change log

Please see the releases page [https://github.com/joselfonseca/laravel-api-tools/releases](https://github.com/joselfonseca/laravel-api-tools/releases)

## Tests

To run the test in this package, navigate to the root folder of the project and run

```bash
    composer install
```
Then

```bash
    vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email jose at ditecnologia dot com instead of using the issue tracker.

## Credits

- [Jose Luis Fonseca](https://github.com/joselfonseca)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](license.md) for more information.