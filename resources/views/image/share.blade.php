@extends('template.template')

@section('title', '图片 - 魔豆树')

@section('body')
    <div class="wrapper qrcode-page">
        <div class="m-head">
            <div class="m-name">In Modss' Code</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url('qrcode') }}"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-nav">
                    <span class="fa fa-navicon"></span>
                </div>
            </div>
        </div>

        <div class="share-photo-tips">
            <p>找到你喜欢的款式</p>
            <p>保存到手机</p>
            <p class="mb0">连你的二维码一同分享!</p>
        </div>
        <div class="share-photo-list">
            @foreach($productions as $production)
                <div class="share-photo-item">
                    <a href="{{ url("image/{$production->id}/show") }}"><img src="{{ url($production->cover->path) }}"></a>
                </div>
            @endforeach
            {{--<div class="share-photo-item">--}}
                {{--<a href="{{ url('image/1/show') }}"><img src="{{ asset('assets/images') }}/vote/1.jpg"></a>--}}
            {{--</div>--}}
            {{--<div class="share-photo-item">--}}
                {{--<a href="#"><img src="{{ asset('assets/images') }}/vote/2.jpg"></a>--}}
            {{--</div>--}}
            {{--<div class="share-photo-item">--}}
                {{--<a href="#"><img src="{{ asset('assets/images') }}/vote/3.jpg"></a>--}}
            {{--</div>--}}
            {{--<div class="share-photo-item">--}}
                {{--<a href="#"><img src="{{ asset('assets/images') }}/vote/4.jpg"></a>--}}
            {{--</div>--}}
            {{--<div class="share-photo-item">--}}
                {{--<a href="#"><img src="{{ asset('assets/images') }}/vote/5.jpg"></a>--}}
            {{--</div>--}}
            <div class="cf"></div>
        </div>
    </div>
@endsection