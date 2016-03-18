@extends('admin.template.template')

@section('title', '图片 - 魔豆树')

@section('header', '图片')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <form action="{{ url("{$ADMIN}/image/{$image->id}") }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <input type="hidden" name="_method" value="PUT">
                <table class="table table-bordered table-hover table-striped">
                    <tr>
                        <td>#</td>
                        <td>{{ $image->id }}</td>
                    </tr>
                    <tr>
                        <td>图片名称</td>
                        <td><input class="form-control" type="text" name="name" value="{{ $image->name }}"></td>
                    </tr>
                    <tr>
                        <td>图片宽度：</td>
                        <td>{{ $image->width }} px</td>
                    </tr>
                    <tr>
                        <td>图片高度：</td>
                        <td>{{ $image->height }} px</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><img src="{{ asset($image->path) }}" alt="{{ $image->name }}"
                                 style="display: block; margin: 0 auto; max-width:83.33333333%;"></td>
                    </tr>
                    <tr>
                        <td>更换图片</td>
                        <td><input type="file" name="image"></td>
                    </tr>
                    <tr>
                        <td>创建时间：</td>
                        <td>{{ $image->created_at }}</td>
                    </tr>
                </table>

                <a class="btn btn-default" href="{{ url("{$ADMIN}/image") }}">返回</a>
                <button class="btn btn-danger" id="delBtn" type="button">删除</button>
                <button class="btn btn-primary" type="submit">确认更新</button>
            </form>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(document).ready(function () {
            $('#delBtn').click(function () {
                if (confirm('确认删除该图片？')) {
                    $.ajax({
                        url: '{{ url("{$ADMIN}/image/{$image->id}") }}',
                        data: {
                            _method: "DELETE"
                        },
                        success: function (data) {
                            if (data.success == 0) {
                                alert('操作成功');
                                window.location.href = '{{ url("{$ADMIN}/image") }}';
                            } else if (data.error == 0) {
                                alert('操作失败');
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection