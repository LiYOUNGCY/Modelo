<?php

namespace App\Http\Controllers\Wechat;

use App\Model\Order;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    protected $notice;

    public function __construct()
    {
        parent::__construct();
        $this->notice = app('wechat')->notice;
    }


    public function paySuccess($openid, $orderId)
    {
        $order = Order::find($orderId);

        if (isset($order) && $order->status_id == Config::get('constants.orderStatus.paid')) {
            $userId = $openid;
            $templateId = 'jTUgfI4AqGvqtYuIW49HJQypNlU3s_2f4CDs4HCby_c';
            $url = url("order/{$order->id}");
//            $color = '#000000';

            $data = array(
                "first" => "
亲爱的魔豆，您已支付成功！",
                "keyword1" => "{$order->total}",
                "keyword2" => "MODS' 服装",
                "keyword3" => "微信支付",
                "keyword4" => "{$order->wechat_order_no}",
                "keyword5" => "{$order->last_action_at}",
                "remark" => "点击下方详情，查看更多信息",
            );

            $messageId = $this->notice->uses($templateId)->withUrl($url)->andData($data)->andReceiver($userId)->send();
        }
    }
}
