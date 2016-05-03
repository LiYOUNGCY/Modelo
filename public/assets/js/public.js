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
    //显示购物车
    $(".show-shopping-car").bind('click', function () {
        var page = $('.wrapper');
        if (page.hasClass('hascar')) {
            page.find('.m-car').remove();
            page.removeClass('hascar');
            return;
        } else {
            var carContent = '<div class="m-car">' +
                '<div class="car-goods">' +
                '<div class="pic"><img src="img/head.jpg"></div>' +
                '<div class="remove-goods">' +
                '<span class="fa fa-close"></span>' +
                '</div>' +
                '</div>' +
                '<div class="car-goods">' +
                '<div class="pic"><img src="img/head.jpg"></div>' +
                '<div class="remove-goods">' +
                '<span class="fa fa-close"></span>' +
                '</div>' +
                '</div>' +
                '<div class="car-clean">' +
                '<a href="javascript:void(0)">清空购物车</a>' +
                '</div>' +
                '</div>';

//                购物车为空
//                var carContent = '<div class="m-car">' +
//                        '<div class="car-empty">' +
//                        '空' +
//                        '</div>' +
//                        '</div>' ;

            page.prepend(carContent);
            page.addClass('hascar');
            $("body").on('click', ".remove-goods", function () {
                $(this).parent().remove();
            });
        }
    })
    //显示下拉导航
    $(".show-nav").bind('click', function () {
        var page = $('.wrapper');
        if (page.hasClass('hasnav')) {
            page.find('.m-slide-nav').remove();
            page.removeClass('hasnav');
            return;
        } else {
            var navContent = '<div class="m-slide-nav">' +
                '<div class="slide-nav-item">' +
                '<a href="'+BASEURL+'production">全部商品</a>' +
                '</div>' +
                '<div class="slide-nav-item">' +
                '<a href="' + BASEURL + 'user">用户中心</a>' +
                '</div>' +
                '<div class="slide-nav-item">' +
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