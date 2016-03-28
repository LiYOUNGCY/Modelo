@extends('admin.template.template')

@section('title', '订单详情 - 魔豆树')

@section('header', '订单详情')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">订单</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped">
                        <tbody>
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">#</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    {{ $order->id }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">订单号</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    {{ $order->order_no }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">昵称</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    {{ $order->nickname }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">联系人</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    {{ $order->contact }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">手机号码</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    {{ $order->phone }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">收货地址</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    {{ $order->address }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">订单状态</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    {{ $order->status_name }}
                                </div>
                            </td>
                        </tr>
                        {{--<tr>--}}
                        {{--<td>--}}
                        {{--<span class="col-md-6 col-xs-3 control-label">备注</span>--}}
                        {{--<div class="col-md-6 col-xs-8" id="order_id">--}}
                        {{--{{ $order->comment }}--}}
                        {{--</div>--}}
                        {{--</td>--}}
                        {{--</tr>--}}
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">创建时间</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    {{ $order->created_at }}
                                </div>
                            </td>
                        </tr>


                        {{--order item--}}
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">订单详情</span>
                            </td>
                        </tr>
                        @foreach($orderItems as $item)
                            <tr>
                                <td>
                                    <span class="col-md-6 col-xs-3 control-label"></span>
                                    <div class="col-md-6 col-xs-8" id="order_id">
                                        <div class="row">
                                            <span class="col col-md-6">
                                                {{ $item->production_name }}
                                                ({{ $item->color_name }})
                                                ({{ $item->size_name }})
                                            </span>
                                            <span class="col col-md-3">X{{ $item->quantity }}</span>
                                            <span class="col col-md-3">{{ $item->price }}￥</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>
                                <span class="col-md-6 control-label">合计</span>
                                <span class="col-md-3 col-md-offset-3"><strong>{{ $order->total }}￥</strong></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    @if($order->status == Config::get('constants.orderStatus.confirm'))
                        <div class="row">
                            <div class="col col-md-offset-2 col-md-8">
                                <form action="{{ url("{$ADMIN}/order/{$order->id}/deliver") }}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label>快递公司</label>
                                        <input class="form-control" name="deliver_name">
                                    </div>
                                    <div class="form-group">
                                        <label>快递单号</label>
                                        <input class="form-control" name="deliver_no">
                                    </div>
                                    <button type="submit" class="btn btn-success"
                                            style="width: 80%; margin: 0 auto; display: block;">
                                        立即发货
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection