<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Wechat\Notice;
use App\Model\Order;
use App\Container\Container;
use App\Model\Production;
use Cart;
use App\Http\Requests;
use Illuminate\Http\Request;
use Log;
use Config;

class OrderController extends Controller
{
    use Notice;

    public function index()
    {
        $user = Container::getUser();

        $orders = Order::where('user_id', $user->id)
            ->whereNotIn('order.status_id', [
                Config::get('constants.orderStatus.cancel'),
                Config::get('constants.orderStatus.unpaid'),
            ])
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
        $link = Production::find($orderItem->production_id)->alias;

        return view('order.show', [
            'order' => $order,
            'orderItem' => $orderItem,
            'encodeOrderNo' => base64_encode($order->order_no),
            'link' => $link,
        ]);
    }

    public function create()
    {
        $cartName = session('cartName');
        if (is_null($cartName)) {
            abort(404);
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

        $trade_no = time() . str_random(10);
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
                $this->paySuccessNotice($out_trade_no);
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

        $order = Order::get($orderNo);
        if (isset($order) && $order->status_id == Config::get('constants.orderStatus.paid')) {
            //退款
            $app = app('wechat');
            $payment = $app->payment;
            $result = $payment->refund(
                $order->wechat_order_no,
                time(),
                Order::getTotal($order->wechat_order_no) * 100,
                $order->total * 100
            );
            if ($result->return_code == 'SUCCESS') {
                $order->status_id = Config::get('constants.orderStatus.cancel');
                $order->save();

                $this->cancelNotice($order->user_id, $order->id);

                return redirect("order/{$order->id}")->with('message', '您已成功退款，详情请在查看微信。');
            } else {
                return redirect("order/{$order->id}")->with('warning', '退款失败，请稍后重试。');
            }
        } else {
            abort(503, '发生未知错误。错误代码: 2001');
        }
    }


    /**
     * 确认收货
     * @param Request $request
     * @param $orderNo
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws NotFoundException
     */
    public function receive(Request $request, $orderNo)
    {
        $orderNo = base64_decode($orderNo);

        $order = Order::get($orderNo);
        if(isset($order) && $order->status_id == Config::get('constants.orderStatus.deliver')) {
            $order->status_id = Config::get('constants.orderStatus.received');
            $order->save();

            return redirect("order/{$order->id}");
        } else {
            abort(503, '发生未知错误。错误代码: 2002');
        }
    }

    /**
     * 申请售后
     * @param Request $request
     * @param $orderNo
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws NotFoundException
     */
    public function reject(Request $request, $orderNo)
    {
        $orderNo = base64_decode($orderNo);
        $result = $request->get('result');

        $order = Order::get($orderNo);
        if(isset($order)
            && (
                $order->status_id == Config::get('constants.orderStatus.received')
                || $order->status_id == Config::get('constants.orderStatus.deliver')
            )
        ) {
            $order->status_id = Config::get('constants.orderStatus.reject');
            $order->result = $result;
            $order->save();

            return redirect("order/{$order->id}");
        } else {
            abort(503, '发生未知错误。错误代码: 2003');
        }
    }
}
