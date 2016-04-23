<?php

namespace App\Http\Controllers\Wechat;
use App\Container\Container;
use App\Http\Controllers\Controller;
use App\Model\Image;
use App\Model\UserQrCode;

/**
 * Created by PhpStorm.
 * User: rache
 * Date: 2016/4/20
 * Time: 9:59
 */
class QrcodeController extends Controller
{
    public function create()
    {
        $app = app('wechat');
        $qrcode = $app->qrcode;

        $result = $qrcode->temporary(30, 7*24*3600);
        $ticket = $result->ticket;
        $url = $qrcode->url($ticket);
        $content = file_get_contents($url);

        $image = new Image();
        $image->storeImage('QrCode', $content, 'jpg', false);

        $user = Container::getUser();

        $userQrcode = new UserQrCode();
        $userQrcode->user_id = $user->id;
        $userQrcode->image_id = $image->id;
//        $userQrcode->token =
        $userQrcode->save();
        
        
    }
}