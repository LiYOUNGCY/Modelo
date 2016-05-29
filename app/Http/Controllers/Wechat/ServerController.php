<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Controllers\Controller;
use App\Jobs\SendWechatFollow;
use App\Jobs\SendWechatMessage;
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
            if ($message->MsgType == 'event') {
                switch ($message->Event) {
                    case 'subscribe':
                        return $this->handlerEvent($message);
                        break;
                    default:
                        break;
                }
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
            } else {
                //如果没有推荐人就当官方推荐
                $parentId = 1;
            }

            $userRelation = new UserRelation();
            $userRelation->insert($user->id, $parentId);

            //推荐后对 User 的操作
            $user->follow($parentId);
        }

        $this->dispatch((new SendWechatMessage($fromUserOpenId)));
        $url= url('/');

        return "谢谢那么好看的你来加入魔豆世界，这里是有颜走心的购物分享平台。了解我们请点击<a href='http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000082&idx=1&sn=771c9e17262385afe7048b54e274dc74#rd'>这里</a>，喜欢我们的原创设计点击<a href='{$url}'>这里</a>购买。";
	}
}
