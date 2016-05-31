<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Model\Order;
use App\Model\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class DliverNotice extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $orderId;
    protected $userId;

    public function __construct($orderId, $userId)
    {
        $this->orderId = $orderId;
        $this->userId = $userId;
    }

    public function handle()
    {
        $order = Order::find($this->orderId);
        $user = User::find($this->userId);

        if (
            isset($order)
            && isset($user)
            && $order->status_id == Config::get('constants.orderStatus.deliver')
        ) {
            $userId = $user->openid;
            $templateId = 'BEMRZvPBToCBDEo4qlO9WJwlaAXOsC9Ivu0Z6ZsNEAk';
            $url = url("order/{$order->id}");

            $data = array(
                "first" => "亲爱的魔豆，您的商品已发货",
                "keyword1" => "{$order->express}",
                "keyword2" => "{$order->tracking_no}",
                "keyword3" => "MODS' 服装",
                "keyword4" => "1",
                "remark" => "点击下方详情，查看更多信息",
            );

            app('wechat')->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
    }
}
