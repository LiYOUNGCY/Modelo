<?php

namespace App\Http\Controllers\Wechat;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\UserQrCode;
use App\Model\UserRelation;

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

        $server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'event':
                    return $this->handlerEvent($message);
                    break;
                default:
                    break;
            }
        });

        return $server->serve();
    }

    private function handlerEvent(& $message)
    {
        $fromUserOpenId = $message->FromUserName;
        $user = User::findOrNewByOpenid($fromUserOpenId);

        //没有推荐人
        if(! UserRelation::hasParent($user->id)) {
            $token = $message->EventKey;

            if (!empty($token) && substr($token, 0, 8) == 'qrscene_') {
                $token = substr($token, 8);
                $parentId = UserQrCode::getByToken($token)->user_id;
                Log::info("User ID:{$parentId}, TOKEN: {$token}");
            } else {
                //如果没有推荐人就当官方推荐
                $parentId = 1;
            }

            $userRelation = new UserRelation();
            $userRelation->insert($user->id, $parentId);

            //推荐后对 User 的操作
            $user->follow($parentId);
        }

        return "您好，欢迎关注魔豆树，您的推荐人是{$user->referee}";
    }
//
//    public function test()
//    {
//        $fromUserOpenId = $message->FromUserName;
//        $user = User::where('openid', $fromUserOpenId)->first();
//        if (is_null($user)) {
//            $user = User::create([
//                'openid' => $fromUserOpenId,
//            ]);
//        }
//
//        //如果没有推荐人
//        if (!UserRelation::hasParent($user->id)) {
//            $token = $message->EventKey;
//            //如果没有推荐人就当官方推荐
//            if (!empty($token) && substr($token, 0, 8) == 'qrscene_') {
//                $token = substr($token, 8);
//                $parentId = UserQrCode::getByToken($token)->user_id;
//                Log::info("User ID:{$parentId}, TOKEN: {$token}");
//            } else {
//                $parentId = 1;
//            }
//
//            $userRelation = new UserRelation();
//            $userRelation->insert($user->id, $parentId);
//        }
//
//
//        return "你好！{$message->EventKey}, {$message->FromUserName}";
//    }
}