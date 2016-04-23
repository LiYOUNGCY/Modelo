<?php

namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;
use App\Model\Image;

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

        $result = $qrcode->temporary('test', 7*24*3600);
        $ticket = $result->ticket;
        $url = $result->url;
        $url = $qrcode->url($ticket);
        $content = file_get_contents($url);

        $image = new Image();
        $image->storeImage('QrCode', $content, 'jpg', false);
        echo "<img src={$url}>";
    }
}