@extends('admin.template.template')

@section('title', '商品组合 - 魔豆树')

@section('header', '商品组合')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>所属系列</th>
                    <th>图片</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->series->name }}</td>
                        <td>{{ $value->image->name }}</td>
                        <td><button class="btn btn-danger" type="button" data-type="delete" data-id="{{ $value->id }}">删除</button></td>
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
            $('button[data-type=delete]').click(function () {
                var id = $(this).attr('data-id');
                console.log(id);
                $.ajax({
                    url: ADMIN + '/group/'+ id,
                    data: {
                        _method: 'DELETE'
                    },
                    success: function (data) {
                        console.log(data);
                        if(data.success == 0) {
                            window.location.reload();
                        }
                    }
                });
            })
        })
    </script>
@endsection