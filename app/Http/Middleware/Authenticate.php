<?php

namespace App\Http\Middleware;

use App\Container\Container;
use App\Http\Common;
use App\Model\User;
use Closure;


class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (!session('user')) {
            if (Common::checkLoginCookie()) {
                session()->put('user', Container::getUser()->id);
                return $next($request);
            } else {
                return redirect('wechat/login');
            }
        } else {
            $userId = session()->get('user');
            Container::setUser($userId);
            return $next($request);
        }
    }
}
