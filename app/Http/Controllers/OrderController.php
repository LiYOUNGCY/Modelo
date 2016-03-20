<?php

namespace App\Http\Controllers;

use App\Model\Order;
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
        $userAddress = UserAddress::where('user_id', User::getUser()['id'])->first();

        return view('order.create', [
            'cart' => $cart,
            'total' => Cart::total(),
            'userAddress' => $userAddress,
        ]);
    }

    public function store(Request $request)
    {
        $remark = $request->get('remark');
        $userAddress = UserAddress::where('user_id', User::getUser()['id'])->first();

        if(empty($userAddress)) {
            return redirect('address/create');
        }

        Order::createOrder(User::getUser()['id'], $userAddress, $remark);
    }
}
