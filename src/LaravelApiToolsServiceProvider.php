<?php

namespace Joselfonseca\LaravelApiTools;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use League\OAuth2\Server\Exception\OAuthException;
use Joselfonseca\LaravelApiTools\Exceptions\OAuthExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Joselfonseca\LaravelApiTools\Exceptions\UnauthorizedExceptionHandler;

/**
 * Class LaravelApiToolsServiceProvider
 * @package Joselfonseca\LaravelApiTools
 */
class LaravelApiToolsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $providers = [
        \Dingo\Api\Provider\LaravelServiceProvider::class,
        \Tymon\JWTAuth\Providers\JWTAuthServiceProvider::class,
        \LucaDegasperi\OAuth2Server\Storage\FluentStorageServiceProvider::class,
        \LucaDegasperi\OAuth2Server\OAuth2ServerServiceProvider::class,
    ];
    /**
     * @var array
     */
    protected $aliases   = [
        'JWTAuth' => \Tymon\JWTAuth\Facades\JWTAuth::class,
        'JWTFactory' => \Tymon\JWTAuth\Facades\JWTFactory::class,
        'Authorizer' => \LucaDegasperi\OAuth2Server\Facades\Authorizer::class,
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
        app('Dingo\Api\Auth\Auth')->extend('jwt', function ($app) {
            return new \Dingo\Api\Auth\Provider\JWT($app['Tymon\JWTAuth\JWTAuth']);
        });
        $this->registerErrorHandlers();
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

    /**
     *
     */
    protected function registerErrorHandlers()
    {
        $handler = $this->app->make('api.exception');
        $handler->register(function(OAuthException $exception){
            return app(OAuthExceptionHandler::class)->handle($exception);
        });
        $handler->register(function(UnauthorizedHttpException $exception){
            return app(UnauthorizedExceptionHandler::class)->handle($exception);
        });
    }

}