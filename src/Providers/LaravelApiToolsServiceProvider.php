<?php

namespace Joselfonseca\LaravelApiTools\Providers;

use App\Exceptions\Handler;
use Illuminate\Support\ServiceProvider;
use Joselfonseca\LaravelApiTools\Console\GenerateEntities;

/**
 * Class LaravelApiToolsServiceProvider
 * @package Joselfonseca\LaravelApiTools\Providers
 */
class LaravelApiToolsServiceProvider extends ServiceProvider
{


    /**
     *
     */
    public function boot()
    {
        $this->commands(GenerateEntities::class);
        $this->app->bind(Handler::class, \Joselfonseca\LaravelApiTools\Exceptions\Handler::class);
    }


    /**
     * Register the error handler for responses
     */
    public function register()
    {

    }

}