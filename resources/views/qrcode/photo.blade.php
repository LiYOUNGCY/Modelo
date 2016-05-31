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

        <div class="share-photo-tips">
            <p>找到你喜欢的款式</p>
            <p>保存到手机</p>
            <p>连你的二维码一同分享!</p>
        </div>
        <div class="share-photo-list">
            <div class="share-photo-item">
                <a href="{{ url('qrcode/save') }}"><img src="{{ asset('assets/images') }}/vote/1.jpg"></a>
            </div>
            <div class="share-photo-item">
                <a href="#"><img src="{{ asset('assets/images') }}/vote/2.jpg"></a>
            </div>
            <div class="share-photo-item">
                <a href="#"><img src="{{ asset('assets/images') }}/vote/3.jpg"></a>
            </div>
            <div class="share-photo-item">
                <a href="#"><img src="{{ asset('assets/images') }}/vote/4.jpg"></a>
            </div>
            <div class="share-photo-item">
                <a href="#"><img src="{{ asset('assets/images') }}/vote/5.jpg"></a>
            </div>
            <div class="cf"></div>
        </div>
    </div>
@endsection