@extends('template.template')

@section('title', '我的二维码 - 魔豆树')

@section('body')
    <img src="{{ url($qrcode->qrcode) }}" alt="qrcode">
@endsection