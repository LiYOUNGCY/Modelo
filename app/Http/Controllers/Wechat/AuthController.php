<?php

namespace App\Http\Controllers\Wechat;

use App\Container\Container;
use App\Exceptions\NotFoundException;
use App\Http\Common;
use App\Model\User;
use App\Model\UserRelation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat;
use Log;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $oauth = app('wechat')->oauth;

        return $oauth->scopes(['snsapi_base'])->redirect();
    }

    public function callback(Request $request)
    {
        $oauth = app('wechat')->oauth;

        $user = $oauth->user()->toArray();
    }

//    public function callback(Request $request)
//    {
//        try {
//            $wechatAuth = EasyWeChat::oauth();
//
//            $userMessage = $wechatAuth->user()->toArray();
//
//            if (empty($userMessage)) {
//                throw new NotFoundException("没有成功获取用户信息");
//            }
//
//            $userMessage = $userMessage['original'];
//
//            $user = User::findOrNewByOpenid($userMessage['openid'], [
//                'nickname' => $userMessage['nickname'],
//                'sex' => $userMessage['sex'],
//                'province' => $userMessage['province'],
//                'city' => $userMessage['city'],
//                'country' => $userMessage['country'],
//                'headimgurl' => $userMessage['headimgurl'],
//            ]);
//
//            //如果没有推荐人就当是官方推荐
//            if (!UserRelation::hasParent($user->id)) {
//                $userRelation = new UserRelation();
//                $userRelation->insert($user->id, 1);
//                $user->follow(1);
//            }
//
//            //create Cookie and Session
//            Container::setUser($user->id);
//            session()->put('user', $user->id);
//            Common::createLoginCookie();
//        } catch (\Exception $e) {
//            Log::warning($e->getMessage());
//            abort(503, '发生未知错误');
//        }
//
//        return redirect('/');
//    }
}
