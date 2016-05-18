@extends('template.template')

@section('title', '我的大豆芽 - 魔豆树')

@section('body')
    <div class="wrapper m-user-center">
        <div class="m-user-center-head">
            <a href="{{ url('user') }}"><span class="fa fa-reply fl"></span></a>
            <span class="fa fa-navicon fr show-nav"></span>
            <div class="cf"></div>
        </div>
        <div class="m-title-usual">
            我的豆芽
        </div>
        <div class="m-son">
            <div class="search-son">
                <input type="text" id="name" name="name" placeholder="搜索">
            </div>
            <div class="son-list" id="list">
                @foreach($children as $item)
                    <div class="son-item">
                        <span data-type="name">{{ $item->nickname }}</span>
                        @if($item->flag)
                            <span class="son-level active">大豆芽</span>
                        @else
                            <span class="son-level">大豆芽</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(function () {
            $('#name').bind('input propertychange', function () {
                var keyword = $(this).val();
                console.log(keyword);

                $('#list').find('.son-item').each(function (i, ele) {
                    var name = $(ele).find('span[data-type=name]')[0];
                    name = $(name).html();
//                    console.log(name);
                    console.log(name.indexOf(keyword));

                    if (name.indexOf(keyword) >= 0) {
                        $(ele).attr('data-disable', '0');
                    } else {
                        $(ele).attr('data-disable', '1');
                    }
                });

                $('#list').find('.son-item').each(function (i, ele) {
                    if ($(ele).attr('data-disable') == 1) {
                        $(ele).hide();
                    } else {
                        $(ele).show();
                    }
                });
            });
        });
    </script>
@endsection