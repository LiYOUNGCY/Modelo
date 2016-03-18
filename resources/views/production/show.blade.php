@extends('template.template')

@section('title', "{$production->name} - 魔豆树")

@section('body')
    <div class="wrapper">
        @foreach($data['image'] as $value)
            <div class="goods-item">
                <img src="{{ asset($value->image) }}" alt="{{ $value->name }}">
            </div>
        @endforeach

        <div class="footer">
            <ul class="m-nav">
                <a href="javascript:history.go(-1);">
                    <li class="nav-item w50 active">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> 返回
                    </li>
                </a>
                <a href="{{ url("buy/{$production->alias}") }}">
                    <li class="nav-item w50 active">
                        <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> 立即购买
                    </li>
                </a>
            </ul>
        </div>
    </div>
@endsection