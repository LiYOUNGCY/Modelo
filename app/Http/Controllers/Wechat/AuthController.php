<?php

namespace App\Http\Controllers\Wechat;

use App\Container\Container;
use App\Exceptions\NotFoundException;
use App\Http\Common;
use App\Model\User;
use App\Model\UserRelation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat;
use Log;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        $oauth = app('wechat')->oauth;

        return $oauth->scopes(['snsapi_base'])->redirect();
    }

    public function callback(Request $request)
    {
        $oauth = app('wechat')->oauth;
        $userService = app('wechat')->user;

        $user = $oauth->user()->toArray();

        $openid = $user['original']['openid'];
        $userMessage = $userService->get($openid);

        //关注了才能获取信息
        if($userMessage['subscribe'] === 1) {
            $user = User::findOrNewByOpenid($userMessage['openid'], [
                'nickname' => $userMessage['nickname'],
                'sex' => $userMessage['sex'],
                'province' => $userMessage['province'],
                'city' => $userMessage['city'],
                'country' => $userMessage['country'],
                'headimgurl' => $userMessage['headimgurl'],
            ]);

            if (!UserRelation::hasParent($user->id)) {
                $userRelation = new UserRelation();
                $userRelation->insert($user->id, 1);
                $user->follow(1);
            }

            //create Cookie and Session
            Container::setUser($user->id);
            session()->put('user', $user->id);
            Common::createLoginCookie();

            $url = session()->get('_url');
            if(isset($url)) {
                return redirect($url);
            } else {
                return redirect('/');
            }
        } else {
            return redirect('deny');
        }
    }
}
