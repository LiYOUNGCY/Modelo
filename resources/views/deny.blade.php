@extends('template.basic')

@section('title', '请关注公众号 - 魔豆树')

@section('body')

    <div class="jump-bg">
        <img src="{{ asset('assets/images') }}/index.jpg">
        <div class="jump-qrcode">
            <img class="qrcode" src="{{ asset('assets/images') }}/qrcode.jpg">
            <div class="tip">
                <p>长按二维码</p>
                关注公众号参与投票
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
