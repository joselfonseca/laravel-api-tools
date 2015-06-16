<?php

namespace Joselfonseca\LaravelApiTools\Auth;

use Joselfonseca\LaravelApiTools\Exceptions\InvalidArgumentException;

/**
 * Description of Auth
 *
 * @author josefonseca
 */
class Auth
{
    private $provider;

    public function __construct()
    {
        $class = 'Joselfonseca\\LaravelApiTools\\Auth\\Providers\\'.ucfirst(config('laravel-api-tools.auth'));
        if (!class_exists($class)) {
            throw new InvalidArgumentException('Auth provider not available. '.$class);
        }
        $this->provider = app($class);
    }

    public function authenticate()
    {
        $this->provider->authenticate();
    }

    public function getAuthenticatedUser()
    {
        return $this->provider->getAuthenticatedUser();
    }
}