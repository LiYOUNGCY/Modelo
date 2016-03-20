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
    ],

    'order' => [
        //在多少分钟内没有支付就取消订单
        'cancelTime' => 1
    ],
];