<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function index()
    {
        $menu = app('wechat')->menu;

        $buttons = [
            [
                'type' => 'view',
                'name' => '选购',
                'url' => url('/'),
            ],
            [
                'type' => 'view',
                'name' => '我是魔豆',
                'url' => url('user')
            ],
            [
                'name' => '我的助手',
                'sub_button' => [
                    [
                        'type' => 'view',
                        'name' => '我的二维码',
                        'url' => url('qrcode'),
                    ],
                    [
                        'type' => 'view',
                        'name' => '我的订单',
                        'url' => url('order'),
                    ],
                ],
            ],
        ];
        $menu->add($buttons);
    }
}
