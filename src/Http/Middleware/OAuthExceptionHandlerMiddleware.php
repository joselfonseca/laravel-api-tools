<?php

namespace Joselfonseca\LaravelApiTools\Http\Middleware;

use Closure;
use League\OAuth2\Server\Exception\OAuthException;
use League\OAuth2\Server\Exception\InvalidRequestException;

/**
 * Class OAuthExceptionHandlerMiddleware
 * @package Joselfonseca\LaravelApiTools\Http\Middleware
 */
class OAuthExceptionHandlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            return $next($request);
        } catch (InvalidRequestException $e) {
            $data = [
                'error' => $e->errorType,
                'error_description' => $e->getMessage(),
            ];
            dd($data);
        }
    }
}