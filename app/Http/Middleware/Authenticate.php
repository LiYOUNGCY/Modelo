<?php

namespace App\Http\Middleware;

use App\Container\Container;
use App\Model\User;
use Closure;


class Authenticate
{
    public function handle($request, Closure $next)
    {
        if(! session('user')) {
            
        }

        return $next($request);
    }
}
