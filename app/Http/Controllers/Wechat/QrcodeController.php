<?php

namespace App\Http\Controllers\Wechat;
use App\Http\Controllers\Controller;

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
        echo "<img src={$url}>";
    }
}