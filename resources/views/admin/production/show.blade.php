@extends('admin.template.template')

@section('title', ' 商品 - 魔豆树')

@section('header', '商品')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover table-striped">
                <tr>
                    <td>#</td>
                    <td>{{ $production->id }}</td>
                </tr>
                <tr>
                    <td>商品名称：</td>
                    <td>{{ $production->name }}</td>
                </tr>
                <tr>
                    <td>商品别名：</td>
                    <td>{{ $production->alias }}</td>
                </tr>
                <tr>
                    <td>所属系列</td>
                    <td>{{ $production->series }}</td>
                </tr>
            </table>

            @if(! empty($production->cover))
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">封面</h3>
                    </div>
                    <div class="panel-body">
                        <img src="{{ url($production->cover) }}" alt="" style="display: block; margin: 0 auto;">
                    </div>
                </div>
            @endif

            @foreach($colors as $color)
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            {{ $color->name }} ({{ $color->alias }})
                            <span style="float: right;">{{ $color->price }}￥</span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>尺码</th>
                                        <th>数量</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data[$color->alias]['size'] as $value)
                                        <tr>
                                            <td>{{ $value->name }}</td>
                                            <td>{{ $value->quantity }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">
                                @foreach($data[$color->alias]['image'] as $value)
                                    <img src="{{ url("{$value->image}") }}" alt="{{ $value->name }}"
                                         style="display: block; margin: .5em auto;">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection