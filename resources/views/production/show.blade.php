@extends('template.template')

@section('title', "{$production->name} - 魔豆树")

@section('body')
    <div class="wrapper">
        @foreach($data['image'] as $value)
            <div class="goods-item">
                <img src="{{ asset($value->image) }}" alt="{{ $value->name }}">
            </div>
        @endforeach
        <div class="bottom-sign">
            - Modelo 魔豆树 -
        </div>
        <div class="footer">
            <ul class="m-nav">
                <a href="{{ url('/') }}">
                    <li class="nav-item w50 active">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> 返回
                    </li>
                </a>
                <a href="">
                    <li class="nav-item w50">
                        <a href="{{ url("buy/{$production->alias}") }}">
                            <span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> 立即购买
                        </a>
                    </li>
                </a>
            </ul>
        </div>
    </div>
@endsection