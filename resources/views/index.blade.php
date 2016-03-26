@extends('template.template')

@section('title', '首页 - 魔豆树')

@section('body')
    <div class="wrapper">
        <div class="m-showcard">
            <img src="{{ asset('images/logo.jpg') }}">
            <div class="shade"></div>
        </div>
        <div class="block-w notice">
            <p>魔豆树把互联网分销思维融入到传统时尚行业，打破中间环节和费用，直接让利给客户。魔豆树更打破传统分销的等级制度，实现分佣模式的升级，裂变更易，潜力无限。
                您所再的等级不影响您的分佣，您真正为自己种树乘凉！买买买不用剁手，赚赚赚不再是梦。</p>
        </div>

        @foreach($productions as $production)
            <div class="goods-item">
                <a href="{{ url("production/{$production->alias}") }}">
                    <img src="{{ asset($production->cover) }}" alt="{{ $production->name }}">
                </a>
            </div>
        @endforeach
        <div class="footer">
            <ul class="m-nav">
                <a href="">
                    <li class="nav-item w33 active">
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span> 首页
                    </li>
                </a>
                <a href="">
                    <li class="nav-item w33">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 会员中心
                    </li>
                </a>
                <a href="">
                    <li class="nav-item w33">
                        <span class="glyphicon glyphicon-bell" aria-hidden="true"></span> 推广
                    </li>
                </a>
            </ul>
        </div>
    </div>
@endsection