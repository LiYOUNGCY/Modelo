<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Model\Order;
use App\Model\Production;
use App\Container\Container;
use Cart;
use App\Http\Requests;
use Illuminate\Http\Request;
use Log;

class OrderController extends Controller
{
    public function create()
    {
        $cartName = session()->get('cartName');
        $productions = Cart::instance($cartName)->content();
        $total = Cart::instance($cartName)->total();
        $messages = Container::getUser()->address;

        return view('order.create', [
            'productions' => $productions,
            'messages' => $messages,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $cartName = session()->get('cartName');

        if(isset($cartName)) {
            $trade_no = time().str_random(22);
            $remark = $request->get('remark');
            $messge = Container::getUser()->address;

            Order::createOrder(Container::getUser()->id, $messge, $remark, $cartName, $trade_no);

            $trade_no = base64_encode($trade_no);
            return redirect("wechat/pay/{$trade_no}");
        } else {
            abort(404);
        }
    }

    /**
     * 支付回调
     */
    public function notify()
    {
        $app = app('wechat');
        $response = $app->payment->handleNotify(function($notify, $successful){
            if($successful === true) {
                $out_trade_no = $notify->out_trade_no;
		Log::info("pay order: {$out_trade_no}");
                Order::payOrder($out_trade_no);
                return true; // 或者错误消息
            }
            return false;
        });

        return $response;// 或者 $response->send()
        $order_no = '14610507934yos6qauDmHKFEldlTxYoF';
        if (Order::checkOrder_no($order_no)) {
            Order::payOrder($order_no);
        }
    }

    public function reject(Request $request, $orderNo)
    {
        try {
            $order = Order::get($orderNo);
            $order->reject();
        } catch (NotFoundException $e) {
            Log::info($e->getMessage(), ['orderNo' => $orderNo]);
            return response()->json([
                'error' => 0,
            ]);
        }

        return response()->json([
            'success' => 0,
        ]);
    }
}
