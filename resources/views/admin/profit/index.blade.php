@extends('admin.template.template')

@section('title', '所有订单 - 魔豆树')

@section('header', '所有订单')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table id="order" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>订单号</th>
                    <th>客户昵称</th>
                    <th>联系人</th>
                    <th>联系方式</th>
                    <th>总和</th>
                    <th>订单状态</th>
                    <th>最后更新时间</th>
                    <th>下单时间</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>订单号</th>
                    <th>客户昵称</th>
                    <th>联系人</th>
                    <th>联系方式</th>
                    <th>总和</th>
                    <th>订单状态</th>
                    <th>最后更新时间</th>
                    <th>下单时间</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td><a href="{{ url("{$ADMIN}/order/{$order->id}") }}">{{ $order->id }}</a></td>
                        <td>{{ $order->order_no }}</td>
                        <td>{{ $order->nickname }}</td>
                        <td>{{ $order->contact }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->status_name }}</td>
                        <td>{{ $order->last_action_at }}</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection