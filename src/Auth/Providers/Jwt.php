<?php

namespace Joselfonseca\LaravelApiTools\Auth\Providers;

use Joselfonseca\LaravelApiTools\Auth\AuthenticationProviderInterface;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Joselfonseca\LaravelApiTools\Exceptions\AuthorizationException;

/**
 * Description of Jwt
 *
 * @author josefonseca
 */
class Jwt implements AuthenticationProviderInterface
{
    protected $user;

    public function authenticate()
    {
        try {
            $this->user = \JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            throw new AuthorizationException('Token Expired');
        } catch (TokenInvalidException $e) {
            throw new AuthorizationException('Token Invalid');
        }
    }

    public function getAuthenticatedUser()
    {
        return $this->user;
    }
}