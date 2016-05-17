//取消微信后退
document.addEventListener('WeixinJSBridgeReady',function onBridgeReady() {
    WeixinJSBridge.call("hideToolbar");
    WeixinJSBridge.call("hideOptionMenu");
});


$(function () {
    //显示分类
    $(".m-bottom-bar .col").bind('click', function () {
        var allPopup = $(this).parent().find('.col .popup');
        var thisPopup = $(this).find('.popup');
        if (thisPopup.hasClass('hide')) {
            allPopup.addClass('hide');
            thisPopup.removeClass('hide');
        } else {
            allPopup.addClass('hide');
        }
    });

    var cart = [];

    function getCart() {
        $.ajax({
            url: BASEURL + 'cart/shopping/show',
            type: 'get',
            success: function (data) {
                if (data.success == 0) {
                    var page = $('.wrapper');
                    cart = data.data;
                    var length = Object.keys(cart).length;
                    if (length != 0) {
                        var content = '';

                        for (var key in cart) {
                            content += '<div class="car-goods" id="car-goods-1">' +
                                '<div class="car-goods-name">' +
                                '<span class="fl">' +
                                '<div class="m-checkbox">' +
                                '<input id="p' + cart[key].id + '"name="flag[]" type="checkbox" value="' + key + '" />' +
                                '<label for="p' + cart[key].id + '"></label>' +
                                '</div>' +
                                '<a href="' + BASEURL + 'production/' + cart[key].options.production_alias + '">' + cart[key].name + '</a></span>' +
                                '<span class="fr remove-goods" data-id="' + key + '">移除</span>' +
                                '</div>' +
                                '<div class="car-goods-detail">' +
                                '<a href="' + BASEURL + 'production/' + cart[key].options.production_alias + '"><div class="goods-pic" style="background-image: url(' + BASEURL + cart[key].options.cover + ')"></div></a>' +
                                '<div class="goods-info">' +
                                '<p>￥<span class="price">' + cart[key].price + '</span></p>' +
                                '<p> ' + cart[key].options.color_name + ' ' + cart[key].options.size_name + '</p>' +
                                '<div class="quantity">' +
                                '<span class="fa fa-minus car-minus"></span>' +
                                '<div class="num" id="count">' + cart[key].qty + '</div>' +
                                '<span class="fa fa-plus car-plus" data-id="' + cart[key].options.size_id + '"></span>' +
                                '</div>' +
                                '<input type="hidden" name="' + key + '" value="' + cart[key].qty + '">' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        }

                        //绘制购物车，绑定事件
                        var carContent = '<div class="m-car">' +
                            '<form action="' + BASEURL + 'cart/buy" method="post" id="cartForm">' +
                            '<div class="car-goods-list">' +
                            '<input type="hidden" name="_token" value="' + _token + '">' +
                            content +
                            '</div>' +
                            '<div class="car-final">' +
                            '<div class="m-checkbox">' +
                            '<input type="checkbox" name="checkAll" id="checkAll">' +
                            '<label for="checkAll"></label>' +
                            '</div>全选' +
                            '<div class="fr">' +
                            '<div class="car-total">总计：￥<span class="total">0</span></div>' +
                            '<div class="settlement">去结算</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>' +
                            '</div>' +
                            '<div class="m-shade" id="car-shade"></div>';


                        page.prepend(carContent);
                        page.addClass('hascar');

                        //绑定删除事件
                        $('.remove-goods').each(function (i, ele) {
                            $(ele).click(function () {
                                var self = $(this);
                                var rowId = $(this).attr('data-id');

                                $.ajax({
                                    url: BASEURL + 'cart/shopping/' + rowId,
                                    data: {
                                        _method: 'DELETE'
                                    },
                                    success: function (data) {
                                        if (data.success == 0) {
                                            self.parent().parent().remove();

                                            page.find('.m-car').remove();
                                            page.find('.car-shade').remove();
                                            getCart();
                                        }
                                    }
                                });
                            });
                        });

                        //默认全选
                        $('.m-car input[type=checkbox]').each(function (i, ele) {
                            $(ele).prop('checked', true);
                            calCarTotal();
                        });

                        //绑定 全选事件
                        $('#checkAll').click(function () {
                            $("input[type=checkbox]:checkbox").prop("checked", this.checked);
                            calCarTotal();
                        });

                        $('input[name=flag]').each(function (i, ele) {
                            $(ele).click(function () {
                                calCarTotal();

                                $('#checkAll').prop('checked', $('input[name=flag]:checked').length == $('input[name=flag]').length)
                            });
                        });

                        //绑定添加数量
                        // $('.car-plus').each(function (i, ele) {
                        //     $(ele).click(function(){
                        //         var size_id = $(this).attr('data-id');
                        //         var maxCount = getQuantity(size_id);
                        //         var count = $(this).prev();
                        //
                        //         if(parseInt(count.html()) < maxCount) {
                        //             var quantity = parseInt(count.html()) + 1;
                        //             count.html(quantity);
                        //             count.parent().next().val(quantity);
                        //             calCarTotal();
                        //         }
                        //     });
                        // });

                        $('.car-plus').each(function (i, ele) {
                            $(ele).click(function () {
                                var size_id = $(this).attr('data-id');
                                var count = $(this).prev();

                                var quantity = parseInt(count.html()) + 1;
                                count.html(quantity);
				calCarTotal();

                                $.ajax({
                                    url: BASEURL + 'ajax/get/quantity/' + size_id,
                                    success: function (data) {
                                        if (data.success == 0) {
                                            var result = data.quantity;
                                            if (quantity >= result) {
                                                quantity = result;
                                                count.html(quantity);
						calCarTotal();
                                            }
                                        }
                                    }
                                });
                            });
                        });

                        //绑定减少事件
                        $('.car-minus').each(function (i, ele) {
                            $(ele).click(function () {
                                var count = $(this).next();

                                if (parseInt(count.html()) > 1) {
                                    var quantity = parseInt(count.html()) - 1;
                                    count.html(quantity);
                                    count.parent().next().val(quantity);
                                    calCarTotal();
                                }
                            });
                        });

                        //提交事件
                        $('.m-car .settlement').click(function () {
                            $('#cartForm').submit();
                        });
                    } else {
                        var carContent = '<div class="m-car"><div class="nogoods">购物车空无一物</div></div><div class="m-shade" id="car-shade"></div>';

                        page.prepend(carContent);
                        page.addClass('hascar');
                    }
                    //点击遮罩隐藏购物车事件
                    $('#car-shade').click(function () {
                        var page = $('.wrapper');
                        page.find('.m-car').remove();
                        page.find('.m-shade').remove();
                        page.removeClass('hascar');
                    });
                }
            }
        });
    }

    function getQuantity(size_id, callback) {
        var result = 0;
        $.ajax({
            url: BASEURL + 'ajax/get/quantity/' + size_id,
            success: function (data) {
                if (data.success == 0) {
                    result = data.quantity;
                    callback();
                }
            }
        });
        return result;
    }


    //显示购物车
    $(".show-shopping-car").bind('click', function () {
        var page = $('.wrapper');
        if (page.hasClass('hascar')) {
            page.find('.m-car').remove();
            page.find('.m-shade').remove();
            page.removeClass('hascar');
        } else {
            getCart();
        }
    });

    function calCarTotal() {
        var total = 0;
        $('input[name^=flag]:checked').each(function () {
            var msg = $(this).parent().parent().parent().next();
            var price = parseFloat($(msg).find('.price').html());
            var qty = parseInt($(msg).find('.num').html());

            total += (price * qty);
        });


        $('.m-car').find('.total').html(total.toFixed(2));
    }

    //显示下拉导航
    $(".show-nav").bind('click', function () {
        var page = $('.wrapper');
        if (page.hasClass('hasnav')) {
            page.find('.m-slide-nav').remove();
            page.removeClass('hasnav');
        } else {
            var navContent = '<div class="m-slide-nav">' +
                '<div class="slide-nav-item">' +
                '<a href="' + BASEURL + 'production">全部商品</a>' +
                '</div>' +
                '<div class="slide-nav-item">' +
                '<a href="' + BASEURL + 'user">用户中心</a>' +
                '</div>' +
                '<div class="slide-nav-item nb">' +
                '<a href="' + BASEURL + 'order">我的订单</a>' +
                '</div>' +
                '</div>';

            page.prepend(navContent);
            page.addClass('hasnav');
        }
    })


});

//显示模态框
function showModalDialog(text) {
    var modal = '' +
        '<div class="m-modal" id="m-modal"><div class="block"><p>' + text + '</p><p style="color: #5c595c">（点击关闭）</p></div></div>';
    var page = $('.wrapper');
    page.prepend(modal);

    $("#m-modal").bind("touchend",function (event) {
        event.preventDefault();
        var page = $('.wrapper');
        page.find(".m-modal").remove();
    });
    // $("#m-modal").touch(function () {
    //     var page = $('.wrapper');
    //     alert(1);
    //     page.find(".m-modal").remove();
    // })
}
