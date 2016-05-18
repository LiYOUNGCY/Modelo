@extends('template.template')

@section('title', '提现记录 - 魔豆树')

@section('body')
    <div class="wrapper m-user-center">
        <div class="m-user-center-head">
            <a href="{{ url('user') }}"><span class="fa fa-reply fl"></span></a>
            <span class="fa fa-navicon fr show-nav"></span>
            <div class="cf"></div>
        </div>
        <div class="m-title-usual">
            提现记录
        </div>
        <div class="table withdraw-table">
            <table class="table" style="margin-bottom: 0; background-color: transparent" >
                <thead>
                <tr>
                    <th>时间</th>
                    <th>提现金额</th>
                    <th>状态</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cash as $item)
                <tr>
                    <td>{{ $item->created_at }}</td>
                    <td>￥{{ $item->cash }}</td>
                    <td>{{ $item->status->name }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection