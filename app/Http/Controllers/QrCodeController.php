<?php

namespace App\Http\Controllers;

use App\Model\UserRelation;
use App\Container\Container;
use App\Http\Requests;

class QrCodeController extends Controller
{
    //@TODO refactor
    public function show($token)
    {
        $user = Container::getUser();

        //用户是我们官方指定的推广人员，就不能扫描其他人的二维码并且他不能购买我们的商品
        if ($user->get_qrcode == false || UserRelation::hasParent($user->id)) {
            return redirect('/');
        } else {
//            $qrcodeMessage = UserQrCode::checkToken($token);
//            if (!is_null($qrcodeMessage)) {
//                UserRelation::belongTo($user['id'], $token);
//                User::canBuy($user['id'], $qrcodeMessage->referee);
//                return redirect('/');
//            } else {
//                abort(503, '无效的二维码');
//            }
        }
    }

//    public function scan($token)
//    {
//        $self = User::getUser();
//
//        if($self['get_qrcode'] == false
//        || )
//    }
}
