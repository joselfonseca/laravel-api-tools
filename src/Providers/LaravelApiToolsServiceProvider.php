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
        $this->registerConfig();
        $this->commands(GenerateEntities::class);
        $this->app->bind(Handler::class, \Joselfonseca\LaravelApiTools\Exceptions\Handler::class);
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