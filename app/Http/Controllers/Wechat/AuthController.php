<?php

namespace App\Http\Controllers\Wechat;

use App\Container\Container;
use App\Exceptions\NotFoundException;
use App\Http\Common;
use App\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat;
use Log;

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
        try {
            $wechatAuth = EasyWeChat::oauth();

            $userMessage = $wechatAuth->user()->toArray();

            if(empty($userMessage)) {
                throw new NotFoundException("没有成功获取用户信息");
            }

            $userMessage = $userMessage['original'];

            $user = User::where('openid', $userMessage['openid'])->first();
            if(is_null($user)) {
                $user = new User();
            }
            $user->openid = $userMessage['openid'];
            $user->nickname = $userMessage['nickname'];
            $user->sex = $userMessage['sex'];
            $user->province = $userMessage['province'];
            $user->city = $userMessage['city'];
            $user->country = $userMessage['country'];
            $user->headimgurl = $userMessage['headimgurl'];
            $user->save();

            //create Cookie and Session

            Container::setUser($user->id);
            session()->put('user', $user->id);
            Common::createLoginCookie();
        }catch (\Exception $e) {
            Log::warning($e->getMessage());
            abort(503, '发生未知错误');
        }

        return redirect('/');
    }
}
