<?php

namespace App\Http\Controllers;

use App\Container\Container;
use App\Http\Common;
use App\Model\Order;
use App\Model\User;
use App\Model\UserQrCode;
use App\Model\UserRelation;
use Illuminate\Http\Request;
use App\Http\Requests;
use Config;
use Cookie;
use Log;
use Session;
use DB;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $user = User::findOrNewByOpenid('o4-YOwGt2lQeTZyOaV3_66RlTA3Q');
        var_dump($user);
        //判断用户没有订单
        if (Order::getBuyCount($user->id) == 0) {

            //判断是否从魔豆树进来
            if (UserRelation::hasParent($user->id)) {
                $parentId = UserRelation::getParent($user->id)->parent;
                if ($parentId == 1) {
                    UserRelation::remove($user->id);
                }
            }
        }
    }

    public function login(Request $request)
    {
        $user = User::find(1);

        if (is_null($user)) {
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
        Cookie::queue($cookieName, null, -1); // 销毁
    }

    public function check()
    {
        $session = session()->get('user');
        echo '<pre>';
        print_r($session);
        echo '</pre>';

        $cookieName = Config::get('constants.rememberCookie');
        $cookie = Cookie::get($cookieName);
        echo '<pre>';
        print_r($cookie);
        echo '</pre>';
    }

    public function refreshWechatNickname()
    {
        $app = app('wechat');
        $userService = $app->user;
        $users = User::all();
        foreach ($users as $user) {
            if (!empty($user->openid)) {
                $info = $userService->get($user->openid);
                $user->nickname = $info->nickname;
                $user->save();
            }
        }
    }

    public function refreshReferee()
    {
        $users = User::all();

        foreach ($users as $user) {
            $referee = DB::table('user')
                ->join('user_relation', 'user_relation.parent_id', '=', 'user.id')
                ->where('user_relation.children_id', $user->id)
                ->select('user.nickname')
                ->first();

            var_dump($referee);
            if (isset($referee)) {
                $user->referee = $referee->nickname;
            }
        }
    }
}
