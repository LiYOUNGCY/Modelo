<?php

namespace App\Http\Controllers\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use EasyWeChat\Payment\Order;

class PayController extends Controller
{
    /**
     * 支付页面
     */
    public function pay(Request $request, $wechatOrderNo)
    {
        //get Order Message by $wechatOrderNo

        $attributes = [
            'body' => 'iPad mini 16G 白色',
            'out_trade_no' => time(),
            'total_fee' => 1,
            'notify_url' => 'http://m.artvc.cc/wechat/pay/notify',
            'trade_type' => 'JSAPI',
            'openid' => 'o4-YOwBjMKaYE8MiUT_vHHZP2oHg',
        ];

        $app = app('wechat');
        $payment = $app->payment;
        $order = new Order($attributes);
        $result = $payment->prepare($order);
        $prepayId = $result->prepay_id;
        $config = $payment->configForPayment($prepayId);

        return view('wechat.pay', [
            'config' => $config,
        ]);
    }
}
