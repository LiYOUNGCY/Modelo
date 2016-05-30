@extends('template.template')

@section('title', "{$production->name} - 魔豆树")

@section('body')
    <div class="wrapper m-goods-detail">
        <div class="m-head">
            <div class="m-name">In Mods' Code</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url("production") }}"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-shopping-car">
                    <span class="fa fa-shopping-cart"></span>
                </div>
            </div>
        </div>

        <div class="swiper-container goods-detail-pic">
            <div class="swiper-wrapper">
                @foreach($images as $image)
                    <div class="swiper-slide">
                        <img src="{{asset($image->image)}}">
                    </div>
                @endforeach
            </div>
            <div class="tips">
                <span class="fa fa-angle-double-left"></span>
                <span class="fa fa-angle-double-left" style="color:#FFFFFF;"></span>
                <span class="fa fa-angle-double-left"></span>
            </div>
        </div>
        <div class="m-goods-info">
            <div class="left fl">
                <p class="goods-name">{{ $production->name }}</p>
                <p class="goods-state mb0">3 天后开放购买</p>
                {{--<p class="goods-state mb0">库存：30</p>--}}
                {{--<p class="goods-state mb0">已下架</p>--}}
            </div>
            <div class="right fr">
                <div class="goods-price" style="font-size: 14px;;">
                    {{--￥{{ $thisColor->price }}--}}
                    ￥???
                </div>
                <div class="addtocar" style="display: none;">
                    <span class="fa fa-cart-arrow-down" style="font-size: 16px;"></span>
                    <a href="javascript:void(0);" id="addToCart">添加到购物车</a>
                </div>
            </div>
            <div class="cf"></div>
        </div>
        <div class="m-goods-color">
            @foreach($colors as $color)
                @if($color->id == $thisColor->id)
                    <div class="color-item" href="{{ url("production/{$production->id}/{$color->id}") }}"
                         style="display: block; color: inherit; text-decoration: none;">
                        <img class="color-pic" src="{{ asset($color->image->path) }}">

                        <div class="arrow active">
                            <span class="fa fa-sort-up"></span>
                        </div>
                        <div class="color-name">
                            {{ $color->name }}
                        </div>
                    </div>
                @else
                    <a class="color-item" href="{{ url("production/{$production->id}/{$color->id}") }}"
                       style="display: block; color: inherit; text-decoration: none;">
                        <img class="color-pic" src="{{ asset($color->image->path) }}">

                        <div class="arrow">
                            <span class="fa fa-sort-up"></span>
                        </div>
                        <div class="color-name">
                            {{ $color->name }}
                        </div>
                    </a>
                @endif
            @endforeach
            <div class="cf"></div>
        </div>
        <div class="m-goods-size">
            <div class="title">
                选择尺码
            </div>
            <div class="size-list">
                <?php $i = 0; ?>
                @foreach($sizes as $size)
                    <div class="size-item <?php if ($i == 0) echo 'nb';?>"
                         data-id="{{$size->id}}">{{ $size->name }}</div>
                    <?php $i++;?>
                @endforeach

                <div class="cf"></div>
            </div>
            <div class="goods-explain">
                <div class="item"><a id="size" href="javascript:void(0);">尺码说明</a></div>
                <div class="item"><a id="component" href="javascript:void(0);">成分说明</a></div>
                <div class="item"><a id="send" href="javascript:void(0);">关于寄送</a></div>
                <div class="item nb"><a id="reject" href="javascript:void(0)">关于退换</a></div>
                <div class="cf"></div>
            </div>
        </div>
        <div class="goods-final">
            <div style="width: 95%;margin: 0 auto;">
                <div class="title">
                    数量 & 总价
                </div>
                <div class="goods-quantity">
                    <div class="fl left">
                        {{ $production->name }}
                        <div class="quantity">
                            <span class="fa fa-minus minus"></span>
                            <div class="num" id="count">1</div>
                            <span class="fa fa-plus plus"></span>
                        </div>
                    </div>
                    <div class="fr right">
                        {{--￥<span id="price">{{ $thisColor->price }}</span>--}}
                        ￥<span id="price">???</span>
                    </div>

                    <div class="cf"></div>
                </div>
                <div class="fr goods-total">
                    总计：￥<span id="total"></span>
                </div>
                <div class="cf"></div>
            </div>
        </div>
        <div class="pb40"></div>

        <form id="form" action="{{ url('cart/once/create') }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="production_id" value="{{ $production->id }}">
            <input type="hidden" name="size_id">
            <input type="hidden" name="color_id" value="{{ $thisColor->id }}">
            <input type="hidden" name="quantity">
            {{--<div class="btn full buy-goods" id="buy">确认购买</div>--}}
            <div class="btn full buy-goods">确认购买</div>
        </form>
    </div>
@endsection

@section('moreCss')
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
@endsection

