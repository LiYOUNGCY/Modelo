<?php

namespace App\Http\Controllers\Wechat;

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

        $user = $wechatAuth->user();

        var_dump($user);
    }
}
