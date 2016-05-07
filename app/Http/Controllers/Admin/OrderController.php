<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\AdminController;
use App\Model\Order;
use App\Model\Profit;
use Illuminate\Http\Request;
use App\Http\Requests;
use Config;
use Illuminate\Support\Facades\DB;
use Log;

class OrderController extends AdminController
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $status = isset($status) && is_numeric($status) ? $status : null;

        $orders = Order::getAll($status);

        return view('admin.order.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Request $request, $id)
    {
        $order = Order::getOrder($id);
        $profits = Profit::getByOrderId($id);

        if (isset($order)) {
            $orderItem = Order::getOrderItems($order->id);

            return view('admin.order.show', [
                'order' => $order,
                'item' => $orderItem,
                'profits' => $profits,
            ]);
        } else {
            abort(404);
        }
    }

    public function deliverOrder(Request $request, $id)
    {
        $order = Order::find($id);

        if (
            isset($order)
            && ($order->status_id == Config::get('constants.orderStatus.confirm')
                || $order->status_id == Config::get('constants.orderStatus.exchange'))
        ) {
            $express = $request->get('express');
            $tracking_no = $request->get('tracking_no');

            $order->status_id = Config::get('constants.orderStatus.deliver');
            $order->last_action_at = date('Y-m-d H:i:s');
            $order->express = $express;
            $order->tracking_no = $tracking_no;
            $order->save();

            return redirect("{$this->ADMIN}/order");
        } else {
            return redirect("{$this->ADMIN}/order");
        }
    }

    public function rejected(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (isset($order) && $order->status_id == Config::get('constants.orderStatus.reject')) {
            //退款
            $app = app('wechat');
            $payment = $app->payment;
            $result = $payment->refund(
                $order->wechat_order_no,
                time() . 'reject',
                Order::getTotal($order->wechat_order_no) * 100,
                $order->total * 100
            );
            if ($result->return_code == 'SUCCESS') {
                $order->status_id = Config::get('constants.orderStatus.rejected');
                $order->save();
                return redirect("{$this->ADMIN}/order/{$order->id}")->with('success', '操作成功');
            }
        }

        return redirect("{$this->ADMIN}/order/{$order->id}")->with('warning', '操作失败');
    }
}
