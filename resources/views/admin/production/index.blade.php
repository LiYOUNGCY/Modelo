@extends('admin.template.template')

@section('title', ' 商品 - 魔豆树')

@section('header', '商品')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <td>#</td>
                    <td>名称</td>
                    <td>所属系列</td>
                    <td>操作</td>
                </tr>
                </thead>
                <tbody>
                @foreach($productions as $production)
                    <tr>
                        <td><a href="{{ url("{$ADMIN}/production/{$production->id}") }}">{{ $production->id }}</a>
                        </td>
                        <td>{{ $production->name }}</td>
                        <td>{{ $production->series->name }}</td>
                        <td>
                            <a href="{{ url("{$ADMIN}/production/{$production->id}/edit") }}">编辑</a>
                            <a href="{{ url("production/{$production->id}") }}">打开</a>
                            <a href="javascript:void(0);" data-name="delete" data-id="{{ $production->id }}">删除</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(function () {
            $('a[data-name=delete]').click(function (event) {
                event.preventDefault();

                if(confirm('你确定删除该商品')) {
                    var id = $(this).attr('data-id');
                    $.ajax({
                        url: ADMIN + '/production/' + id + '/destroy',
                        type: 'post',
                        success: function (data) {
                            if(data.success == 0) {
                                window.location.reload();
                            }
                        }
                    })
                }
            })
        })
    </script>
@endsection