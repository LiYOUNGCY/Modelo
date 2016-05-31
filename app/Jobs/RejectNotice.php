<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Model\Order;
use App\Model\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RejectNotice extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $orderId;
    protected $userId;

    public function __construct($orderId, $userId)
    {
        $this->orderId = $orderId;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = Order::find($this->orderId);
        $user = User::find($this->userId);

        if (
            isset($order)
            && isset($user)
            && (
                $order->status_id == Config::get('constants.orderStatus.rejected')
                || $order->status_id == Config::get('constants.orderStatus.exchange')
            )
        ) {
            $userId = $user->openid;
            $templateId = '1D7sMMY4NkKhtXYsUI-aWZCzjB2TxrZQdoIgq60ST98';
            $url = url("order/{$order->id}");

            $data = array(
                "first" => "亲爱的魔豆，您的退货已成功",
                "reason" => "退货成功",
                "refund" => "{$order->total}",
                "remark" => "点击下方详情，查看更多信息。如有疑问，可以联系微信客服，竭诚为您服务。",
            );

            app('wechat')->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
    }
}
