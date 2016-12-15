<?php

namespace Joselfonseca\LaravelApiTools\Providers;

use App\Exceptions\Handler;
use Illuminate\Support\ServiceProvider;

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

    }


    /**
     * Register the error handler for responses
     */
    public function register()
    {
        $this->app->bind(Handler::class, \Joselfonseca\LaravelApiTools\Exceptions\Handler::class);
    }

}