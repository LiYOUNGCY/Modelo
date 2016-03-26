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
                {{ $production->series }}
                <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
            </div>
        </div>
        <div class="block-w goods-name">
            {{ $production->name }}
            <div class="num-selector">
                <span class="glyphicon glyphicon-minus minus" aria-hidden="true"></span>
                <span class="number" id="count">1</span>
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
                                <div class="item">{{ $color->name }}</div>
                            </li>
                        @else
                            <li class="style-item">
                                <div class="item">{{ $color->name }}</div>
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
                <span class="quantity-text">库存：<span class="quantity" id="quantity">{{ $sizeQuantity }}</span></span>
                售价：<span class="price">￥<span id="price">{{ $colorPrice }}</span></span>
            </div>
        </div>
        <div class="block-w order-info">
            <div class="title">订单信息</div>
            <div class="info-total">
                <div class="picknum">已选购 <span id="num">1</span> 件</div>
                <div class="total">总计：￥<span id="total">{{ $colorPrice }}</span></div>
                <div class="cf"></div>
            </div>

            @if(empty($address))
                <div class="info-address">
                    无收货信息
                    <a href="{{ url('address/create') }}" class="button editaddress" style="text-decoration:none;">
                        添加收获信息
                    </a>
                </div>
            @else
                <div class="info-address">
                    {{ $address->address }}
                    <a href="{{ url("address/{$address->id}/edit") }}" class="button editaddress"
                       style="text-decoration:none;">
                        编辑收获信息
                    </a>
                </div>
            @endif
        </div>

        <a id="addCart" class="button full buy-goods" href="javascript:void(0);" style="text-decoration:none;">
            确认购买
        </a>
    </div>
@endsection

@section('moreScript')
    <script>
        $(document).ready(function () {
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

            calTotal();
            $(".minus").bind('click', function () {
                var count = parseInt($("#count").html());
                if (count > 1) {
                    count--;
                    $("#count").html(count);
                    calTotal();
                }
            });

            $(".plus").bind('click', function () {
                var count = parseInt($("#count").html());
                if (count < parseInt($('#quantity').html())) {
                    count++;
                    $("#count").html(count);
                    calTotal();
                }
            });

            $("body").on('click', ".m-modal", function () {
                $(this).remove();
            });

            $('#addCart').click(function () {
                var color_alias = '{{ $colorAlias }}';
                var production_alias = '{{ $production->alias }}';
                console.log(color_alias);
                console.log(production_alias);
                var count = $('#count').html();
                $('#sizeContainer').find('li').each(function (i, ele) {
                    if ($(ele).hasClass('active')) {
                        var sizeId = $(ele).attr('data-id');
                        $.ajax({
                            url: '{{ url("ajax/get/quantity") }}/' + sizeId,
                            success: function (data) {
                                if (data.success == 0) {
                                    console.log(count);
                                    if (data.quantity >= count) {
                                        console.log(count);
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
            });

//            $(".buy-goods").click(function () {
//                showmodal("请添加收货信息");
//            });

            function calTotal() {
                var count = parseInt($("#count").html());
                var price = parseInt($("#price").html());
                $("#num").html(count);
                var total = count * price;
                $("#total").html(total);
            }

            function showmodal(text) {
                var modal = '' +
                        '<div class="m-modal"><div class="block"><p>' + text + '</p><p style="color: #5c595c">（点击关闭）</p></div></div>';
                $("body").prepend($(modal));
            }
        });
    </script>
@endsection