@extends('template.template')

@section('title', '参与投票抽奖 - 魔豆树')

@section('body')
    <div class="v-logo">
        <img src="img/logo.png">
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
        <p>1.如果你无法简洁的表达你的想法，那只说明你还不够了解它。</p>
        <p>1.如果你无法简洁的表达你的想法，那只说明你还不够了解它。</p>
        <p>1.如果你无法简洁的表达你的想法，那只说明你还不够了解它。</p>
        <p>1.如果你无法简洁的表达你的想法，那只说明你还不够了解它。</p>
    </div>
    <div class="explain">
        <hr class="gift">
        <p>1.如果你无法简洁的表达你的想法，那只说明你还不够了解它。</p>
        <p>1.如果你无法简洁的表达你的想法，那只说明你还不够了解它。</p>
        <p>1.如果你无法简洁的表达你的想法，那只说明你还不够了解它。</p>
        <p>1.如果你无法简洁的表达你的想法，那只说明你还不够了解它。</p>
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

@section('moreScript')
    <script src="{{ asset('assets/js') }}/zoom.min.js"></script>
@endsection

@section('moreCss')
    <link rel="stylesheet" href="{{ asset('assets/css') }}/zoom.css">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/vote.css">
@endsection