<?php

namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;
use Log;
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
        $server = app('wechat')->server;

        $server->setMessageHandler(function($message) {
            Log::info('Message'.json_encode($message));
            if($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                        return "你好！{$message->EventKey}";
                        break;
                }
            }
        });

        return $server->serve();
    }
}