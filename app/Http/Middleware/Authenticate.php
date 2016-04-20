<?php

namespace App\Http\Middleware;

use App\Container\Container;
use App\Model\User;
use Closure;


class Authenticate
{
    public function handle($request, Closure $next)
    {
        echo session('user');
//        if (!session('user')) {
//            return redirect('wechat/login');
//        } else {
//            $user = session('user');
//            Container::setUser($user);
//        }
        exit();
        return $next($request);
    }
}
