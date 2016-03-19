<?php

namespace App\Http\Controllers;

use App\Model\Production;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

use App\Http\Requests;

class CartController extends Controller
{
    public function add(Request $request)
    {
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
                'color_id' => $production->color_id,
                'color_name' => $production->color_name,
                'size_id' => $production->size_id,
                'size_name' => $production->size_name,
                'production_alias' => $production->alias,
                'color_alias' => $production->alias,
                'size_alias' => $production->alias,
                'cover' => $production->cover,
            ],
        ]);

//        return response()->json([
//            'cart' => Cart::content(),
//        ]);

        return redirect('order/create');
    }
}
