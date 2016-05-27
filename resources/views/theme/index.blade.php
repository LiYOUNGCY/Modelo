@extends('template.template')

@section('title', '首页 - 魔豆树')

@section('body')
    <div class="wrapper">
        <div class="m-head theme-head">
            <div class="m-name">{{ $series->name }}</div>
            <div class="icon-group nb">
                <div class="l-icon fl">
                    <a href="javascript:history.go(-1);"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-shopping-car">
                    <span class="fa fa-shopping-cart"></span>
                </div>
            </div>
        </div>

        <div class="swiper-container theme-postcard">
            <div class="swiper-wrapper">
                @foreach($seriesGroups as $seriesGroup)
                    <div class="swiper-slide">
                        <div class="postcard"
                             style="background-image: url({{ asset($seriesGroup->image->path) }})"></div>
                    </div>
                @endforeach
            </div>
            <div class="tips">
                <span class="fa fa-angle-double-left"></span>
                <span class="fa fa-angle-double-left" style="color:#FFFFFF;"></span>
                <span class="fa fa-angle-double-left"></span>
            </div>
        </div>


        <div class="theme-goods-group">
            <?php $i = 0?>
            @foreach($groupProductions as $key => $groupProduction)
                <div class="theme-goods-list hide" id="{{ $i++ }}">
                    @if(!empty($groupProduction))
                        @foreach($groupProduction as $value)
                            <div class="theme-goods-item">
                                <a href="{{ url("production/{$value->alias}") }}">
                                    <img src="{{ $value->image }}">
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>

    </div>
@endsection

@section('moreCss')
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
@endsection

@section('moreScript')
    <script src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script>
        var a = $('.theme-goods-group').find('.theme-goods-list');//[0].removeClass('hide');
        $(a[0]).removeClass('hide');
        var swiperPostcard = new Swiper('.theme-postcard', {
            onSlideChangeEnd: function (swiper) {
                var index = swiper.activeIndex;
                changeThemeGoods(index);
            }
        });

        function changeThemeGoods(index) {
            $(".theme-goods-group").find(".theme-goods-list").each(function () {
                $(this).addClass('hide');
            });
            $(".theme-goods-group").find("#" + index).removeClass('hide');
        }

    </script>
@endsection