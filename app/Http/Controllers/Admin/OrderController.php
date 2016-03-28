<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Model\Order;
use Illuminate\Http\Request;
use App\Http\Requests;
use Config;

class OrderController extends AdminController
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

    public function deliverOrder(Request $request, $id)
    {
        $order = Order::find($id);

        if(
            isset($order)
            && $order->status == Config::get('constants.orderStatus.confirm')
        ) {
            $order->status = Config::get('constants.orderStatus.deliver');
            $order->last_action_at = date('Y-m-d H:i:s');
            $order->save();

            return redirect("{$this->ADMIN}/order");
        } else {
            return redirect("{$this->ADMIN}/order");
        }
    }
}
