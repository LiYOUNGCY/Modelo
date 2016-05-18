@extends('template.template')

@section('title', "创建订单 - 魔豆树")

@section('body')
    <div class="wrapper m-confirm-order">
        <div class="m-head">
            <div class="m-name">MODELO</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="javascript:history.go(-1);"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-nav">
                    <span class="fa fa-navicon"></span>
                </div>
            </div>
        </div>

        <div class="m-title-usual">
            确认订单信息
        </div>
        <div class="co-goods-list">
            选购商品：
            @foreach($productions as $production)
                <div class="co-goods">
                    <div class="pic" style="background-image: url({{ asset($production->options['cover']) }})"></div>
                    <div class="detail">
                        <p>{{ $production->name }}</p>
                        <p>款式 & 码数：{{ $production->options['color_name'] }} {{ $production->options['size_name'] }}</p>
                        <p>数量：{{ $production->qty }}</p>
                        <p>价钱：￥{{ $production->price }}</p>
                    </div>
                    <div class="cf"></div>
                </div>
            @endforeach
        </div>
        <div class="co-total fr">
            总计：￥{{ $total }}
        </div>
        <div class="cf"></div>

        @if(isset($messages))
            <div class="co-address">
                <p>联系人：{{ $messages->contact }}</p>
                <p>联系电话：{{ $messages->phone }}</p>
                <p>联系地址：{{ $messages->address }}</p>
            </div>
            <a class="btn full" href="{{ url("address/{$messages->id}/edit") }}" style="font-weight: normal;">修改收货地址</a>
        @else
            <a class="btn full" href="{{ url('address/create') }}" style="font-weight: normal;">添加收货地址</a>
        @endif
        <form action="{{ url("order/store") }}" method="post">
            {!! csrf_field() !!}

            <div class="co-remark">
                <label for="remark">备注：</label>
                <textarea name="remark" id="remark"></textarea>
            </div>

            @if(isset($messages))
                <button class="btn full" type="submit">去支付</button>
            @else
                <button class="btn full" disabled type="submit">去支付</button>
            @endif

        </form>
    </div>
@endsection