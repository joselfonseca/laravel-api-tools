<?php

namespace Joselfonseca\LaravelApiTools\Tests;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(realpath(__DIR__.'/../tests/migrations'));
    }
}