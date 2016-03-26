<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\UserQrCode;
use App\Model\UserRelation;

use App\Http\Requests;

class QrCodeController extends Controller
{
    public static function show($token)
    {
        $user = User::getUser();

        //用户是我们官方指定的推广人员，就不能扫描其他人的二维码并且他不能购买我们的商品
        if($user['get_qrcode'] == false || UserRelation::hasParent($user['id'])) {
            return redirect('/');
        } else {
            if (UserQrCode::checkToken($token)) {
                UserRelation::belongTo($user['id'], $token);
                User::canBuy($user['id']);
                return redirect('/');
            } else {
                abort(503, '无效的二维码');
            }
        }
    }
}
