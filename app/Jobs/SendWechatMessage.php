<?php

namespace App\Jobs;

use App\Jobs\Job;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWechatMessage extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $openId;

    public function __construct($openId)
    {
        $this->openId = $openId;
    }

    public function handle()
    {
        $app = app('wechat');
        $message = new Text(['content' => 'Hello world!']);;
        $news = new News([
            'title' => 'aaa',
            'description' => 'qqq',
            'url' => 'http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000047&idx=2&sn=fffcfea7b08711b085fd0226beef8dd5#rd',
            'image' => 'https://mmbiz.qlogo.cn/mmbiz/CaiburVeswg4QRLzpP3ficxjBlKRGgRIIHzc2x1C8xqoIB4hwIs6UPibgWOiba3AicZxfdbspObCIXLia2ONdzgPf9rQ/0?wx_fmt=jpeg',
        ]);
        $app->staff->message([$news, $news, $news])->to($this->openId)->send();
    }
}
