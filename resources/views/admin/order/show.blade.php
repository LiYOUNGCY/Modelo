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
                    @if(session('warning'))
                        <div class="alert-message alert-danger">
                            {{ session('warning') }}
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert-message alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
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
                        @if(
                        $order->status == \Illuminate\Support\Facades\Config::get('constants.orderStatus.deliver')
                        || $order->status == \Illuminate\Support\Facades\Config::get('constants.orderStatus.received')
                        || $order->status == \Illuminate\Support\Facades\Config::get('constants.orderStatus.finish'))
                            <tr>
                                <td>
                                    <span class="col-md-6 col-xs-3 control-label">快递公司</span>
                                    <div class="col-md-6 col-xs-8" id="order_id">
                                        {{ $order->express }}
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="col-md-6 col-xs-3 control-label">快递单号</span>
                                    <div class="col-md-6 col-xs-8" id="order_id">
                                        {{ $order->tracking_no }}
                                    </div>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">备注</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    <strong>{{ $order->remark }}</strong>
                                </div>
                            </td>
                        </tr>
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
                        <tr>
                            <td>
                                <span class="col-md-6 control-label">合计</span>
                                <span class="col-md-3 col-md-offset-3"><strong>{{ $order->total }}￥</strong></span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span class="col-md-6 col-xs-3 control-label">退货原因</span>
                                <div class="col-md-6 col-xs-8" id="order_id">
                                    {{ $order->result }}
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered table-hover table-striped">
                        @foreach($profits as $profit)
                            <tr>
                                <td>{{ $profit->user->nickname }}</td>
                                <td>{{ $profit->status->name }}</td>
                                <td>{{ $profit->level->name }}</td>
                                <td>{{ $profit->profit }}</td>
                            </tr>
                        @endforeach
                    </table>
                    @if($order->status == Config::get('constants.orderStatus.confirm')
                    || $order->status == Config::get('constants.orderStatus.exchange'))
                        <div class="row">
                            <div class="col col-md-offset-2 col-md-8">
                                <form action="{{ url("{$ADMIN}/order/{$order->id}/deliver") }}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label>快递公司</label>
                                        <input class="form-control" name="express">
                                    </div>
                                    <div class="form-group">
                                        <label>快递单号</label>
                                        <input class="form-control" name="tracking_no">
                                    </div>
                                    <button type="submit" class="btn btn-success"
                                            style="width: 80%; margin: 0 auto; display: block;">
                                        立即发货
                                    </button>
                                </form>
                            </div>
                        </div>
                    @elseif($order->status == \Illuminate\Support\Facades\Config::get('constants.orderStatus.reject'))
                        <div class="row">
                            <div class="col col-md-12">
                                <form action="{{ url("{$ADMIN}/order/{$order->id}/deny") }}" method="post">
                                    {!! csrf_field() !!}
                                    <button class="btn btn-danger" type="submit">拒绝</button>
                                </form>
                                <form action="{{ url("{$ADMIN}/order/{$order->id}/rejected") }}" method="post">
                                    {!! csrf_field() !!}
                                    <button class="btn btn-primary" type="submit">允许退货</button>
                                </form>
                                <form action="{{ url("{$ADMIN}/order/{$order->id}/exchange") }}" method="post">
                                    {!! csrf_field() !!}
                                    <button class="btn btn-primary" type="submit">允许换货</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
