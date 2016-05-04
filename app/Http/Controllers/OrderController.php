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
        ]);
    }

    public function create()
    {
        $cartName = session()->get('cartName');
        if(is_null($cartName)) {
            $cartName = 'shopping';
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
        $cartName = session()->get('cartName');

        if(isset($cartName)) {
            $trade_no = time().str_random(22);
            $remark = $request->get('remark');
            $messge = Container::getUser()->address;

            //把购物车里的所有商品，生成订单
            $cart = Cart::instance($cartName)->content();

            foreach ($cart as $item) {
                for ($i = 0; $i < $item->qty; $i++) {
                    $orderId = Order::createOrder($trade_no, Container::getUser()->id, $messge, $remark);
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
                return true;
            }
            return false;
        });

        return $response;
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
