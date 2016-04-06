<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\AdminController;
use App\Model\Order;
use App\Model\Profit;
use App\Model\ProfitStatus;
use Illuminate\Http\Request;
use App\Http\Requests;
use Config;
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

        if (!empty($order)) {
            $orderItems = Order::getOrderItems($order->id);

            return view('admin.order.show', [
                'order' => $order,
                'orderItems' => $orderItems,
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
            && $order->status_id == Config::get('constants.orderStatus.confirm')
        ) {
            $order->status_id = Config::get('constants.orderStatus.deliver');
            $order->last_action_at = date('Y-m-d H:i:s');
            $order->save();

            return redirect("{$this->ADMIN}/order");
        } else {
            return redirect("{$this->ADMIN}/order");
        }
    }

    public function rejected(Request $request, $orderNo)
    {
        $isRejected = $request->get('isRejected');
        try {
            $order = Order::get($orderNo);

            switch ($isRejected) {
                //拒绝退货
                case 0:
                    $order->denyRejected();
                    break;
                //允许退货
                case 1:
                    $order->rejected();

                    $profits = Profit::getByOrderId($order->id);
                    foreach ($profits as $profit) {
                        $profit->cancel();
                    }
                    break;
                //换货
                case 2:
                    $order->exchange();
                    break;
            }

        } catch (NotFoundException $e) {
            Log::warning($e->getMessage());
            return redirect("{$this->ADMIN}/order");
        }

        return redirect("{$this->ADMIN}/order/{$order->id}");
    }
}
