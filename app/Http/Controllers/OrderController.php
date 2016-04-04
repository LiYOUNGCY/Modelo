<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Model\Order;
use App\Model\Production;
use App\Container\Container;
use App\Model\UserAddress;
use Cart;
use App\Http\Requests;
use Illuminate\Http\Request;
use Log;

class OrderController extends Controller
{
    public function create()
    {
        $cart = Cart::content();
        if (Cart::count() > 0) {
            $userAddress = Container::getUser()->address;

            if (empty($userAddress)) {
                return redirect('address/create');
            }

            return view('order.create', [
                'cart' => $cart,
                'total' => Cart::total(),
                'userAddress' => $userAddress,
            ]);
        } else {
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        if (Cart::count() > 0) {
            $remark = $request->get('remark');
            $userAddress = Container::getUser()->address;

            if (is_null($userAddress)) {
                return redirect('address/create');
            }

            //判断商品的数量是否满足下单条件
            $cart = Cart::content();
            foreach ($cart as $item) {
                if (!Production::checkQuantity($item->options['size_id'], $item->qty)) {
                    $url = $request->session()->get('prevUrl');
                    return redirect($url);
                }
            }

            Order::createOrder(Container::getUser()->id, $userAddress, $remark);
        } else {
            return redirect('/');
        }
    }

    /**
     * 支付页面
     */
    public function pay()
    {

    }

    /**
     * 支付回调
     */
    public function notify()
    {
        $order_no = '1459154207GMK6v9StzWItA9xFtSIMLq';
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
