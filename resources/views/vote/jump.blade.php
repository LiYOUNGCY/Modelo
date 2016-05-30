@extends('template.basic')

@section('title', '参与投票抽奖 - 魔豆树')

@section('body')

<div class="jump-bg">
    <img src="{{ asset('assets/images') }}/index.jpg">
    <div class="jump-qrcode">
        <img class="qrcode" src="{{ asset('assets/images') }}/voteqrcode.jpg">
        <div class="tip">
            <p>长按二维码关注我们</p>
            参与投票，赢取双礼
        </div>
    </div>
</div>


@endsection

@section('script')
    <script>
        $(function () {

        })
    </script>
@endsection

@section('css')
    {{--<link rel="stylesheet" href="{{ asset('assets/css') }}/zoom.css">--}}
    <link rel="stylesheet" href="{{ asset('assets/css') }}/vote.css">
@endsection
