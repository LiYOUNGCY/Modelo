<?php

namespace App\Http\Controllers;

use App\Model\Production;
use App\Model\ProductionColor;
use App\Model\ProductionSize;
use Cart;
use Illuminate\Http\Request;
use App\Container\Container;

use App\Http\Requests;

class CartController extends Controller
{
    public function useCart(Request $request, $cartName)
    {
        if ($cartName == 'shopping') {
            session()->put('cartName', 'shopping');
            return redirect('order/create');
        } else if ($cartName == 'once') {
            session()->put('cartName', 'once');
            return redirect('order/create');
        } else {
            abort(404);
        }
    }

    public function createToOnceCart(Request $request)
    {
        Cart::instance('once')->destroy();

        $production_id = $request->get('production_id');
        $size_id = $request->get('size_id');
        $color_id = $request->get('color_id');
        $quantity = $request->get('quantity');

        $quantity = floor($quantity);

        if ($this->addToCart('once', $production_id, $color_id, $size_id, $quantity)) {
            return redirect('cart/once/use');
        } else {
            echo 'ERROR';
        }
    }


    public function createToShoppingCart(Request $request)
    {
        $production_id = $request->get('pid');
        $size_id = $request->get('sid');
        $color_id = $request->get('cid');
        $quantity = intval($request->get('qty'));

        $quantity = floor($quantity);


        if ($this->addToCart('shopping', $production_id, $color_id, $size_id, $quantity)) {
            return response()->json([
                'success' => 0,
            ]);
        } else {
            return response()->json([
                'error' => 0,
            ]);
        }
    }

    private function addToCart($cartName, $production_id, $color_id, $size_id, $quantity)
    {
        $production = Production::find($production_id);
        $color = ProductionColor::find($color_id);
        $size = ProductionSize::find($size_id);

        if (isset($production)
            && isset($color)
            && isset($size)
            && $size->quantity >= $quantity
        ) {

            Cart::instance($cartName)->add([
                'id' => $production->id,
                'name' => $production->name,
                'qty' => $quantity,
                'price' => $color->price,
                'options' => [
                    'production_alias' => $production->alias,
                    'color_id' => $color->id,
                    'color_name' => $color->name,
                    'size_id' => $size->id,
                    'size_name' => $size->name,
                    'cover' => $production->cover->path,
                ],
            ]);

            return true;
        } else {
            return false;
        }
    }

    public function show(Request $request, $cartName)
    {
        try {
            $content = Cart::instance($cartName)->content();

            return response()->json([
                'success' => 0,
                'data' => $content,
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return response()->json([
            'error' => 0,
        ]);
    }

    public function remove(Request $request, $rowId)
    {
        Cart::instance('shopping')->remove($rowId);
        return response()->json([
            'success' => 0,
        ]);
    }

    public function cartBuy(Request $request)
    {
        $rowIds = $request->get('flag');

        Cart::instance('once')->destroy();
        foreach ($rowIds as $rowId) {
            $data = Cart::instance('shopping')->get($rowId);
            $qty = $request->get($rowId);

            if (isset($data)) {
                Cart::instance('once')->add(
                    $data->id,
                    $data->name,
                    $qty,
                    $data->price,
                    [
                        'production_alias' => $data->options->production_alias,
                        'color_id' => $data->options->color_id,
                        'color_name' => $data->options->color_name,
                        'size_id' => $data->options->size_id,
                        'size_name' => $data->options->size_name,
                        'cover' => $data->options->cover,
                    ]
                );
            }
        }

        var_dump(Cart::instance('once')->content());
        return redirect('cart/once/use');
    }
}
