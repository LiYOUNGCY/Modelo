@extends('template.template')

@section('title', '全部商品 - 魔豆树')

@section('body')
    <div class="wrapper ">
        <div class="m-head">
            <div class="m-name">In Mods' Code</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url('latest') }}"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-shopping-car">
                    <span class="fa fa-shopping-cart"></span>
                </div>
            </div>
        </div>

        <div class="m-title">{{ \Illuminate\Support\Facades\Config::get("constants.categoryName.{$category}") }}</div>

        @foreach($productions as $production)
            <div class="all-goods-item">
                <div class="goods-pic">
                    <a href="{{ url("production/{$production->alias}") }}">
                        <img src="{{ asset($production->cover->path) }}">
                    </a>
                </div>
                <div class="goods-name">
                    <a href="{{ url("production/{$production->alias}") }}">{{$production->name}}</a>
                </div>
            </div>
        @endforeach

        <div class="mb45"></div>
    </div>
    @extends('common.bottom_bar')
    <div class="pb40"></div>
@endsection