<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        $user = User::findorNew(7);
        $user->nickname = 'test4';
        $user->save();

        User::setUser($user);
        
        return $next($request);
    }
}
