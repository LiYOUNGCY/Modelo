<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Http\Common;
use App\Model\Order;
use App\Model\Profit;
use App\Model\User;
use App\Model\UserQrCode;
use Illuminate\Http\Request;
use App\Http\Requests;
use Config;
use Cookie;
use Log;
use Session;
use Illuminate\Http\Response;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $userService  = app('wechat')->user();

        $info = $userService->get('o4-YOwDNj08Y8NMbhbjQspPb7twg');

        echo '<pre>';
        var_dump($info);
        echo '</pre>';
    }

    public function login(Request $request)
    {
        $user = User::find(1);

        if(is_null($user)) {
            throw new \Exception("请运行 install .");
        }

        Container::setUser($user->id);

        Common::createLoginCookie();

        #Log::info("user: {$user->id}");

        echo 'Success';
    }

    public function logout(Request $request)
    {
        Session::forget('user');
        $cookieName = Config::get('constants.rememberCookie');
        Cookie::queue($cookieName, null , -1); // 销毁
    }

    public function check()
    {
        $session = session()->get('user');
        echo '<pre>'; print_r($session); echo '</pre>';

        $cookieName = Config::get('constants.rememberCookie');
        $cookie = Cookie::get($cookieName);
        echo '<pre>'; print_r($cookie); echo '</pre>';
    }

    public function pay()
    {
        $wechat_order_no = '1462067555I4pKwTEBVDK0qzvKHIkgGB';
        Order::payOrder($wechat_order_no);
    }
}
