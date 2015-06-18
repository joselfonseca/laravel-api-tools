<?php

namespace Joselfonseca\LaravelApiTools;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Joselfonseca\LaravelApiTools\Responders\JsonResponder;

class LaravelApiToolsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer     = false;
    protected $providers = [
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
    public function boot()
    {
        $this->app->singleton('Illuminate\Contracts\Debug\ExceptionHandler',
            'Joselfonseca\LaravelApiTools\Exceptions\Handler');
        $this->app->singleton('api.auth',
            'Joselfonseca\LaravelApiTools\Auth\Auth');
        $this->app['router']->middleware('api.protected',
            'Joselfonseca\LaravelApiTools\Http\Middleware\ProtectedEndpoint');
        $this->app['router']->middleware('api.cors',
            'Joselfonseca\LaravelApiTools\Http\Middleware\Cors');
        $this->app['router']->middleware('api.csfroff',
            'Joselfonseca\LaravelApiTools\Http\Middleware\CsrfTokenOff');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /** Lets create an alias * */
        AliasLoader::getInstance()->alias('ApiToolsResponder',
            'Joselfonseca\LaravelApiTools\ApiToolsResponder');
        /** Bind the default clases * */
        $this->app->bind('JsonResponder',
            function() {
            return new JsonResponder;
        });
        $this->registerOtherProviders()
            ->registerAliases()
            ->publishConfiguration();
    }

    /**
     * Register other providers
     * @return \Joselfonseca\LaravelApiTools\LaravelApiToolsServiceProvider
     */
    private function registerOtherProviders()
    {
        foreach ($this->providers as $provider) {
            $this->app->register($provider);
        }
        return $this;
    }

    /**
     * Register other aliases
     * @return \Joselfonseca\LaravelApiTools\LaravelApiToolsServiceProvider
     */
    private function registerAliases()
    {
        foreach ($this->aliases as $alias => $original) {
            AliasLoader::getInstance()->alias($alias, $original);
        }
        return $this;
    }

    private function publishConfiguration()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-api-tools.php' => config_path('laravel-api-tools.php'),
        ], 'LAPIconfig');
        return $this;
    }
}