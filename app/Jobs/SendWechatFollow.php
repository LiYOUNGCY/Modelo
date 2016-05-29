<?php

namespace App\Jobs;

use App\Jobs\Job;
use EasyWeChat\Message\Text;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWechatFollow extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $openId;

    public function __construct($openId)
    {
        $this->openId = $openId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url= url('/');
        $message = new Text(["谢谢那么好看的你来加入魔豆世界，这里是有颜走心的购物分享平台。了解我们请点击<a href='http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000082&idx=1&sn=771c9e17262385afe7048b54e274dc74#rd'>这里</a>，喜欢我们的原创设计点击<a href='{$url}'>这里</a>购买。"]);
        $app = app('wechat');
//        $broadcast = $app->broadcast;
//        $broadcast->sendText($message, [$this->openId, $this->openId]);

        $app->staff->message($message)->to($this->openId)->send();
    }
}
