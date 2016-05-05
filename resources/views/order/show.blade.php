@extends('template.template')

@section('title', "订单详情 - 魔豆树")

@section('body')
    <div class="wrapper">
        <div class="m-head">
            <div class="m-name">In Mods' Code</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url("order/{$order->id}") }}"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-nav">
                    <span class="fa fa-navicon"></span>
                </div>
            </div>
        </div>

        <div class="m-title-usual">
            订单详情
        </div>

        <div class="block-w order-detail">
            <div class="line">
                <label>订单号</label>
                <div class="field">{{ $order->order_no }}</div>
            </div>
            <div class="line">
                <label>时间</label>
                <div class="field">{{ $order->created_at }}</div>
            </div>
            <div class="line">
                <label>商品</label>
                <div class="field">
                    <p>{{ $orderItem->production_name }}</p>
                    <div class="pic" style="background-image: url({{ asset($orderItem->cover) }})"></div>
                </div>
            </div>
            <div class="line">
                <label>详细</label>
                <div class="field">{{ $orderItem->color_name }}/{{ $orderItem->size_name }}</div>
            </div>
            <div class="line">
                <label>数量</label>
                <div class="field">1 件</div>
            </div>
            <div class="line">
                <label>联系人</label>
                <div class="field">{{ $order->contact }}</div>
            </div>
            <div class="line">
                <label>联系电话</label>
                <div class="field">{{ $order->phone }}</div>
            </div>
            <div class="line mb0">
                <label>联系地址</label>
                <div class="field">
                    <p>{{ $order->address }}</p>
                </div>
            </div>
        </div>
        <div class="block-w order-detail">
            <div class="line mb0">
                <label>备注</label>
                <div class="field">
                    <p>
                        {{ $order->remark }}
                    </p>
                </div>
            </div>
        </div>
        <div class="block-w order-detail">
            <div class="line mb0">
                <label>订单状态</label>
                <div class="field state">
                    {{ $order->status->name }}
                </div>
            </div>
        </div>
        {{--提示与取消订单按钮一起显示--}}
        <div class="order-tips">
            注：付款后15分钟内可取消订单，将全额退款。
        </div>

        @if($order->status_id == \Illuminate\Support\Facades\Config::get('constants.orderStatus.paid'))
            <div class="btn order-option" id="cancel">
                取消订单
            </div>
        @elseif($order->status_id == \Illuminate\Support\Facades\Config::get('constants.order.deliver'))
            <div class="btn order-option">
                确认收货
            </div>
        @elseif($order->status_id == \Illuminate\Support\Facades\Config::get('constants.orderStatus.received'))
            <div class="btn order-option">
                申请售后
            </div>
        @endif
    </div>
@endsection

@section('moreScript')
    <script>
        $(function () {
            $('#cancel').click(function () {
                $.ajax({
                });
            });
        });
    </script>
@endsection