@extends('template.basic')

@section('css')
    <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/css/sb-admin.css" rel="stylesheet">
    {{--<link href="css/plugins/morris.css" rel="stylesheet">--}}
    <link href="{{ asset('assets') }}/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/admin-style.css">
    @yield('moreCss')
@endsection

@section('body')
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url("{$ADMIN}") }}">魔豆树后台管理系统</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                class="fa fa-user"></i>{{ $USER->nickname or 'NO LOGIN!' }}<b
                                class="caret"></b></a>
                    <ul class="dropdown-menu">
                        {{--<li>--}}
                        {{--<a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>--}}
                        {{--</li>--}}
                        {{--<li class="divider"></li>--}}
                        <li>
                            <a href="#"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo">
                            <i class="fa fa-fw fa-arrows-v"></i> 图片管理
                            <i class="fa fa-fw fa-caret-down"></i>
                        </a>
                        <ul id="demo" class="collapse">
                            <li>
                                <a href="{{ url("{$ADMIN}/image") }}">所有图片</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/image/create") }}">添加图片</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#production">
                            <i class="fa fa-fw fa-arrows-v"></i> 商品管理
                            <i class="fa fa-fw fa-caret-down"></i>
                        </a>
                        <ul id="production" class="collapse">
                            <li>
                                <a href="{{ url("{$ADMIN}/series") }}">所有系列</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/series/create") }}">添加系列</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/production") }}">所有商品</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/production/create") }}">添加商品</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#order">
                            <i class="fa fa-fw fa-arrows-v"></i> 订单管理
                            <i class="fa fa-fw fa-caret-down"></i>
                        </a>
                        <ul id="order" class="collapse">
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}">所有订单</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.orderStatus.unpaid') }}">未支付</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.orderStatus.paid') }}">已支付</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.orderStatus.confirm') }}">待发货</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.orderStatus.deliver') }}">发货中</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.orderStatus.received') }}">已收货</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.orderStatus.reject') }}">申请退换货</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.orderStatus.finish') }}">已完成</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.orderStatus.rejected') }}">已退货</a>
                            </li>
                            <li>
                                <a href="{{ url("{$ADMIN}/order") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.orderStatus.exchange') }}">重新发货</a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#profit">
                            <i class="fa fa-fw fa-arrows-v"></i> 分销管理
                            <i class="fa fa-fw fa-caret-down"></i>
                        </a>
                        <ul id="profit" class="collapse">
                            <li>
                                <a href="{{ url("{$ADMIN}/profit") }}">查看</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#cash">
                            <i class="fa fa-fw fa-arrows-v"></i> 提现记录
                            <i class="fa fa-fw fa-caret-down"></i>
                        </a>
                        <ul id="cash" class="collapse">
                            <li>
                                <a href="{{ url("{$ADMIN}/cash") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.CashStatus.pending') }}">等待审核</a>
                                <a href="{{ url("{$ADMIN}/cash") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.CashStatus.accept') }}">提现成功</a>
                                <a href="{{ url("{$ADMIN}/cash") }}?status={{ \Illuminate\Support\Facades\Config::get('constants.CashStatus.reject') }}">提现失败</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            @yield('header')
                        </h1>
                    </div>
                </div>
                @yield('content')
            </div>
        </div>

    </div>

    <div id="alert-message" class="alert-message">操作成功</div>
@endsection

@section('script')
    <script src="{{ asset('assets') }}/js/bootstrap.min.js"></script>
    <script>
        function showSuccess(message) {
            var tar = $('#alert-message');
            tar.html(message);
            tar.addClass('success');
            setTimeout(function () {
                tar.removeClass('success');
            }, 3000);
        }
    </script>
    @yield('moreScript')
@endsection