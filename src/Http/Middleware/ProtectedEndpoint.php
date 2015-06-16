<?php

namespace Joselfonseca\LaravelApiTools\Http\Middleware;

use Closure;

/**
 * Description of Protected
 *
 * @author josefonseca
 */
class ProtectedEndpoint
{

    protected $auth;

    public function __construct()
    {
        $this->auth = app('api.auth');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->auth->authenticate();
        return $next($request);
    }
}