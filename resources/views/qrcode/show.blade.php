@extends('template.template')

@section('title', '我的二维码 - 魔豆树')

@section('body')
    <div class="wrapper qrcode-page">
        <div class="m-head">
            <div class="m-name">MODELO</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url('user') }}"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-nav">
                    <span class="fa fa-navicon"></span>
                </div>
            </div>
        </div>

        <img src="{{ $qrcode->qrcode }}">
    </div>
@endsection