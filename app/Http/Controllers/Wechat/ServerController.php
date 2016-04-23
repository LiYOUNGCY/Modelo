<?php

namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;
use App\Model\UserQrCode;
use App\Model\UserRelation;
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
//                        $token = $message->EventKey;
//                        if(!empty($token) && substr($token, 0, 7) == 'qrscene_') {
//                            $token = substr($token, 7);
//                            $parent = UserQrCode::getByToken($token);
//
//                            $userRelation = new UserRelation();
//                            $userRelation->insert(0, $parent->id);
//                        }
                        return "你好！{$message->EventKey}, {$message->FromUserName}";
                        break;
                }
            }
        });

        return $server->serve();
    }
}