<?php

namespace App\Http\Controllers\Admin;

use App\Model\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::getAll();

        return view('admin.order.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = Order::getOrder($id);

        if(! empty($order)) {
            $orderItems = Order::getOrderItems($order->id);

            return view('admin.order.show', [
                'order' => $order,
                'orderItems' => $orderItems,
            ]);
        } else {
            abort(404);
        }
    }
}
