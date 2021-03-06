@extends('template.template')

@section('title', '会员中心 - 魔豆树')

@section('body')
    <div class="wrapper m-user-center">
        <div class="m-user-center-head">
            <a href="{{ url('/') }}"><span class="fa fa-reply fl"></span></a>
            <span class="fa fa-navicon fr show-nav"></span>
            <div class="cf"></div>
        </div>
        <div class="user-info">
            <div class="user-head"><img src="{{ $user->headimgurl }}"></div>
            <div class="user-detail">
                <div class="user-name">{{ $user->nickname }}</div>
                <div class="user-level"><span class="fa fa-diamond"></span> 大魔豆</div>
                <!--<div class="user-level">成为魔豆代言人</div>-->
            </div>
        </div>
        <div class="user-data-list">
            <div class="user-data-item">
                <p>总消费金额</p>
                <span class="num">￥{{ $consume }}</span>
            </div>
            <div class="user-data-item">
                <p>销售额</p>
                <span class="num">￥{{ $sales }}</span>
            </div>
            <div class="user-data-item">
                <p>奖励</p>
                <span class="num">￥{{ $user->total }}</span>
            </div>
            <div class="user-data-item nb">
                <p>可提现</p>
                <span class="num">￥{{ $total }}</span>
            </div>
            <div class="cf"></div>
        </div>
        <div class="user-option-list">
            <div class="user-option-item">
                <div class="item-title">
                    <div class="option-name fl">
                        <span class="fa fa-child"></span>我的豆芽
                    </div>
                    <div class="fr toggle">
                        <span class="fa fa-toggle-down"></span>
                    </div>
                    <div class="cf"></div>
                </div>
                <div class="user-option-content">
                    <ul>
                        <li>
                            <span class="fl"><a href="{{ url('user/children/one') }}">大豆芽</a></span>
                            <span class="fr right">{{ $oneCount }}（{{$oneBuyCount}}）</span>
                        </li>
                        <li>
                            <span class="fl">小豆芽</span>
                            <span class="fr right">{{ $secondCount }}（{{$secondBuyCount}}）</span>
                        </li>
                        <li>
                            <span class="fl">小豆苗</span>
                            <span class="fr right">{{$threeCount}}（{{$threeBuyCount}}）</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="user-option-item">

                <div class="item-title">
                    <div class="option-name fl">
                        <span class="fa fa-cny"></span>我的财富
                    </div>
                    <div class="fr toggle">
                        <span class="fa fa-toggle-down"></span>
                    </div>
                    <div class="cf"></div>
                </div>
                <div class="user-option-content">
                    <ul>
                        {{--<li>--}}
                        {{--<span class="fl">未付款订单金额</span>--}}
                        {{--<span class="fr right">￥{{$unpaid}}</span>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                        {{--<span class="fl">未完成订单金额</span>--}}
                        {{--<span class="fr right">￥{{$unFinish}}</span>--}}
                        {{--</li>--}}
                        <li>
                            <span class="fl">已完成订单金额</span>
                            <span class="fr right">￥{{ $oneAndTwoFinish }}</span>
                        </li>
                        <li>
                            <span class="fl">冻结中奖励金额</span>
                            <span class="fr right">￥{{ $user->freeze_total }}</span>
                        </li>
                        <li>
                            <span class="fl">第三级小豆苗奖励金额</span>
                            <span class="fr right">￥{{ $user->available_three }}</span>
                        </li>
                        <li>
                            <span class="fl">可提现金额</span>
                            <span class="fr right" id="available"
                                  data-id="{{ $total }}">￥{{ $total }}</span>
                        </li>
                        <li>
                            <span class="fl">已提现金额</span>
                            <span class="fr right">￥{{ $user->used_total }}</span>
                        </li>
                        <li>
                            <span class="fr right"><a href="javascript:void(0)">查看如何获得第三级小豆苗金额</a></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="user-option-item">
                <div class="item-title">
                    <div class="option-name fl">
                        <span class="fa fa-angellist"></span>申请提现
                    </div>
                    <div class="fr toggle">
                        <span class="fa fa-toggle-down"></span>
                    </div>
                    <div class="cf"></div>
                </div>
                <div class="user-option-content">
                    <form action="{{ url('draw/store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="tel" name="withdraw" id="withdraw">
                        @if($canGet)
                            <button id="draw" class="btn" type="submit">确认提现</button>
                        @else
                            <button id="draw" class="btn" type="submit" disabled>确认提现</button>
                        @endif
                    </form>
                </div>
            </div>
            <div class="user-option-item">
                <a href="{{ url('draw') }}">
                    <div class="option-name fl">
                        <span class="fa fa-sticky-note"></span>提现记录
                    </div>
                    <div class="fr toggle">
                        <span class="fa fa-toggle-right"></span>
                    </div>
                    <div class="cf"></div>
                </a>
            </div>
        </div>

        <a class="check-QRcode" href="{{ url('qrcode') }}" style="display: block;">
            <div class="inner-box">
                <img src="{{asset('assets/images')}}/qr.png">
                <div class="text">
                    <p class="up">点击查看二维码</p>
                    <p class="down">分享二维码，坐等分成</p>
                </div>
            </div>
        </a>
    </div>
@endsection

@section('moreScript')
    <script>
        $(function () {
            $(".item-title").bind('click', function () {
                var parent = $(this).parent();
                if (parent.hasClass('showdown')) {
                    parent.removeClass('showdown');
                    parent.find('.right-icon').removeClass('down');
                } else {
                    parent.addClass('showdown');
                    parent.find('.right-icon').addClass('down');
                }
            });

            $('#draw').click(function (event) {
                event.preventDefault();
                var cash = $('#withdraw').val();
                if (!isNaN(cash)) {
                    var avaliable = parseFloat($('#available').attr('data-id'));
                    console.log('is num');
                    if (cash > 0 && avaliable != 0.0 && cash <= avaliable) {
                        if (cash < 40) {
                            showModalDialog('至少提现 40 元');
                            return 0;
                        } else if (cash > 200.0) {
                            showModalDialog('一次最多能提现 200 元');
                            return 0;
                        }
                        $.post(BASEURL + 'draw/store', $('form').serialize(), function (data) {
                            console.log(data);
                            if (data.success == 0) {
                                showModalDialog('您的请求已提交成功，请耐心等候审核。');
                                window.location.reload();
                            }
                        });
//                        }
                    } else {
                        showModalDialog('余额不足');
                    }
                } else {
                    console.log('is not num');
                    showModalDialog('请输入数字');
                }
            })
        });
    </script>
@endsection
