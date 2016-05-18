@extends('admin.template.template')

@section('title', '用户详情 - 魔豆树')

@section('header', '用户详情')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <td>#</td>
                    <td>{{ $user->id }}</td>
                </tr>
                <tr>
                    <td>昵称：</td>
                    <td>{{ $user->nickname }}</td>
                </tr>
                <tr>
                    <td>性别：</td>
                    <td>{{ $user->sex == 1 ? '男' : '女'}}</td>
                </tr>
                <tr>
                    <td>魔豆</td>
                    <td>{{ $user->qrcode ? '是':'否' }}</td>
                </tr>
                <tr>
                    <td>推荐人</td>
                    <td>{{ $user->referee }}</td>
                </tr>
                <tr>
                    <td>冻结金额</td>
                    <td>{{ $user->freeze_total }}</td>
                </tr>
                <tr>
                    <td>三级冻结金额</td>
                    <td>{{ $user->freeze_three }}</td>
                </tr>
                <tr>
                    <td>三级可用金额</td>
                    <td>{{ $user->available_three }}</td>
                </tr>
                <tr>
                    <td><strong>一二级可用金额</strong></td>
                    <td><strong>{{ $user->available_total }}</strong></td>
                </tr>
                <tr>
                    <td>总可用金额</td>
                    <td>{{ $user->available_three + $user->available_total }}</td>
                </tr>
                <tr>
                    <td>已提现</td>
                    <td>{{ $user->used_total }}</td>
                </tr>
                <tr>
                    <td>总金额</td>
                    <td>{{ $user->total }}</td>
                </tr>
                <tr>
                    <td>大豆芽</td>
                    <td>{{ $oneCount }}（{{$oneBuyCount}}）</td>
                </tr>
                <tr>
                    <td>小豆芽</td>
                    <td>{{ $secondCount }}（{{$secondBuyCount}}）</td>
                </tr>
                <tr>
                    <td>小豆苗</td>
                    <td>{{$threeCount}}（{{$threeBuyCount}}）</td>
                </tr>
                <tr>
                    <td>=====================</td>
                </tr>
                <tr>
                    <td>未付款订单金额</td>
                    <td>￥{{$unpaid}}</td>
                </tr>
                <tr>
                    <td>未完成订单金额</td>
                    <td>￥{{$unFinish}}</td>
                </tr>
                <tr>
                    <td>已完成订单金额</td>
                    <td>￥{{ $sales }}</td>
                </tr>
                <tr>
                    <td>冻结中奖励金额</td>
                    <td>￥{{$user->freeze_total}}</td>
                </tr>
                <tr>
                    <td>第三级小豆芽奖励金额</td>
                    <td>￥{{ $user->freeze_three }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection