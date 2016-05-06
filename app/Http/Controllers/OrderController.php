<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Model\Order;
use App\Container\Container;
use Cart;
use App\Http\Requests;
use Illuminate\Http\Request;
use Log;
use Config;

class OrderController extends Controller
{
    public function index()
    {
        $user = Container::getUser();

        $orders = Order::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();
        $orderItem = [];
        foreach ($orders as $order) {
            $orderItem[$order->id] = Order::getOrderItems($order->id);
        }

        return view('order.index', [
            'orders' => $orders,
            'orderItem' => $orderItem,
        ]);
    }

    public function show(Request $request, $orderId)
    {
        $order = Order::find($orderId);
        $orderItem = Order::getOrderItems($orderId);

        return view('order.show', [
            'order' => $order,
            'orderItem' => $orderItem,
            'encodeOrderNo' => base64_encode($order->order_no),
        ]);
    }

    public function create()
    {
        $cartName = session('cartName');
        if (is_null($cartName)) {
            $cartName = 'shopping';
        } else {
            session()->flash('cartName', 'once');
        }
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
        $cartName = session('cartName');

        $cartName = is_null($cartName) ? 'shopping' : $cartName;

        $trade_no = time() . str_random(22);
        $remark = $request->get('remark');
        $message = Container::getUser()->address;

        //把购物车里的所有商品，生成订单
        $cart = Cart::instance($cartName)->content();

        foreach ($cart as $item) {
            for ($i = 0; $i < $item->qty; $i++) {
                $orderId = Order::createOrder($trade_no, Container::getUser()->id, $message, $remark);
                Order::insertOrderItem(
                    $orderId,
                    $item->id,
                    $item->name,
                    $item->options['cover'],
                    1,
                    $item->price,
                    $item->options['size_id'],
                    $item->options['size_name'],
                    $item->options['color_id'],
                    $item->options['color_name']
                );
            }
        }

        $trade_no = base64_encode($trade_no);
        return redirect("wechat/pay/{$trade_no}");

    }

    /**
     * 支付回调
     */
    public function notify()
    {
        $app = app('wechat');
        $response = $app->payment->handleNotify(function ($notify, $successful) {
            if ($successful === true) {
                $out_trade_no = $notify->out_trade_no;
//                Log::info("pay order: {$out_trade_no}");
                Order::payOrder($out_trade_no);
                return true;
            }
            return false;
        });

        return $response;
    }

    public function cancel(Request $request, $orderNo)
    {
        $orderNo = base64_decode($orderNo);
        var_dump($orderNo);

        $order = Order::get($orderNo);
        if(isset($order) && $order->status_id == Config::get('constants.orderStatus.paid')) {
            //退款
            $app = app('wechat');
            $payment = $app->payment;
            $result = $payment->refund($order->wechat_order_no, time(), Order::getTotal($order->wechat_order_no), $order->total);
            if($result->return_code == 'SUCCESS') {
                $order->status_id = Config::get('constants.order.cancel');
                $order->save();

                return redirect("order/{$order->id}")->with('message', '您已成功退款，详情请在查看微信。');
            } else {
                return redirect("order/{$order->id}")->with('warning', '退款失败，请稍后重试。');
            }
        } else {
            abort('404', '发生未知错误。错误代码: 2001');
        }
    }
}
