@extends('template.basic')

@section('title', '参与投票抽奖 - 魔豆树')

@section('body')
    <div class="v-logo">
        <img src="{{ asset('assets/images') }}/logo.jpg">
    </div>
    <!---->
    <div class="v-title">
        <p>投票成功，已参加抽奖！</p>
    </div>
    <div class="v-block">
        <div class="title">兑奖号码</div>
        <div class="exchange-num">{{ $result_a }}</div>
        <div class="exchange-num">{{ $result_b }}</div>
    </div>
    <div class="explain">
        <hr class="role">
<p>Step 1: 选取热门的他
抽奖当日15:00时，魔豆树将会截取微博实时热搜榜的截图，选取排名最高的男性名字作为当日来开奖的他，然后选取这这条热搜右边的搜索指数作为计算依据
（选名字规则：不包括英文名，角色名，小名，昵称，职业，粉丝称呼等，如猴哥、周董、赵医生、大一男生等，均不选取。西方名字选取姓氏全称或者名字全称。）</p>

<p>Step 2：公式换算选中奖号码
 x= 男神热搜指数
x的平方 除以投票总人数所得的余数为基准数，5个中奖号码分别为
   基准数+100， 基准数+200，基准数+300，基准数+400，基准数+500
（ 若中奖号妈大于投票总人数，则取减去投票总人数后所得的数字）</p>

<p>你最想哪个他来给你送礼物？你的爱豆会不会正好是你的lucky star？
马上投票，关注我们，惊喜无处不在！</p>

<p>投票规则的最终解释权归本公司所有</p>
    </div>
    <div class="explain">
        <hr class="gift">
<p>第一重礼遇：</p>
<p>连续一个月，每3天采用公开抽奖的方式抽取5位成功投票的参与者，随机送出以上的美颜彩妆一份
抽奖日期：6月1日，4日............
</p>

<p>第二重礼遇：</p>
<p>7月1日公布票数最高的那一款 In Mods’ Code首月爆款。从该款投票者中，采用公开抽奖的方式抽取5位送出Ladurée花瓣腮红（粉芯和粉盅全套）一份</p>
    </div>
    <div class="result-title">投票结果</div>
    <div class="vote-num">投票人数：{{ $vote->total }} 人</div>
    <div class="vote-list">
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/1.jpg">
                <div class="vote-name">
                    白色府绸长衬衣
                </div>
                <div class="vote-result">
                    {{ $vote->A }} 票({{ $vote->A/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/2.jpg">
                <div class="vote-name">
                    藏青亚麻上衣
                </div>
                <div class="vote-result">
                    {{ $vote->B }} 票({{ $vote->B/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/3.jpg">
                <div class="vote-name">
                    缎面印花半身裙
                </div>
                <div class="vote-result">
                    {{ $vote->C }} 票({{ $vote->C/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/4.jpg">
                <div class="vote-name">
                    黑白前后拼色连衣裙
                </div>
                <div class="vote-result">
                    {{ $vote->D }} 票({{ $vote->D/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/5.jpg">
                <div class="vote-name">
                    黑色后镂空针织连衣裙
                </div>
                <div class="vote-result">
                    {{ $vote->E }} 票({{ $vote->E/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/6.jpg">
                <div class="vote-name">
                    黑色雪纺连体裤
                </div>
                <div class="vote-result">
                    {{ $vote->F }} 票({{ $vote->F/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/7.jpg">
                <div class="vote-name">
                    雪纺印花背心连衣长裙
                </div>
                <div class="vote-result">
                    {{ $vote->G }} 票({{ $vote->G/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/8.jpg">
                <div class="vote-name">
                    亚麻短上衣
                </div>
                <div class="vote-result">
                    {{ $vote->H }} 票({{ $vote->H/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/9.jpg">
                <div class="vote-name">
                    亚麻风琴褶阔腿裤
                </div>
                <div class="vote-result">
                    {{ $vote->I }} 票({{ $vote->I/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/vote/10.jpg">
                <div class="vote-name">
                    印花雪纺长衬衣
                </div>
                <div class="vote-result">
                    {{ $vote->J }} 票({{ $vote->J/$vote->total*100 }}%)
                </div>
            </div>
        </div>
        <div class="cf"></div>
    </div>
    <div class="follow mt40">
        <img src="{{ asset('assets') }}/images/qrcode.jpg">
        <div class="text">
            关注我们
        </div>
        <div class="name">
            In Mods' Code 魔豆树
        </div>
    </div>
@endsection

@section('script')
    {{--<script src="{{ asset('assets/js') }}/zoom.min.js"></script>--}}
@endsection

@section('css')
    {{--<link rel="stylesheet" href="{{ asset('assets/css') }}/zoom.css">--}}
    <link rel="stylesheet" href="{{ asset('assets/css') }}/vote.css">
@endsection