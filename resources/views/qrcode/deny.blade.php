@extends('template.template')

@section('title', '我的二维码 - 魔豆树')

@section('body')
    <div class="wrapper qrcode-page">
        <div class="m-head">
            <div class="m-name">In Modss' Code</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url('user') }}"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-nav">
                    <span class="fa fa-navicon"></span>
                </div>
            </div>
        </div>

        <div style="position: absolute; top: 50%; left: 0; right: 0; text-align: center;">
            <a href="#" style="color: #0c0c0c; font-size: 125%;">点击查看如何获取“我的二维码”</a>
        </div>
    </div>
@endsection