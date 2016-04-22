<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Payment\Order;
use EasyWeChat;

class PayController extends Controller
{
    /**
     * 支付页面
     */
    public function pay(Request $request, $wechatOrderNo)
    {
        //get Order Message by $wechatOrderNo

        $attributes = [
            'body'             => 'iPad mini 16G 白色',
            'detail'           => 'iPad mini 16G 白色',
            'out_trade_no'     => time(),
            'total_fee'        => 5388,
            'notify_url'       => 'http://m.artvc.cc/order-notify', // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            // ...
        ];

        $data = [];

        $payment = EasyWeChat::payment();
        $order = new Order($attributes);
        $data['order'] = $order;
        $data['payment'] = $payment;
        $result = $payment->prepare($order);
        $prepayId = $result->prepay_id;
        $config = $payment->configForPayment($prepayId);

        return view('wechat.pay', [
            'config' => $config,
            'data' => $data,
        ]);
    }
}
