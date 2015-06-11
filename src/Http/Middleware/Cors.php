<?php

namespace Joselfonseca\LaravelApiTools\Http\Middleware;

use Closure;
/**
 * Description of Cors
 *
 * @author josefonseca
 */

class Cors {

    public function handle($request, Closure $next) {
        return $next($request)->header('Access-Control-Allow-Origin' , '*')
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With');

    }

}