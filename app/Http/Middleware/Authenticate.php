<?php

namespace App\Http\Middleware;

use App\Container\Container;
use Closure;


class Authenticate
{
    public function handle($request, Closure $next)
    {
        Container::setUser(8);
        
        return $next($request);
    }
}
