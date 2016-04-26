@extends('template.template')

@section('title', '首页 - 魔豆树')

@section('body')
    <div class="wrapper">

        <div class="m-head">
            <div class="m-name">MODELO</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="javascript:history.go(-1);"><span class="fa fa-reply fl"></span></a>
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
                        <div class="col col-xs-{{ $col->size }}" style="text-align: center;">
                            {{--image--}}
                            @if($col->type == 1)
                                <img src="{{ $col->content }}" alt="" style="width: 100%;">
                            @else
                                <a href="{{ $col->content }}" style="color: #101010;">TEST</a>
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
        {{--<div class="mb45"></div>--}}
    </div>
    <div class="m-bottom-bar">
        <div class="col" id="theme">
            <span class="fa fa-shopping-bag"></span> 按主题搜索
            <div class="popup hide">
                <div class="item">
                    VERY 90s' FOR MOTHER'S DAY
                </div>
                <div class="item">
                    VERY 90s' FOR MOTHER'S DAY
                </div>
                <div class="item nb">
                    敬请期待
                </div>
            </div>
        </div>
        <div class="col" id="classify">
            <span class="fa fa-tags"></span> 商品分类
            <div class="popup hide">
                <div class="item">
                    <a href="allgoods.html">全部商品</a>
                </div>
                <div class="item">
                    上身
                </div>
                <div class="item">
                    下身
                </div>
                <div class="item nb">
                    连体
                </div>
            </div>
        </div>
        <div class="cf"></div>
    </div>
@endsection

@section('moreCss')
    <style>
        body {
            padding-bottom: 34px;
        }
    </style>
@endsection