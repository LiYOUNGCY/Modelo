<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Http\Common;
use App\Model\Order;
use App\Model\User;
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
//        $user = User::firstOrNew(['openid' => '123']);
//        var_dump($user);

        User::firstOrCreate(['openid' => '123']);
    }

    public function login(Request $request)
    {
        $user = User::findOrNew(1);
        $user->nickname = '管理员';
        $user->save();

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
