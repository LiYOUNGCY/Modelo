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
                <input type="text" name="sonName" placeholder="搜索">
            </div>
            <div class="son-list">
                @foreach($children as $item)
                <div class="son-item">
                    <span >{{ $item->nickname }}</span>
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