<?php

namespace App\Http\Controllers\Wechat;

use App\Model\Order;
use App\Model\User;
use App\Http\Requests;
use Config;


trait Notice
{
    protected $notice;

    public function __construct()
    {
        $this->notice = app('wechat')->notice;
    }


    public function paySuccessNotice($wechat_order_no)
    {
        $total = Order::getTotal($wechat_order_no);
        $now = date("Y-m-d H:i:s");

        $order = Order::where('wechat_order_no', $wechat_order_no)->first();
        $user = User::find($order->user_id);
        if (isset($order) && isset($user)) {
            $userId = $user->openid;
            $templateId = 'jTUgfI4AqGvqtYuIW49HJQypNlU3s_2f4CDs4HCby_c';
            $url = url("order");
//            $color = '#000000';

            $data = array(
                "first" => "亲爱的魔豆，您已支付成功！",
                "keyword1" => "{$total}",
                "keyword2" => "MODS' 服装",
                "keyword3" => "微信支付",
                "keyword4" => "{$wechat_order_no}",
                "keyword5" => "{$now}",
                "remark" => "点击下方详情，查看更多信息",
            );

            $this->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
    }

    /**
     * 商品发货通知
     * @param $userId
     * @param $orderId
     */
    public function deliverNotice($userId, $orderId)
    {
        $order = Order::find($orderId);
        $user = User::find($userId);

        if (
            isset($order)
            && isset($user)
            && $order->status_id == Config::get('constants.orderStatus.deliver')
        ) {
            $userId = $user->openid;
            $templateId = 'BEMRZvPBToCBDEo4qlO9WJwlaAXOsC9Ivu0Z6ZsNEAk';
            $url = url("order/{order->id}");

            $data = array(
                "first" => "亲爱的魔豆，您的商品已发货",
                "keyword1" => "{$order->express}",
                "keyword2" => "{$order->tracking_no}",
                "keyword3" => "MODS' 服装",
                "keyword4" => "1",
                "remark" => "点击下方详情，查看更多信息",
            );

            $this->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
    }

    /**
     * 取消订单通知
     * @param $userId
     * @param $orderId
     */
    public function cancelNotice($userId, $orderId)
    {
        $order = Order::find($orderId);
        $user = User::find($userId);

        if (
            isset($order)
            && isset($user)
            && $order->status_id == Config::get('constants.orderStatus.cancel')
        ) {
            $userId = $user->openid;
            $templateId = '73aB9Ov6_Sg8Rvr2rKLqK3p6nE-JBez6z1uhme8EqvQ';
            $url = url("order/{order->id}");

            $data = array(
                "first" => "亲爱的魔豆，您的订单已被取消",
                "keyword1" => "{$order->order_no}",
                "keyword2" => "取消",
                "keyword3" => "{$order->total}",
                "keyword4" => "{$order->last_action_at}",
                "keyword5" => "{$user->nickname}",
                "remark" => "点击下方详情，查看更多信息",
            );

            $this->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
    }

    /**
     * 允许退货货通知
     * @param $userId
     * @param $orderId
     */
    public function rejectNotice($userId, $orderId)
    {
        $order = Order::find($orderId);
        $user = User::find($userId);

        if (
            isset($order)
            && isset($user)
            && (
                $order->status_id == Config::get('constants.orderStatus.rejected')
                || $order->status_id == Config::get('constants.orderStatus.exchange')
            )
        ) {
            $userId = $user->openid;
            $templateId = 'B5_bBnwSBqWJCm88TbFu12yKjl7BJu5NMcZZcMbVoC4';
            $url = url("order/{order->id}");

            $data = array(
                "first" => "亲爱的魔豆，您的退（换）货申请已受理",
                "keyword1" => "{$order->order_no}",
                "keyword2" => "MODS' 服装",
                "keyword3" => "1",
                "keyword4" => "{$order->total}元",
                "keyword5" => "{$order->last_action_at}",
                "remark" => "点击下方详情，查看更多信息。如有疑问，可以联系微信客服，竭诚为您服务。",
            );

            $this->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
    }

//    /**
//     * 退款通知
//     * @param $openid
//     * @param $orderId
//     */
//    public function rejected($openid, $orderId)
//    {
//        $order = Order::find($orderId);
//        $user = User::where('openid', $openid)->first();
//
//        if(
//            isset($order)
//            && isset($user)
//            && $order->status_id == Config::get('constants.orderStatus.cancel')
//        ) {
//            $userId = $user->openid;
//            $templateId = '73aB9Ov6_Sg8Rvr2rKLqK3p6nE-JBez6z1uhme8EqvQ';
//            $url = url("order/{order->id}");
//
//            $data = array(
//                "first" => "亲爱的魔豆，您的订单已被取消",
//                "keyword1" => "{$order->order_no}",
//                "keyword2" => "取消",
//                "keyword3" => "{$order->total}",
//                "keyword4" => "{$order->last_action_at}",
//                "keyword5" => "{$user->nickname}",
//                "remark" => "点击下方详情，查看更多信息",
//            );
//
//            $this->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
//        }
//    }

    /**
     * 商品重新发货通知
     * @param $userId
     * @param $orderId
     */
    public function exchangeNotice($userId, $orderId)
    {
        $order = Order::find($orderId);
        $user = User::find($userId);

        if (
            isset($order)
            && isset($user)
            && $order->status_id == Config::get('constants.orderStatus.exchange')
        ) {
            $userId = $user->openid;
            $templateId = 'BEMRZvPBToCBDEo4qlO9WJwlaAXOsC9Ivu0Z6ZsNEAk';
            $url = url("order/{order->id}");

            $data = array(
                "first" => "亲爱的魔豆，您的换货商品已发货",
                "keyword1" => "{$order->express}",
                "keyword2" => "{$order->tracking_no}",
                "keyword3" => "MODS' 服装",
                "keyword4" => "1",
                "remark" => "点击下方详情，查看更多信息",
            );

            $this->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
    }
}
