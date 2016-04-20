<?php

namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;
use EasyWeChat;
/**
 * Created by PhpStorm.
 * User: rache
 * Date: 2016/4/20
 * Time: 9:59
 */
class ServerController extends Controller
{
    public function index()
    {
        $wechatServer = EasyWeChat::server(); // 服务端
        $wechatServer->setMessageHandler(function($message){
            return "欢迎关注魔豆树！";
        });

        return $wechatServer->serve();
    }
}