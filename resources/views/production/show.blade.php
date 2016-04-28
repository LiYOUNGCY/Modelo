@extends('template.template')

@section('title', "{$production->name} - 魔豆树")

@section('body')
    <div class="wrapper m-goods-detail">
        <div class="m-head">
            <div class="m-name">MODELO</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="javascript:history.go(-1);"><span class="fa fa-reply fl"></span></a>
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
        </div>
        <div class="m-goods-info">
            <div class="left fl">
                <p class="goods-name">{{ $production->name }}</p>
                <p class="goods-state mb0">预售中（7-14日后发货）</p>
                <!--<p class="goods-state mb0">库存：30</p>-->
                <!--<p class="goods-state mb0">已下架</p>-->
            </div>
            <div class="right fr">
                <div class="goods-price">
                    ￥{{ $thisColor->price }}
                </div>
                <div class="addtocar">
                    <span class="fa fa-cart-arrow-down" style="font-size: 16px;"></span>
                    <a href="javascript:void(0)">添加到购物车</a>
                </div>
            </div>
            <div class="cf"></div>
        </div>
        <div class="m-goods-color">
            @foreach($colors as $color)
                <div class="color-item">
                    <img class="color-pic" src="{{ asset($color->image->path) }}">
                    @if($color->id == $thisColor->id)
                        <div class="arrow active">
                            <span class="fa fa-sort-up"></span>
                        </div>
                    @else
                        <div class="arrow">
                            <span class="fa fa-sort-up"></span>
                        </div>
                    @endif
                    <div class="color-name">
                        {{ $color->name }}
                    </div>
                </div>
            @endforeach
            <div class="cf"></div>
        </div>
        <div class="m-goods-size">
            <div class="title">
                选择尺码
            </div>
            <div class="size-list">
                @foreach($sizes as $size)
                    <div class="size-item" data-id="{{$size->id}}">{{ $size->name }}</div>
                @endforeach
            </div>
            <div class="goods-explain">
                <div class="item"><a href="size.html">尺码说明</a></div>
                <div class="item"><a href="javascript:showExplain('component')">成分说明</a></div>
                <div class="item"><a href="javascript:showExplain('send')">关于寄送</a></div>
                <div class="item nb"><a href="javascript:showExplain('refund')">关于退换</a></div>
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
                        蓝色背带裤
                        <div class="quantity">
                            <span class="fa fa-minus minus"></span>
                            <div class="num" id="count">1</div>
                            <span class="fa fa-plus plus"></span>
                        </div>
                    </div>
                    <div class="fr right">
                        ￥<span id="price">299</span>
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

        <div class="btn full buy-goods">确认购买</div>
    </div>
    <div class="goods-explain-modal">
        <div class="content-box">
            <div class="top">
                <span class="fa fa-close fr close-explain"></span>
            </div>
            <!--<iframe src="" frameborder="0"></iframe>-->
            <div class="content">
                <img src="img/p1.jpeg">
                <img src="img/p1.jpeg">
                <img src="img/p1.jpeg">
            </div>
        </div>
    </div>
@endsection

@section('moreCss')
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
@endsection

@section('moreScript')
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script>
        var swiperPostcard = new Swiper('.goods-detail-pic', {
            autoplay: 3000,
            autoplayDisableOnInteraction: false,
            loop: true
        });

        calTotal();

        $(".color-item").bind('click', function () {
            var arrow = $(this).find(".arrow");
            if (!arrow.hasClass("active")) {
                $(".color-item .arrow").each(function () {
                    $(this).removeClass("active");
                });
                arrow.addClass("active");
            } else {
                return;
            }
        });

        $(".size-list > .size-item").bind('click', function () {
            if (!$(this).hasClass("active")) {
                $(".size-list .size-item").each(function () {
                    $(this).removeClass("active");
                });
                $(this).addClass("active");
            } else {
                return;
            }
        });


        //    商品数量
        $(".minus").bind('click', function () {
            var count = parseInt($("#count").html());
            if (count == 1) {
                return;
            } else {
                count--;
                $("#count").html(count);
            }
            calTotal();
        });
        $(".plus").bind('click', function () {
            var count = parseInt($("#count").html());
            count++;
            $("#count").html(count);
            calTotal();
        });

        $(".close-explain").bind('click', function () {
            $(".goods-explain-modal").removeClass("active");
        })

        function calTotal() {
            var count = parseInt($("#count").html());
            var price = parseInt($("#price").html());
            var total = count * price;
            $("#total").html(total);
        }
        function showExplain(type) {
//        $(".goods-explain-modal .content-box iframe").attr('src',type + '.html');
            $(".goods-explain-modal").addClass("active");
        }
    </script>
@endsection