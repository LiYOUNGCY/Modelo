@extends('template.template')

@section('title', "订单详情 - 魔豆树")

@section('body')
    <div class="wrapper">
        <div class="m-head">
            <div class="m-name">In Mods' Code</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url("order") }}"><span class="fa fa-reply fl"></span></a>
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
                    <a href="{{ url('production') }}/{{ $link[$orderItem] }}"><p>{{ $orderItem->production_name }}</p></a>
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
                    @if($order->status_id == \Illuminate\Support\Facades\Config::get('constants.orderStatus.deliver'))
                        <span class="fb">（{{ $order->express }}：{{ $order->tracking_no }}）</span>
                    @endif
                </div>
            </div>
        </div>
        {{--提示与取消订单按钮一起显示--}}
        @if($order->status_id == \Illuminate\Support\Facades\Config::get('constants.orderStatus.paid'))
            <div class="order-tips">
                注：付款后15分钟内可取消订单，将全额退款。
            </div>
        @endif

        @if($order->status_id == \Illuminate\Support\Facades\Config::get('constants.orderStatus.paid'))
            <form id="cancelForm" action="{{ url("order/{$encodeOrderNo}/cancel") }}" method="post">
                {!! csrf_field() !!}
                <button id="cancel" class="btn order-option" type="button">
                    取消订单
                </button>
            </form>
        @elseif($order->status_id == \Illuminate\Support\Facades\Config::get('constants.orderStatus.deliver'))
            <form action="{{ url("order/{$encodeOrderNo}/receive") }}" method="post">
                {!! csrf_field() !!}
                <button id="receive" class="btn order-option" type="submit">
                    确认收货
                </button>
            </form>
        @elseif($order->status_id == \Illuminate\Support\Facades\Config::get('constants.orderStatus.received'))
            <form action="{{ url("order/{$encodeOrderNo}/reject") }}" method="post" id="rejectForm">
                {!! csrf_field() !!}
                <input type="hidden" name="result" id="result">
                <button id="reject" class="btn order-option" type="button">
                    申请售后(退货或换货)
                </button>
            </form>
        @endif

        <div class="m-shade" id="cs-shade" style="display: none;"></div>
        <div class="cs-remark" id="model" style="display: none;">
            <div class="title">申请理由</div>
            <textarea name="cs-remark" id="cs-remark" placeholder="请注明退货还是换货，及退换理由"></textarea>
            <button id="sub" class="btn" type="button">提交</button>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(function () {
            $('#cancel').click(function (event) {
                event.preventDefault();
                if (confirm('您确定取消订单？')) {
                    $('#cancelForm').submit();
                }
            });

            $('#reject').click(function(){
                $('#cs-shade').show();
                $('#model').show();
            });

            $('#cs-shade').bind('click', function(){
                $('#cs-shade').hide();
                $('#model').hide();
            });

            $('#sub').click(function(){
                $('#result').val($('#cs-remark').val());
                $('#rejectForm').submit();
            });
        });
    </script>
@endsection