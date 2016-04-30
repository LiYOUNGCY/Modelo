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
                <a class="color-item" href="{{ url("production/{$production->alias}/{$color->alias}") }}"
                   style="display: block; color: inherit; text-decoration: none;">
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
                </a>
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
                        {{ $production->name }}
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

        <form id="form" action="{{ url('cart/once/create') }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="production_id" value="{{ $production->id }}">
            <input type="hidden" name="size_id">
            <input type="hidden" name="color_id" value="{{ $thisColor->id }}">
            <input type="hidden" name="quantity">
            <div class="btn full buy-goods" id="buy">确认购买</div>
        </form>
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
        $(document).ready(function () {
            var swiperPostcard = new Swiper('.goods-detail-pic', {
                autoplay: 3000,
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
                var count = parseInt($("#count").html());
                var price = parseInt($("#price").html());
                var total = count * price;
                $("#total").html(total);
            }

            function showExplain(type) {
//        $(".goods-explain-modal .content-box iframe").attr('src',type + '.html');
                $(".goods-explain-modal").addClass("active");
            }

            $('#buy').click(function(){
                $('input[name=quantity]').val(parseInt($('#count').html()));
                $('#form').submit();
            });
        });
    </script>
@endsection