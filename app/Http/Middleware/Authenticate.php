<?php

namespace App\Http\Middleware;

use App\Container\Container;
use Closure;


class Authenticate
{
    public function handle($request, Closure $next)
    {
        Container::setUser(2);
        
        return $next($request);
    }
}
