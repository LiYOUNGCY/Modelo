<?php

namespace App\Http\Middleware;

use App\Container\Container;
use App\Model\User;
use Closure;


class Authenticate
{
    public function handle($request, Closure $next)
    {
//        echo session()->get('user');
//        echo "<pre>";print_r($_SESSION);echo "<pre>";
//        if (!session('user')) {
//            return redirect('wechat/login');
//        } else {
//            $user = session('user');
//            Container::setUser($user);
//        }
        Container::setUser(6);
        return $next($request);
    }
}
