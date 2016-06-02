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
        $index = url('/');

        $news1 = new News([
            'title' => '点击购买',
            'description' => '点击购买',
            'url' => "{$index}",
            'image' => 'https://mmbiz.qlogo.cn/mmbiz/CaiburVeswg4QRLzpP3ficxjBlKRGgRIIHbS0X3NCMiaCVtjkBQNZdlGRyDwhX9yUjlXmNajxZnVRcQ1UOv7hylNg/0?wx_fmt=jpeg',
        ]);

        $news2 = new News([
            'title' => 'In Mods’ Code 品牌故事',
            'description' => 'In Mods’ Code 品牌故事',
            'url' => "http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000084&idx=1&sn=f8d8da718443a053b98488da7b573b28#rd",
            'image' => 'https://mmbiz.qlogo.cn/mmbiz/CaiburVeswg4QRLzpP3ficxjBlKRGgRIIHafs3wbBE0cMK5NrTj53yQRv46KNAGDzicVMOGk26iaia7snUiafPMUUCIw/0?wx_fmt=jpeg',
        ]);

        $new3 = new News([
            'title' => '魔豆树模式详解',
            'description' => '魔豆树模式详解',
            'url' => "http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000082&idx=1&sn=771c9e17262385afe7048b54e274dc74#rd",
            'image' => 'https://mmbiz.qlogo.cn/mmbiz/CaiburVeswg4QRLzpP3ficxjBlKRGgRIIHiaib4pyfVOkEqpCsCKN9u6n0Vhq2CRy4j2k0mJp7taZbfIwiae777sC4A/0?wx_fmt=jpeg',
        ]);

        $new4 = new News([
            'title' => '魔豆财富详解与提现说明',
            'description' => '魔豆财富详解与提现说明',
            'url' => "http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000076&idx=1&sn=73efafa90db37681d725ee1451fca0e5#rd",
            'image' => 'https://mmbiz.qlogo.cn/mmbiz/CaiburVeswg4QRLzpP3ficxjBlKRGgRIIHOib0VTTdRGicjXU7b7nFDETMXn7d5icpVKib3BKQljZvZ7QCoQ54992Abg/0?wx_fmt=jpeg',
        ]);

        $new5 = new News([
            'title' => '发货与退换货',
            'description' => '发货与退换货',
            'url' => "http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000074&idx=1&sn=1a967cc2d7cac9a962e61fc3775e2b01#rd",
            'image' => 'https://mmbiz.qlogo.cn/mmbiz/CaiburVeswg4QRLzpP3ficxjBlKRGgRIIHYRw5TdAyvXoe03zODWZ4yN1uWL1G9HgIo6WwxYggAqLBPibVY8Qfic9w/0?wx_fmt=jpeg',
        ]);

        $new6 = new News([
            'title' => '微支付开通图文指南',
            'description' => '微支付开通图文指南',
            'url' => "http://mp.weixin.qq.com/s?__biz=MzIyMjIwMjA4Mw==&mid=100000086&idx=1&sn=e7619efa52fb910f790b298f6ab89d5b#rd",
            'image' => 'https://mmbiz.qlogo.cn/mmbiz/CaiburVeswg4QRLzpP3ficxjBlKRGgRIIHIn78OTxVT9wZ29wtbWNTxxv0qZic6Q2oYIHDicBRAEIDkTnbGk6GzE6g/0?wx_fmt=jpeg',
        ]);

        $app->staff->message([$news1, $news2, $new3, $new4, $new5, $new6])->to($this->openId)->send();
    }
}
