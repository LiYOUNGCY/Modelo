@extends('admin.template.template')

@section('title', '图片 - 魔豆树')

@section('header', '图片')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <td><input type="checkbox" name="checkAll" id="checkAll"></td>
                    <td>#</td>
                    <td>名称</td>
                    <td>路径</td>
                    <td>宽度</td>
                    <td>高度</td>
                    <td>创建时间</td>
                </tr>
                </thead>
                <tbody>
                @foreach($images as $image)
                    <tr data-id="{{ $image->id }}">
                        <td><input type="checkbox" name="flag[]" value="{{ $image->id }}"></td>
                        <td><a href="{{ url("{$ADMIN}/image/{$image->id}") }}">{{ $image->id }}</a></td>
                        <td>{{ $image->name }}</td>
                        <td>{{ $image->path }}</td>
                        <td>{{ $image->width }}</td>
                        <td>{{ $image->height }}</td>
                        <td>{{ $image->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <button class="btn btn-danger" id="delete" type="button">删除</button>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(function(){
            $('#checkAll').click(function(){
                $('input[name^=flag]').prop('checked', $(this).prop('checked'));
            });

            $('#delete').click(function(){
                if(confirm('你确定删除这些图片')) {
                    $('input[name^=flag]').each(function (i, ele) {
                        if ($(ele).is(':checked')) {
                            ajaxDelete($(ele).val());
                        }
                    });
                }
            });

            function ajaxDelete(id) {
                $.ajax({
                    url: ADMIN + 'image/' + id,
                    data: {
                        _method: 'DELETE'
                    },
                    success: function(data) {
                        if(data.success == 0) {
                            $('tr[data-id=' + id + ']').remove();
                        }
                    }
                });
            }
        });
    </script>
@endsection