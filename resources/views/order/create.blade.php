@extends('template.template')

@section('title', "创建订单 - 魔豆树")

@section('body')
    <div class="wrapper">
        <div class="block-w withback-title">
            <a href="javascript:history.go(-1)"><div class="button back">返回</div></a>
            确认订单信息
        </div>
        <div class="block-w picked-goods">
            <div class="title">选购商品</div>

            @foreach($cart as $value)
            <div class="picked-goods-info">
                <div class="picked-goods-pic">
                    <img src="{{ asset($value->options['cover']) }}" alt="">
                </div>
                <div class="picked-goods-detail">
                    <p><span id="name">{{ $value->name }}</span></p>
                    <p>款式码数：<span id="style">{{ $value->options['color_name'] }}</span> <span id="size">{{ $value->options['size_name'] }}</span></p>
                    <p>数量：<span id="num">{{ $value->qty }}</span></p>
                    <p>价钱：{{ $value->price }}</p>
                </div>
                <div class="cf"></div>
            </div>
            @endforeach
            <div class="pinal-total">
                总计：￥{{ $total }}
            </div>
        </div>
        <div class="block-w picked-goods">
            <div class="title">送货地址：</div>
            <div class="final-address">
                <p>联系人：<span id="contact">{{ $userAddress->contact }}</span></p>
                <p>联系电话：<span id="tel">{{ $userAddress->phone }}</span></p>
                <p>联系地址：<span id="address">{{ $userAddress->address }}</span></p>
            </div>
        </div>
        <div class="block-w order-remark">
            <form action="#">
                <div class="input-group">
                    <label for="remark">备注：</label>
                    <textarea name="remark" id="remark" placeholder="（非必填）"></textarea>
                </div>
            </form>
        </div>

        <div class="button full confirm-order">
            <a href="javascript:void(0)">
                去支付
            </a>
        </div>
    </div>
@endsection