@extends('template.template')

@section('title', '个人中心 - 魔豆树')

@section('body')

    <div class="wrapper">
        <div class="user-card">
            <div class="user-info">
                <div class="user-head"><img src="img/head.jpg"></div>
                <div class="user-detail">
                    <p>昵称：{{ $user->nickname }}</p>
                    <p>魔豆ID：{{ $user->id }}</p>
                    <p>会员状态：普通用户 <a href="javascript:void(0)">（点击成为代言人）</a></p>
                    <p>积分：0</p>
                    <p class="mb0">推荐人：{{ $user->referee }}</p>
                </div>
            </div>
            <div class="user-achievement">
                <div class="sales">销售额：{{ $sales }}</div>
                <div class="reward">奖励：{{ $user->total }}</div>
            </div>
        </div>
        <div class="user-item-list">
            <div class="item">
                <div class="line">
                    <span class="fl">查看我的二维码</span>
                    <span class="glyphicon glyphicon-chevron-right fr right-icon" aria-hidden="true"></span>
                </div>
            </div>
            <div class="item">
                <div class="line item-title">
                    <span class="fl">我的小豆芽 <span class="left-num">【{{ $count }}（{{ $buyCount }}）】</span></span>
                    <span class="glyphicon glyphicon-chevron-down fr right-icon" aria-hidden="true"></span>
                </div>
                <div class="grade">
                    <div class="grade-box">
                        <div class="box">
                            <p>一级小豆芽</p>
                            <p>{{ $oneCount }}（{{ $oneBuyCount }}）</p>
                        </div>
                    </div>
                    <div class="grade-box">
                        <div class="box">
                            <p>二级小豆芽</p>
                            <p>{{ $secondCount }}（{{ $secondBuyCount }}）</p>
                        </div>
                    </div>
                    <div class="grade-box">
                        <div class="box disable">
                            <p>三级小豆芽</p>
                            <p>{{ $threeCount }}（{{ $threeBuyCount }}）</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="line item-title">
                    <span class="fl">我的财富</span>
                    <span class="glyphicon glyphicon-chevron-down fr right-icon" aria-hidden="true"></span>
                </div>
                <div class="line">
                    <span class="fl">未付款订单金额</span>
                    <span class="fr right-num">￥{{ $unpaid }}</span>
                </div>
                <div class="line">
                    <span class="fl">未完成订单金额</span>
                    <span class="fr right-num">￥{{ $unFinish }}</span>
                </div>
                <div class="line">
                    <span class="fl">已完成订单金额</span>
                    <span class="fr right-num">￥{{ $sales }}</span>
                </div>
                <div class="line">
                    <span class="fl">冻结中奖励金额</span>
                    <span class="fr right-num">￥{{ $user->freeze_total }}</span>
                </div>
                <div class="line">
                    <span class="fl">第三级小豆芽奖励金额</span>
                    <span class="fr right-num">￥{{ $user->freeze_three }}</span>
                </div>
                <div class="line">
                    <span class="fl">可提现金额</span>
                    <span class="fr right-num">￥{{ $user->available_total }}</span>
                </div>
                <div class="line">
                    <span class="fl">已提现金额</span>
                    <span class="fr right-num">￥{{ $user->used_total }}</span>
                </div>
                <div class="line">
                <span class="fr">
                    <b><a href="javascript:void(0)">查看如何获得第三级小豆芽金额</a></b>
                </span>
                </div>
            </div>
            <div class="item">
                <div class="line">
                    <span class="fl">申请提现</span>
                    <span class="glyphicon glyphicon-chevron-right fr right-icon" aria-hidden="true"></span>
                </div>
            </div>
        </div>

        <div class="bottom-sign">
            - Modelo 魔豆树 -
        </div>
        <div class="footer">
            <ul class="m-nav">
                <a href=""><li class="nav-item w33">
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span> 首页
                    </li></a>
                <a href=""><li class="nav-item w33 active">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 会员中心
                    </li></a>
                <a href=""><li class="nav-item w33">
                        <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> 订单
                    </li></a>
            </ul>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(function(){
            $(".item-title").bind('click', function () {
                var parent = $(this).parent();
                if(parent.hasClass('showdown')){
                    parent.removeClass('showdown');
                    parent.find('.right-icon').removeClass('down');
                }else{
                    parent.addClass('showdown');
                    parent.find('.right-icon').addClass('down');
                }
            })
        })
    </script>
@endsection
