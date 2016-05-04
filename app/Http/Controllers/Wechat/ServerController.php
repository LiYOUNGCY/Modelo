<?php

namespace App\Http\Controllers\Wechat;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Model\User;
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

        $server->setMessageHandler(function ($message) {
            if ($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                        $fromUserOpenId = $message->FromUserName;
                        $user = User::where('openid', $fromUserOpenId)->first();
                        if (is_null($user)) {
                            $user = User::create([
                                'openid' => $fromUserOpenId,
                            ]);
                        }

                        //如果没有推荐人
                        if (!UserRelation::hasParent($user->id)) {
                            $token = $message->EventKey;
                            //如果没有推荐人就当官方推荐
                            if (!empty($token) && substr($token, 0, 8) == 'qrscene_') {
                                $token = substr($token, 8);
                                $parentId = UserQrCode::getByToken($token)->user_id;
                                Log::info("User ID:{$parentId}, TOKEN: {$token}");
                            } else {
                                $parentId = 1;
                            }

                            $userRelation = new UserRelation();
                            $userRelation->insert($user->id, $parentId);
                        }


                        return "你好！{$message->EventKey}, {$message->FromUserName}";
                        break;
                }
            }
        });

        return $server->serve();
    }
}