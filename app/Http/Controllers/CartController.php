<?php

namespace App\Http\Controllers;

use App\Model\Production;
use App\Model\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use App\Http\Requests;

class CartController extends Controller
{
    public function add(Request $request)
    {
        if (User::getUser()['can_buy'] == true) {
            Cart::destroy();

            $p = $request->get('p');
            $c = $request->get('c');
            $qty = $request->get('q');
            $s = $request->get('s');

            $qty = is_numeric($qty) ? $qty : 1;

            $production = Production::get($p, $c, $s, $qty);

            //@TODO validate

            Cart::add([
                'id' => $production->id,
                'name' => $production->name,
                'qty' => $qty,
                'price' => $production->price,
                'options' => [
                    'production_alias' => $production->alias,

                    'color_id' => $production->color_id,
                    'color_name' => $production->color_name,

                    'size_id' => $production->size_id,
                    'size_name' => $production->size_name,

                    'cover' => $production->cover,
                ],
            ]);

            return redirect('order/create');
        } else {
            abort(503, '此帐号为推广帐号，不能进行购买');
        }
    }
}
