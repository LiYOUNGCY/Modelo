<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\UserAddress;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use App\Http\Requests;

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
}
