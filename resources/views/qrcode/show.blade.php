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

        <div class="share-tips">
			长按图片保存到手机，分享图片传播你的二维码。
			<div class="btn check_sharephpto">
                <a href="{{ url('image/share') }}">查看保存分享图片</a>
			</div>
		</div>

        <img src="{{ $qrcode->qrcode }}" style="width: 100%;">
    </div>
@endsection