@section('moreScript')
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var swiperPostcard = new Swiper('.goods-detail-pic', {
                autoplay: 7000,
                autoplayDisableOnInteraction: false,
                loop: true
            });

            var maxCount = 1;

            function getQuantity(size) {
                var tar = $(size);
                var size_id = tar.attr('data-id');

                $.ajax({
                    url: BASEURL + 'ajax/get/quantity/' + size_id,
                    success: function (data) {
                        console.log(data);
                        if (data.success == 0) {
                            $('input[name=size_id]').val(size_id);
                            maxCount = data.quantity;
                            $('.size-item').each(function (i, ele) {
                                $(ele).removeClass('active');
                            });
                            tar.addClass('active');
                            $('#count').html(1);
                            calTotal();
                        }
                    }
                });
            }

            getQuantity($('.size-item')[0]);

            $('.size-item').each(function (i, ele) {
                $(ele).click(function () {
                    var tar = $(this);
                    getQuantity(tar);
                });
            });

            //    商品数量
            $(".minus").bind('click', function () {
                var count = parseInt($("#count").html());
                if (count > 1) {
                    $("#count").html(count - 1);
                    calTotal();
                }
            });

            $(".plus").bind('click', function () {
                var count = parseInt($("#count").html());
                if (count < maxCount) {
                    $("#count").html(count + 1);
                    calTotal();
                }
            });

            $(".close-explain").bind('click', function () {
                $(".goods-explain-modal").removeClass("active");
            });

            function calTotal() {
//                var count = parseInt($("#count").html());
//                var price = parseInt($("#price").html());
//                var total = count * price;
//                $("#total").html(total);
                $("#total").html('???');
            }

            function showExplain(type) {
                var content = '' +
                        '<div class="goods-explain-modal">' +
                        '<img src="' + type + '">' +
                        '</div>' +
                        '<div class="m-shade" id="explain-shade"></div>';
                $("body").prepend(content);

                $(".goods-explain-modal").click(function () {
                    $("body").find(".goods-explain-modal").remove();
                    $("body").find(".m-shade").remove();
                })
                $("#explain-shade").click(function () {
                    $("body").find(".goods-explain-modal").remove();
                    $("body").find(".m-shade").remove();
                });
            }

            function showSend() {
                var content = '' +
                        '<div class="goods-explain-modal">' +
                        '<div  style="padding: 1em; background: #EEE; line-height: 125%; font-size: 16px;">' +
                        '<p>In Mods’ Code 每一件单品都是采用原创设计，手工精工制作，保证匠心品质。</p>' +
                        '<p>我们会在收到订单后7-10天内，为魔豆们精心制作每一件单品并安排发货，保证品质。发货7天后，系统默认收货。</p>' +
                        '<p>具体发货时间可联系客服，以客服答复为准！本店默认顺丰快递需要其他快递请联系客服。包邮范围为中国大陆地区，海外及港澳台客户请联系客服协商运费事宜。</p>' +
                        '</div>' +
                        '</div>' +
                        '<div class="m-shade" id="explain-shade"></div>';
                $("body").prepend(content);

                $(".goods-explain-modal").click(function () {
                    $("body").find(".goods-explain-modal").remove();
                    $("body").find(".m-shade").remove();
                })
                $("#explain-shade").click(function () {
                    $("body").find(".goods-explain-modal").remove();
                    $("body").find(".m-shade").remove();
                })
            }

            function showReject() {
                var content = '' +
                        '<div class="goods-explain-modal">' +
                        '<div  style="padding: 1em; background: #EEE; line-height: 125%; font-size: 16px;">' +
                        '<p>买买买也烧脑，我们都懂，贴心为你提供优厚的退换条款。让你购买放心，退换省心。</p>' +
                        '<p>收货后的3天内，你可以无条件申请换货，客服会联系你处理退换货。你需在收货后7天内寄回货品。</p>' +
                        '<p>在保持产品原样，不影响第二次销售的情况下，客服安排为你退换货。</p>' +
                        '<p><strong>因质量原因退换货，魔豆树承担退货运费；因其他原因退换货，买家承担运费。</strong></p>' +
                        '<p>各位魔豆请注意：</p>' +
                        '<p>如你选择退货，将会失去魔豆资格，二维码和佣金会被冻结，无法提现。</p>' +
                        '<p>直到你再次成功购买任意商品，订单完成，方可提现你的奖励财富。</p>' +
                        '</div>' +
                        '</div>' +
                        '<div class="m-shade" id="explain-shade"></div>';
                $("body").prepend(content);

                $(".goods-explain-modal").click(function () {
                    $("body").find(".goods-explain-modal").remove();
                    $("body").find(".m-shade").remove();
                })
                $("#explain-shade").click(function () {
                    $("body").find(".goods-explain-modal").remove();
                    $("body").find(".m-shade").remove();
                });
            }

            $('#buy').click(function () {
                $('input[name=quantity]').val(parseInt($('#count').html()));
                $('#form').submit();
            });

            $('#addToCart').click(function (event) {
                event.preventDefault();

                var pid = $('input[name=production_id]').val();
                var sid = $('input[name=size_id]').val();
                var cid = $('input[name=color_id]').val();
                var qty = parseInt($('#count').html());

                $.ajax({
                    url: BASEURL + 'cart/shopping/create',
                    data: {
                        pid: pid,
                        sid: sid,
                        cid: cid,
                        qty: qty
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success == 0) {
                            showModalDialog('添加成功');
                        }
                    }
                });
            });

            $('#size').click(function () {
                showExplain('{{ url($production->size_info->path) }}');
            });

            $('#send').click(function () {
                showSend();
            });

            $('#reject').click(function () {
                showReject();
            });

            $('#component').click(function () {
                showExplain('{{ url($production->fabric_info->path) }}');
            });
        });
    </script>
@endsection