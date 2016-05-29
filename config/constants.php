<?php

return [
    'route' => [
        'admin' => 'admin',
    ],

    'category' => [
        'up' => 1,
        'down' => 2,
        'upAndDown' => 3,
    ],

    'categoryName' => [
        0 => '全部商品',
        1 => '上身',
        2 => '下身',
        3 => '连体',
    ],

    'rememberCookie' => 'modelo_rv',
    'cookieTime' => 60*24*30*3,

    //订单状态
    'orderStatus' => [
        'cancel' => 1,      //取消订单
        'unpaid' => 2,      //未支付
        'paid' => 3,        //已支付
        'confirm' => 4,     //确认订单
        'deliver' => 5,     //已发货
        'received' => 6,    //已收货
        'finish' => 7,      //已完成
        'reject' => 8,      //售后处理中
        'rejected' => 9,    //确认退货
        'exchange' => 10,   //准备重新发货
    ],

    'order' => [
        //在多少分钟内没有支付就取消订单
        'cancelTime' => 5, //60
        'confirmTime' => 15, //15
        'receivedTime' => 7*24*60,
        'finishTime' => 3*24*60,
    ],

    /**************************************************************
     * 分销系统的常量
     **************************************************************/
    'profitStatus' => [
        'cancel' => 1,
        'available' => 2,
        'freeze' => 3,
    ],

    'levelName' => [
        'one' => 1,
        'two' => 2,
        'three' => 3,
    ],

    /**
     * 分销利润
     */
    'profit' => [
        'one' => 0.20,
        'two' => 0.05,
        'three' => 0.03,
    ],

    /**
     * 可以提现 三级 的条件
     */
    'salesVolume' => 1,   // 15000


    'CashStatus' => [
        'pending' => 1,     //等待审核
        'accept'  => 2,     //成功审核
        'reject'  => 3,     //拒绝
    ],
];