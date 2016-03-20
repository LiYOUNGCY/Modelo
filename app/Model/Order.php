<?php

namespace App\Model;

use Cart;
use Illuminate\Database\Eloquent\Model;
use Config;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = 'order';

    protected static $limit = 20;

    public static function getAll($page = 1)
    {
        if ($page < 1) {
            throw new \Exception();
        }

        $data = DB::table('order')
            ->join('user', 'user.id', '=', 'order.user_id')
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
                'order.status'
            )
            ->skip(($page - 1) * self::$limit)
            ->take(self::$limit)
            ->get();
        return $data;
    }

    public static function getAllPage()
    {
        $count = DB::table('order')->count();
        return ceil($count / self::$limit);
    }

    public static function createOrder($user_id, $userAddress)
    {
        $order = new Order();
        $order->order_no = time() . str_random(22);
        $order->user_id = $user_id;
        $order->contact = $userAddress->contact;
        $order->phone = $userAddress->phone;
        $order->address = $userAddress->address;
        $order->status = Config::get('constants.orderStatus.unpaid');
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
    }

    protected static function updateTotal($order_id, $total)
    {
        DB::table('order')
            ->where('order.id', '=', $order_id)
            ->increment('total', $total);
    }
    
    public static function cancelOrder()
    {
        DB::table('order')
            ->where('order.status', '=', Config::get('constants.orderStatus.unpaid'))
            ->whereRaw('TIMESTAMPDIFF(MINUTE, `order`.last_action_at, NOW()) > ?', [
                Config::get('constants.order.cancelTime')
            ])
            ->update([
                'order.status' => Config::get('constants.orderStatus.cancel'),
            ]);
    }
}
