<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class ViewHelper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->share('ADMIN', Config::get('constants.route.admin'));
        return $next($request);
    }
}
