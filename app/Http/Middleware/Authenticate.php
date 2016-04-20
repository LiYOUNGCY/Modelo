<?php

namespace App\Http\Middleware;

use App\Container\Container;
use App\Model\User;
use Closure;


class Authenticate
{
    public function handle($request, Closure $next)
    {
        $user = User::findOrNew(7);
//        $user->nickname = 'Rache';
//        $user->save();
        Container::setUser(7);

        return $next($request);
    }
}
