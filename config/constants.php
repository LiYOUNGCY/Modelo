<?php

return [
    'route' => [
        'admin' => 'admin',
    ],

    //订单状态
    'orderStatus' => [
        'cancel' => 1,
        'unpaid' => 2,
        'paid' => 3,
        'confirm' => 4,
        'deliver' => 5,
        'received' => 6,
        'finish' => 7,
    ],

    'order' => [
        //在多少分钟内没有支付就取消订单
        'cancelTime' => 5,
        'confirmTime' => 5,
        'receivedTime' => 3,
        'finishTime' => 3,
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
        'one' => 0.10,
        'two' => 0.05,
        'three' => 0.02,
    ],
];