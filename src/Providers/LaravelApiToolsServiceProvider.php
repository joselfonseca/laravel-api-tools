<?php

namespace Joselfonseca\LaravelApiTools\Providers;

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
        $this->registerConfig();
    }


    /**
     * Register the error handler for responses
     */
    public function register()
    {

    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('api.php'),
        ]);
        $this->mergeConfigFrom(__DIR__.'/../../config/config.php', 'api');
    }

}