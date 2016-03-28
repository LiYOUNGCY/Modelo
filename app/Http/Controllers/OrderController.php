<?php

namespace App\Http\Controllers;

use App\Jobs\PaidOrder;
use App\Model\Order;
use App\Model\Production;
use App\Model\User;
use App\Model\UserAddress;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Http\Requests;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        $cart = Cart::content();
        if (Cart::count() > 0) {
            $userAddress = UserAddress::where('user_id', User::getUser()['id'])->first();

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
            $userAddress = UserAddress::where('user_id', User::getUser()['id'])->first();

            if (empty($userAddress)) {
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

            Order::createOrder(User::getUser()['id'], $userAddress, $remark);
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
        $order_no = '1459134039VmFuAOhxf71lVP0u4yXSXW';
        if(Order::checkOrder_no($order_no)) {
            Order::payOrder($order_no);
        }
    }
}
