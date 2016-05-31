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
                'name' => '选购',
                'type' => 'view',
                'url' => url('/'),
            ],
            [
                'name' => '优惠活动',
                'type' => 'view',
                'url' => 'http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000070&idx=1&sn=2949a971cdd2244dc489dd88a3745737#rd',
            ],
            [
                'name' => '我的助手',
                'sub_button' => [
                    [
                        'name' => '联系客服',
                        'type' => 'view',
                        'url' => 'http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000106&idx=1&sn=458f1e08652bf9e2953b1b45509d2cda#rd',
                    ],
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
