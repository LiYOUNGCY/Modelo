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
    <div class="vote-num">投票人数：{{ $vote->total }} 人</div>
    <div class="vote-list">
        <div class="vote-item">
            <div class="vote-info">
                <img src="{{ asset('assets/images') }}/all-goods1.jpeg">
                <div class="vote-name">
                    花裙子
                </div>
                <div class="vote-result">
                    {{ $vote->A }} 票({{ $vote->A/$vote->total*100 }}%)
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
                    {{ $vote->B }} 票({{ $vote->B/$vote->total*100 }}%)
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
                    {{ $vote->C }} 票({{ $vote->C/$vote->total*100 }}%)
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
                    {{ $vote->D }} 票({{ $vote->D/$vote->total*100 }}%)
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
                    {{ $vote->E }} 票({{ $vote->E/$vote->total*100 }}%)
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
                    {{ $vote->F }} 票({{ $vote->F/$vote->total*100 }}%)
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
                    {{ $vote->G }} 票({{ $vote->G/$vote->total*100 }}%)
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
                    {{ $vote->H }} 票({{ $vote->H/$vote->total*100 }}%)
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
                    {{ $vote->I }} 票({{ $vote->I/$vote->total*100 }}%)
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