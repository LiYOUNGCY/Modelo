@extends('template.template')

@section('title', '首页 - 魔豆树')

@section('body')
    <div class="wrapper index">
        <div class="m-logo">
            <img src="{{ url('assets/images') }}/logo.jpg">
        </div>
        <div style="">
            <img src="{{ asset('assets/images') }}/index.jpg" style="width: 100%;">
        </div>
{{--        <div class="m-postcard" style="background-image: url({{ asset('assets/images') }}/index.jpg)"></div>--}}
    </div>

    <div class="nav-bar">
        <ul class="m-nav">
            <a href="{{ url('latest') }}">
                <li class="nav-item w33 active">
                    <div><span class="fa fa-star"></span></div>
                    <div>最新商品</div>
                </li>
            </a>
            <a href="{{ url('user') }}">
                <li class="nav-item w33">
                    <div><span class="fa fa-user"></span></div>
                    <div>会员中心</div>
                </li>
            </a>
            <a href="{{ url('order') }}">
                <li class="nav-item w33">
                    <div><span class="fa fa-reorder"></span></div>
                    <div>我的订单</div>
                </li>
            </a>
        </ul>
    </div>
@endsection