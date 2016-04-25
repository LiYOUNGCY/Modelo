@extends('template.template')

@section('title', '首页 - 魔豆树')

@section('body')
    <div class="wrapper">
        <div class="m-logo">
            <img src="{{ url('assets/images') }}/logo.png">
        </div>
        <div class="m-postcard" style="background-image: url({{ asset('assets/images') }}/index.jpeg)"></div>
    </div>

    <div class="nav-bar">
        <ul class="m-nav">
            <a href="">
                <li class="nav-item w33 active">
                    <div><span class="fa fa-star-o"></span></div>
                    <div>最新商品</div>
                </li>
            </a>
            <a href="{{ url('user') }}">
                <li class="nav-item w33">
                    <div><span class="fa fa-user"></span></div>
                    <div>会员中心</div>
                </li>
            </a>
            <a href="">
                <li class="nav-item w33">
                    <div><span class="fa fa-reorder"></span></div>
                    <div>我的订单</div>
                </li>
            </a>
        </ul>
    </div>
@endsection