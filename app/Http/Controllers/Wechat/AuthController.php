<?php

namespace App\Http\Controllers\Wechat;

use App\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $wechatAuth = EasyWeChat::oauth();

        return $wechatAuth->scopes(['snsapi_userinfo'])
            ->redirect();
    }

    public function callback(Request $request)
    {
        $wechatAuth = EasyWeChat::oauth();

        $userMessage = $wechatAuth->user()->toArray();

        echo "<pre>";print_r($userMessage);echo "<pre>";

//        $user = User::where('openid', $userMessage['openid'])->first();
//        if(is_null($user)) {
//            $user = new User();
//        }
//        $user->nickname = $userMessage['nickname'];
//        $user->sex = $userMessage['sex'];
//        $user->province = $userMessage['province'];
//        $user->city = $userMessage['city'];
//        $user->country = $userMessage['country'];
//        $user->headimgurl = $userMessage['headimgurl'];
//        $user->save();
    }
}
