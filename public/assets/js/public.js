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
                console.log(data);
                if (data.success == 0) {
                    var page = $('.wrapper');
                    cart = data.data;
                    var length = Object.keys(cart).length;
                    console.log(length);
                    if (length != 0) {
                        var content = '';

                        for (var key in cart) {
                            content += '<div class="car-goods" id="car-goods-1">' +
                                '<div class="car-goods-name">' +
                                '<span class="fl"><input name="goods" type="checkbox" value="car-goods-1" /><a href="'+BASEURL +'production/'+cart[key].options.production_alias+'">'+cart[key].name+'</a></span>' +
                                '<span class="fr remove-goods" data-id="'+key+'">移除</span>' +
                                '</div>' +
                                '<div class="car-goods-detail">' +
                                '<a href="'+BASEURL +'production/'+cart[key].options.production_alias+'"><div class="goods-pic" style="background-image: url('+BASEURL+cart[key].options.cover+')"></div></a>' +
                                '<div class="goods-info">' +
                                '<p>￥<span class="price">'+cart[key].price+'</span></p>' +
                                '<p> '+cart[key].options.color_name +' '+ cart[key].options.size_name + '</p>' +
                                '<div class="quantity">' +
                                '<span class="fa fa-minus car-minus"></span>' +
                                '<div class="num" id="count">1</div>' +
                                '<span class="fa fa-plus car-plus"></span>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>';
                        }

                        //绘制购物车，绑定事件
                        var carContent = '<div class="m-car">' +
                            '<div class="car-goods-list">' +
                            content +
                            '</div>' +
                            '<div class="car-final">' +
                            //'<a href="javascript:void(0)" id="checkAll">全选</a>' +
                            '<input type="checkbox" name="checkAll" id="checkAll"> 全选' +
                            '<div class="fr">' +
                            '<div class="car-total">总计：￥<span class="total">0</span></div>' +
                            '<a href="javascript:void(0)"><div class="settlement">去结算</div></a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="car-shade"></div>';


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
                                        console.log(data);
                                        if (data.success == 0) {
                                            self.parent().remove();
                                        }
                                    }
                                });
                            });
                        });
                    } else {
                        var carContent = '<div class="m-car">' +
                            '<div class="car-empty">' +
                            '空' +
                            '</div>' +
                            '</div>'

                        page.prepend(carContent);
                        page.addClass('hascar');
                    }
                }
            }
        });
    }


    //显示购物车
    $(".show-shopping-car").bind('click', function () {
        var page = $('.wrapper');
        if (page.hasClass('hascar')) {
            page.find('.m-car').remove();
            page.find('.car-shade').remove();
            page.removeClass('hascar');
        } else {
            getCart();
        }
    });

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
        '<div class="m-modal"><div class="block"><p>' + text + '</p><p style="color: #5c595c">（点击关闭）</p></div></div>';
    $("body").prepend($(modal));
    $("body").on('click', ".m-modal", function () {
        $(this).remove();
    });
}