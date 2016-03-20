@extends('admin.template.template')

@section('title', '所有订单 - 魔豆树')

@section('header', '所有订单')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <td>#</td>
                    <td>订单号</td>
                    <td>昵称</td>
                    <td>联系人</td>
                    <td>订单状态</td>
                    <td>总价</td>
                    <td>下单时间</td>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr data-id="{{ $order->id }}">
                        <td><a href="{{ url("{$ADMIN}/order/{$order->id}") }}">{{ $order->id }}</a></td>
                        <td>{{ $order->order_no }}</td>
                        <td>{{ $order->nickname }}</td>
                        <td>{{ $order->contact }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->total }}</td>
                        <td>{{ $order->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="text-align: center; font-size: 125%;">
                @if($nowPage > 1)
                    <a href="{{ url("$ADMIN/order?page=".($nowPage-1)) }}">
                        <span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
                    </a>
                @endif
                {{ $nowPage }}/{{ $page }}页
                @if($nowPage < $page)
                    <a href="{{ url("$ADMIN/order?page=".($nowPage+1)) }}">
                        <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
