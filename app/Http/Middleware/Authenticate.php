<?php

namespace App\Http\Middleware;

use App\Container\Container;
use App\Model\User;
use Closure;


class Authenticate
{
    public function handle($request, Closure $next)
    {
        $user = User::findOrNew(1);
        $user->nickname = 'Rache';
        $user->save();
        Container::setUser(1);

        return $next($request);
    }
}
