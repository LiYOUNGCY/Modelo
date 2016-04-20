<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat;

class AuthController extends Controller
{
    public function index()
    {
        $wechatAuth = EasyWeChat::oauth();
//        var_dump($wechatAuth);
        return $wechatAuth->scopes(['snsapi_userinfo'])
            ->redirect();
    }
}
