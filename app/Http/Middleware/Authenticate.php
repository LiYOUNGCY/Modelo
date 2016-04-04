<?php

namespace App\Http\Middleware;

use App\Model\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        $user = User::find(7);
        User::setUser($user);
        
        return $next($request);
    }
}
