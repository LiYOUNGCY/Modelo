<?php

namespace App\Http\Controllers\Wechat;


use App\Http\Controllers\Controller;
use App\Jobs\SendWechatFollow;
use App\Jobs\SendWechatMessage;
use App\Model\User;
use App\Model\UserQrCode;
use App\Model\UserRelation;
use EasyWeChat\Message\News;
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
                        return $this->handlerEvent($message);
                        break;
                    case 'CLICK':
                        return $this->handleClickEvent($message);
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
        if (!UserRelation::hasParent($user->id)) {
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
        $url = url('/');

//        $qrcode = url('qrcode');

        return "恭喜那么好看的你成为魔豆代言人，这里是有颜走心购物分享平台。\n你的推荐人是{$user->referee}。\n您只需要点击<a href='{$url}'>这里</a>选购累计两件服装，即可成为魔豆代言人。\n了解我们的模式请点<a href='http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000082&idx=1&sn=771c9e17262385afe7048b54e274dc74#rd'>这里</a>。\n";
    }

    private function handleClickEvent(& $message)
    {
        switch ($message->EventKey) {
            case '100':
                $news1 = new News([
                    'title' => '优惠活动',
                    'description' => '优惠活动',
                    'url' => 'http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000070&idx=1&sn=2949a971cdd2244dc489dd88a3745737#rd',
                    'image' => 'http://mmbiz.qpic.cn/mmbiz/CaiburVeswg4QRLzpP3ficxjBlKRGgRIIHw2qDMxxaTmtq0YzRM65g4CMSB7QJ1mmTG6pLGsCVeyZGjqbq9KHSicA/640?wx_fmt=jpeg&tp=webp&wxfrom=5&wx_lazy=1',
                ]);

                $news2 = new News([
                    'title' => '参与投票',
                    'description' => '参与投票',
                    'url' => url('vote'),
                    'image' => 'http://modelo.taiyishou.cn/assets/images/vote/1.jpg',
                ]);

                return [$news1, $news2];
                break;
            default:
                break;
        }
    }
}
