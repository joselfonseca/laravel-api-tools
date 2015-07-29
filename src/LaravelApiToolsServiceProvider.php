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
    public function boot()
    {
        $this->app['router']->middleware('api.cors',
            'Joselfonseca\LaravelApiTools\Http\Middleware\Cors');
        $this->app['router']->middleware('api.csfroff',
            'Joselfonseca\LaravelApiTools\Http\Middleware\CsrfTokenOff');
        $this->publishes([
            __DIR__ . '/../config/laravel-api-tools.php' => config_path('laravel-api-tools.php'),
        ], 'LAPIconfig');
        config([
            'api.auth.jwt' => function ($app) {
                return new \Dingo\Api\Auth\Provider\JWT($app['Tymon\JWTAuth\JWTAuth']);
            }
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerOtherProviders()
            ->registerAliases();
        \Config::set('jwt.user', \Config::get('auth.model'));
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

}