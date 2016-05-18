<?php

namespace App\Http\Middleware;

use App\Container\Container;
use App\Http\Common;
use App\Model\User;
use Closure;
use Illuminate\Http\Request;


class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('user')) {
            if (Common::checkLoginCookie()) {
                session()->put('user', Container::getUser()->id);
                return $next($request);
            } else {
                //记录当前的 url
                $url = $request->getUri();
                session()->put('_url', $url);
                return redirect('wechat/login');
            }
        } else {
            $userId = session()->get('user');
            Container::setUser($userId);
            return $next($request);
        }
    }
}
