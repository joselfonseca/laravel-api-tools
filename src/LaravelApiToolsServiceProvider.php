<?php

namespace Joselfonseca\LaravelApiTools;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Joselfonseca\LaravelApiTools\Responders\JsonResponder;

class LaravelApiToolsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $providers = [
        'Dingo\Api\Provider\LaravelServiceProvider',
        'Tymon\JWTAuth\Providers\JWTAuthServiceProvider'
    ];


    protected $aliases   = [
        'JWTAuth' => 'Tymon\JWTAuth\Facades\JWTAuth',
        'JWTFactory' => 'Tymon\JWTAuth\Facades\JWTFactory'
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        /** Lets create an alias * */
        AliasLoader::getInstance()->alias('ApiToolsResponder', 'Joselfonseca\LaravelApiTools\ApiToolsResponder');
        /** Bind the default clases * */
        $this->app->bind('JsonResponder', function() {
            return new JsonResponder;
        });
        $this->registerOtherProviders()->registerAliases();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array();
    }

    private function registerOtherProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
        return $this;
    }

    private function registerAliases()
    {
        foreach ($this->aliases as $alias => $original) {
            AliasLoader::getInstance()->alias($alias, $original);
        }
        return $this;
    }

}
