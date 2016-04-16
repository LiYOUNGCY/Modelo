@extends('template.template')

@section('title', "购买{$production->name} - 魔豆树")

@section('body')
    <div class="wrapper">
        <div class="goods-detail-pic">
            <img src="{{ asset($production->cover) }}" alt="{{ $production->cover_name }}">
            <a href="{{ url("production/{$production->alias}") }}">
                <div class="back font16">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                </div>
            </a>
            <div class="set-tab font16">
                {{ $production->series }}<span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
            </div>
        </div>
        <div class="block-w goods-name">
            {{ $production->name }}
            <div class="num-selector">
                <span class="glyphicon glyphicon-minus minus" aria-hidden="true"></span>
                <span class="number" id="count">{{ $sizeQuantity? 1:0 }}</span>
                <span class="glyphicon glyphicon-plus plus" aria-hidden="true"></span>
            </div>
        </div>
        <div class="block-w style-size-block">
            <div class="title">款式和尺码</div>
            <div class="style-block">
                <ul class="style-list">
                    @foreach($colors as $color)
                        @if($color->alias == $colorAlias)
                            <li class="style-item active">
                                <div class="item ">{{ $color->name }}</div>
                            </li>
                        @else
                            <li class="style-item">
                                <a href="{{ url("buy/{$production->alias}/$color->alias") }}">
                                    <div class="item">
                                        {{ $color->name }}
                                    </div>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <div class="size-block">
                <ul id="sizeContainer" class="size-list">
                    @foreach($data[$colorAlias]['size'] as $size)
                        @if($size->id == $sizeId)
                            <li class="size-item active" data-id="{{ $size->id }}">
                                <div class="item">{{ $size->name }}</div>
                            </li>
                        @else
                            <li class="size-item" data-id="{{ $size->id }}">
                                <div class="item">{{ $size->name }}</div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="cf"></div>
            </div>
            <div class="quantity-price">
                <span class="quantity-text">库存：<span class="quantity">{{ $sizeQuantity }}</span></span>
                售价：<span class="price">￥<span id="price">{{ $colorPrice }}</span></span>
            </div>
        </div>

        <div class="block-w order-info">
            <div class="title">订单信息</div>
            <div class="info-total">
                <div class="picknum">已选购 <span id="num"> {{ $sizeQuantity? 1:0 }}</span> 件</div>
                <div class="total">总计：￥<span id="total">{{ $sizeQuantity? $colorPrice: 0 }}</span></div>
                <div class="cf"></div>
            </div>

            @if(empty($address))
                <div class="info-address">
                    无收货信息
                    <a href="{{ url('address/create') }}">
                        <div class="button editaddress">添加收获信息</div>
                    </a>
                </div>
            @else
                <div class="info-address" id="address" data-id="1">
                    {{ $address->address }}
                    <a href="{{ url("address/{$address->id}/edit") }}">
                        <div class="button editaddress">编辑收获信息</div>
                    </a>
                </div>
            @endif
        </div>

        @if($sizeQuantity == 0)
            <button class="btn button full buy-goods" disabled>
                <!--<a href="confirmorder.html">-->
                <a href="javascript:void(0)" id="addCart">
                    确认购买
                </a>
            </button>
        @else
            <button class="btn button full buy-goods">
                <!--<a href="confirmorder.html">-->
                <a href="javascript:void(0)" id="addCart">
                    确认购买
                </a>
            </button>
        @endif

    </div>
@endsection

@section('moreScript')
    <script>
        $(document).ready(function () {
            calTotal();

            var sizes = $('#sizeContainer').find('li');
            sizes.each(function (i, ele) {
                $(ele).click(function () {
                    var sizeId = $(this).attr('data-id');
                    var self = $(this);
                    $.ajax({
                        url: '{{ url("ajax/get/quantity") }}/' + sizeId,
                        success: function (data) {
                            console.log(data);
                            if (data.success == 0) {
                                sizes.each(function (i, ele) {
                                    $(ele).removeClass('active');
                                });
                                self.addClass('active');
                                $('.quantity').html(data.quantity);
                                //刷新数量
                                var count = $('#count');
                                if (parseInt(count.html()) > data.quantity) {
                                    count.html(data.quantity);
                                    calTotal();
                                }
                            }
                        }
                    })
                });
            });

            $(".minus").bind('click', function () {
                var count = parseInt($('#count').html());
                if (count > 1) {
                    count = count - 1;
                    $('#count').html(count);
                    $("#num").html(count);
                    calTotal();
                }
            });

            $(".plus").bind('click', function () {
                var quantity = parseInt($('.quantity').html());
                var count = parseInt($('#count').html());
                if (count < quantity) {
                    count = count + 1;
                    $('#count').html(count);
                    $('#num').html(count);
                    calTotal();
                }
            });

//        复制这个事件到下面
//        $("body").on('click', ".m-modal",function () {
//            $(this).remove();
//        });

            $("#addCart").click(function () {
                var flag = $('#address').attr('data-id');
                if(flag == null || flag == 'undefined') {
                    showModalDialog("请添加收货信息");
                } else {
                    var color_alias = '{{ $colorAlias }}';
                    var production_alias = '{{ $production->alias }}';
                    var count = $('#count').html();
                    $('#sizeContainer').find('li').each(function (i, ele) {
                        if ($(ele).hasClass('active')) {
                            var sizeId = $(ele).attr('data-id');
                            $.ajax({
                                url: '{{ url("ajax/get/quantity") }}/' + sizeId,
                                success: function (data) {
                                    if (data.success == 0) {
                                        if (data.quantity >= count) {
                                            window.location.href = '{{ url('cart/update') }}?p='
                                                    + production_alias + '&&c=' + color_alias + '&&s='
                                                    + sizeId + '&&q=' + count;
                                        }
                                    }
                                }
                            });
                            return 0;
                        }
                    });
                }
            });

            function calTotal() {
                var count = parseInt($("#count").html());
                var price = parseInt($("#price").html());
                var total = count * price;
                $("#total").html(total);
            }

            function showModalDialog(text) {
                var modal = '' +
                        '<div class="m-modal"><div class="block"><p>' + text + '</p><p style="color: #5c595c">（点击关闭）</p></div></div>';
                $("body").prepend($(modal));
//          复制到这里
                $("body").on('click', ".m-modal", function () {
                    $(this).remove();
                });
            }
        })
    </script>
@endsection
