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

    public function status()
    {
        return $this->belongsTo('App\Model\OrderStatus', 'status_id');
    }

    public static function getAll($statusId = null)
    {
        $data = DB::table('order')
//            ->orderBy('', 'desc')
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
            );


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
                'order_status.name as status_name',
                'order.express',
                'order.tracking_no',
                'order.remark'
            )
            ->first();
        return $data;
    }

    public static function getOrderItems($order_id)
    {
        $data = DB::table('order_item')
            ->where('order_id', '=', $order_id)
            ->select('*')
            ->first();

        return $data;
    }

    public static function createOrder($wechat_order_no, $user_id, $userAddress, $remark)
    {
        $order = new Order();
        $order->order_no = time() . 'MODES' . str_random(17);
        $order->wechat_order_no = $wechat_order_no;
        $order->user_id = $user_id;
        $order->contact = $userAddress->contact;
        $order->phone = $userAddress->phone;
        $order->address = $userAddress->address;
        $order->status_id = Config::get('constants.orderStatus.unpaid');
        $order->last_action_at = date('Y-m-d H:i:s');
        $order->remark = $remark;
        $order->save();

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

    public static function payOrder($wechat_order_no)
    {
        DB::table('order')
            ->where('order.wechat_order_no', '=', $wechat_order_no)
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

    public static function getTotal($wechat_order_no)
    {
        $result = DB::table('order')
            ->where('wechat_order_no', $wechat_order_no)
            ->sum('total');

        return $result;
    }
}
