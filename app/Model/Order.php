<?php

namespace App\Model;

use App\Exceptions\NotFoundException;
use Cart;
use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'order';

    public static function getAll($statusId = null)
    {

        $data = DB::table('order')
            ->join('user', 'user.id', '=', 'order.user_id')
            ->join('order_status', 'order.status_id', '=', 'order_status.id')
            ->select(
                'user.nickname',
                'order.id',
                'order.order_no',
                'order.address',
                'order.contact',
                'order.phone',
                'order.last_action_at',
                'order.total',
                'order.created_at',
                'order.status_id as status',
                'order_status.name as status_name'
            )
            ->skip(0)
            ->take(1000);


        if (!is_null($statusId)) {
            $data = $data->where('order.status_id', $statusId);
        }

        return $data->get();
    }

    /**
     * @param $orderNo
     * @return Order
     * @throws NotFoundException
     */
    public static function get($orderNo)
    {
        $order = Order::where('order_no', $orderNo)->first();

        if (is_null($order)) {
            throw new NotFoundException("Not Found");
        }

        return $order;
    }


    public static function getPaid()
    {
        $data = DB::table('order')
            ->where('order.status_id', '=', Config::get('constants.orderStatus.paid'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, `order`.last_action_at, NOW()) >= ?', [
                Config::get('constants.order.confirmTime')
            ])
            ->select('*')
            ->get();
        return $data;
    }

    public static function getOrder($order_id)
    {
        $data = DB::table('order')
            ->where('order.id', '=', $order_id)
            ->join('user', 'user.id', '=', 'order.user_id')
            ->join('order_status', 'order.status_id', '=', 'order_status.id')
            ->select(
                'user.nickname',
                'order.id',
                'order.order_no',
                'order.address',
                'order.contact',
                'order.phone',
                'order.last_action_at',
                'order.total',
                'order.created_at',
                'order.status_id as status',
                'order_status.name as status_name'
            )
            ->first();
        return $data;
    }

    public static function getOrderItems($order_id)
    {
        $data = DB::table('order_item')
            ->where('order_id', '=', $order_id)
            ->select('*')
            ->get();

        return $data;
    }

    public static function createOrder($user_id, $userAddress)
    {
        $order = new Order();
        $order->order_no = time() . str_random(22);
        $order->user_id = $user_id;
        $order->contact = $userAddress->contact;
        $order->phone = $userAddress->phone;
        $order->address = $userAddress->address;
        $order->status_id = Config::get('constants.orderStatus.unpaid');
        $order->last_action_at = date('Y-m-d H:i:s');
        $order->save();

        //把购物车里的所有商品，生成订单
        $cart = Cart::content();

        foreach ($cart as $item) {
            self::insertOrderItem(
                $order->id,
                $item->id,
                $item->name,
                $item->options['cover'],
                $item->qty,
                $item->price,
                $item->options['size_id'],
                $item->options['size_name'],
                $item->options['color_id'],
                $item->options['color_name']
            );
        }

        return $order->id;
    }

    protected static function insertOrderItem(
        $order_id,
        $pid,
        $pName,
        $cover,
        $qty,
        $price,
        $sid,
        $sName,
        $cid,
        $cName
    )
    {
        $orderItem = new OrderItem();
        $orderItem->order_id = $order_id;
        $orderItem->production_id = $pid;
        $orderItem->production_name = $pName;
        $orderItem->cover = $cover;
        $orderItem->quantity = $qty;
        $orderItem->price = $price;
        $orderItem->total = $price * $qty;
        $orderItem->color_id = $cid;
        $orderItem->color_name = $cName;
        $orderItem->size_id = $sid;
        $orderItem->size_name = $sName;
        $orderItem->save();

        self::updateTotal($order_id, $orderItem->total);

        //减少商品的数量
        Production::decreaseQuantity($sid, $qty);
    }

    protected static function updateTotal($order_id, $total)
    {
        DB::table('order')
            ->where('order.id', '=', $order_id)
            ->increment('total', $total);
    }

    public static function checkOrder_no($order_no)
    {
        $flag = DB::table('order')
            ->where('order.order_no', '=', $order_no)
            ->count();
        return $flag === 1;
    }

    public static function payOrder($order_no)
    {
        DB::table('order')
            ->where('order.order_no', '=', $order_no)
            ->update([
                'order.status_id' => Config::get('constants.orderStatus.paid'),
            ]);
    }


    public static function cancelOrder()
    {
        $orders = DB::table('order')
            ->where('order.status_id', '=', Config::get('constants.orderStatus.unpaid'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, `order`.last_action_at, NOW()) >= ?', [
                Config::get('constants.order.cancelTime')
            ])
            ->select('order.id')
            ->get();

        foreach ($orders as $order) {

            $sizes = DB::table('order_item')
                ->where('order_item.order_id', '=', $order->id)
                ->select(
                    'order_item.size_id',
                    'order_item.quantity'
                )
                ->get();

            foreach ($sizes as $size) {
                Production::increaseQuantity($size->size_id, $size->quantity);
            }

            DB::table('order')
                ->where('order.id', '=', $order->id)
                ->update([
                    'order.status_id' => Config::get('constants.orderStatus.cancel'),
                ]);
        }
    }

    public static function confirmOrder()
    {
        DB::table('order')
            ->where('order.status_id', '=', Config::get('constants.orderStatus.paid'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, `order`.last_action_at, NOW()) >= ?', [
                Config::get('constants.order.confirmTime')
            ])
            ->update([
                'order.status_id' => Config::get('constants.orderStatus.confirm'),
                'last_action_at' => date('Y-m-d H:i:s'),
            ]);
    }

    public static function receivedOrder()
    {
        DB::table('order')
            ->where('order.status_id', '=', Config::get('constants.orderStatus.deliver'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, `order`.last_action_at, NOW()) >= ?', [
                Config::get('constants.order.receivedTime')
            ])
            ->update([
                'order.status_id' => Config::get('constants.orderStatus.received'),
                'last_action_at' => date('Y-m-d H:i:s'),
            ]);
    }

    public static function getFinishOrder()
    {
        $query = DB::table('order')
            ->where('order.status_id', '=', Config::get('constants.orderStatus.received'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, `order`.last_action_at, NOW()) >= ?', [
                Config::get('constants.order.finishTime')
            ])
            ->select('id')
            ->get();

        return $query;
    }

    public static function finishOrder()
    {
        DB::table('order')
            ->where('order.status_id', '=', Config::get('constants.orderStatus.received'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, `order`.last_action_at, NOW()) >= ?', [
                Config::get('constants.order.finishTime')
            ])
            ->update([
                'order.status_id' => Config::get('constants.orderStatus.finish'),
                'last_action_at' => date('Y-m-d H:i:s'),
            ]);
    }

    public function reject()
    {
        if ($this->status_id == Config::get('constants.orderStatus.received')) {
            $this->status_id = Config::get('constants.orderStatus.reject');
            //Don't update the last_action_at
            //the last_action_at use to calculate the finish time
            $this->save();
        }
    }

    /**
     * 允许退货
     */
    public function rejected()
    {
        if ($this->status_id == Config::get('constants.orderStatus.reject')) {
            $this->status_id = Config::get('constants.orderStatus.rejected');
            $this->save();

            //@TODO money cancel

        }
    }

    /**
     * 拒绝退货
     */
    public function denyRejected()
    {
        if ($this->status_id == Config::get('constants.orderStatus.reject')) {
            $this->status_id = Config::get('constants.orderStatus.received');
            $this->save();
        }
    }

    /**
     * 换货处理中
     */
    public function exchange()
    {
        if ($this->status_id == Config::get('constants.orderStatus.reject')) {
            $this->status_id = Config::get('constants.orderStatus.exchange');
            $this->save();
        }
    }
}
