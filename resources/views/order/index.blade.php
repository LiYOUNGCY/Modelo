@extends('template.template')

@section('title', "我的订单 - 魔豆树")

@section('body')
    <div class="wrapper">

        <div class="m-head">
            <div class="m-name">In Mods' Code</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url('/') }}"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-nav">
                    <span class="fa fa-navicon"></span>
                </div>
            </div>
        </div>

        <div class="m-title-usual">
            订单详情
        </div>
        @if(isset($orders))
            <div class="m-order-list">
                @foreach($orders as $order)
                    <div class="order-item">
                        <div class="order-id">订单号：{{ $order->order_no }}</div>
                        <div class="order-goods">
                            <div class="pic"
                                 style="background-image: url({{ asset($orderItem[$order->id]->cover) }})"></div>
                            <div class="detail">
                                <p>{{ $orderItem[$order->id]->production_name }}</p>
                                <p>时间：{{ $order->created_at }}</p>
                                <p>状态：{{ $order->status->name }}</p>
                            </div>
                            <div class="cf"></div>
                        </div>
                        <div style="padding:0 12px;">
                            <div class="check-order">
                                <a href="{{ url("order/{$order->id}") }}">点击查看详情</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-order">暂无订单，去 <a href="{{ url("production") }}">选购下单</a></div>
        @endif
    </div>
@endsection