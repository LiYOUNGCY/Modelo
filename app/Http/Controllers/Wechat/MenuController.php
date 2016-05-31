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
                'name' => '优惠活动',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000070&idx=1&sn=2949a971cdd2244dc489dd88a3745737#rd',
            ],
            [
                'name' => '我的助手',
                'sub_button' => [
                    [
                        'name' => '代言人指南',
                        'type' => 'view',
                        'url' => 'http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=2247483750&idx=2&sn=2bf581e589d702ffa23b44d28ae78377#rd',
                    ],
                    [
                        'type' => 'view',
                        'name' => '参与投票',
                        'url' => url('vote'),
                    ],
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
                    [
                        'type' => 'view',
                        'name' => '我是魔豆',
                        'url' => url('user'),
                    ],
                ],
            ],
        ];
        $menu->add($buttons);

        echo 'Update Success';
    }
}
