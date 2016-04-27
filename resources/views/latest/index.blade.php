@extends('template.template')

@section('title', '首页 - 魔豆树')

@section('body')
    <div class="wrapper">

        <div class="m-head">
            <div class="m-name">MODELO</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url('/') }}"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-shopping-car">
                    <span class="fa fa-shopping-cart"></span>
                </div>
            </div>
        </div>

        <div class="m-title">最新商品</div>


        <div class="container">
            @foreach($data as $item)
                <div class="row" style="margin-bottom: .5em;">
                    @foreach($item as $col)
                        <div class="col col-xs-{{ $col->size }} @if($col->offset != 0) col-xs-offset-{{ $col->offset }} @endif"
                             style="text-align: center;">
                            {{--image--}}
                            @if($col->type == 1)
                                <img src="{{ $col->content }}" alt="{{ $col->name }}" style="width: 100%;">
                            @else
                                <a href="{{ $col->content }}" style="color: #101010;">{{ $col->name }}</a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        {{--<div class="goods-item">--}}
        {{--<div class="goods-pic">--}}
        {{--<img src="img/goods1.jpeg">--}}
        {{--</div>--}}
        {{--<div class="goods-name">--}}
        {{--单宁七分阔腿裤 ￥220 <span class="fa fa-tag"></span>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="goods-item">--}}
        {{--<div class="goods-pic">--}}
        {{--<img src="img/goods1.jpeg">--}}
        {{--</div>--}}
        {{--<div class="goods-name">--}}
        {{--<div class="col">单宁七分阔腿裤 ￥220</div>--}}
        {{--<div class="col">单宁七分阔腿裤 ￥220 <span class="fa fa-tag"></span></div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="goods-item">--}}
        {{--<div class="goods-pic">--}}
        {{--<img src="img/goods1.jpeg">--}}
        {{--</div>--}}
        {{--<div class="goods-name">--}}
        {{--<div class="col">单宁七分阔腿裤 ￥220</div>--}}
        {{--<div class="col">单宁七分阔腿裤 ￥220 <span class="fa fa-tag"></span></div>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="mb45"></div>
    </div>
    @extends('common.bottom_bar')
@endsection

@section('moreCss')
    <style>
        body {
            padding-bottom: 34px;
            height: auto !important;
        }

        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
            padding-right: 0;
            padding-left: 0;
        }
    </style>
@endsection