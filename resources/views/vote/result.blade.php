@extends('template.basic')

@section('title', '参与投票抽奖 - 魔豆树')

@section('body')
    <div class="v-logo">
        <img src="{{ asset('assets/images') }}/logo.png">
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
    <div class="result-title">投票结果</div>
    <div class="vote-num">投票人数：1000 人</div>
    <div class="vote-list">
        <div class="vote-item active">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/all-goods1.jpeg">
                <div class="vote-name">
                    花裙子
                </div>
                <div class="vote-result">
                    101 票(70%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/all-goods1.jpeg">
                <div class="vote-name">
                    花裙子
                </div>
                <div class="vote-result">
                    100 票(30%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/all-goods1.jpeg">
                <div class="vote-name">
                    花裙子
                </div>
                <div class="vote-result">
                    100 票(70%)
                </div>
            </div>
        </div>
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/all-goods1.jpeg">
                <div class="vote-name">
                    花裙子(70%)
                </div>
                <div class="vote-result">
                    100 票
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