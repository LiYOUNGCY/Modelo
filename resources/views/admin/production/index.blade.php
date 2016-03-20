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
                    <td>别名</td>
                    <td>所属系列</td>
                    <td>操作</td>
                </tr>
                </thead>
                <tbody>
                @foreach($productions as $production)
                    <tr>
                        <td><a href="{{ url("{$ADMIN}/production/{$production->alias}") }}">{{ $production->id }}</a>
                        </td>
                        <td>{{ $production->name }}</td>
                        <td>{{ $production->alias }}</td>
                        <td>{{ $production->series }}</td>
                        <td>
                            <a herf="javascript:;" name="delete" data-id="{{ $production->alias }}" title="删除">
                                <i class="fa fa-trash-o fa-lg"></i>
                            </a>
                            <a href="javascript:;" name="edit" data-id="{{ $production->alias }}" title="修改">
                                <i class="fa fa-edit fa-lg"></i>
                            </a>
                            <a href="{{ url("production/{$production->alias}") }}">打开</a>
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
            $('a[name=delete]').each(function (i, ele) {
                $(ele).click(function () {
                    if (confirm('你确定删除该商品？')) {
                        var alias = $(this).attr('data-id');
                        $.ajax({
                            url: '{{ url("{$ADMIN}/production/") }}/' + alias,
                            data: {
                                _method: 'DELETE'
                            },
                            success: function (data) {
                                console.log(data);
                                if (data.success == 0) {
                                    alert('操作成功');
                                    window.location.reload();
                                } else if (data.error == 0) {
                                    alert('操作失败');
                                    window.location.reload();
                                }
                            }
                        });
                    }
                });
            });

            $('a[name=edit]').each(function(i, ele){
                $(ele).click(function(){
                    var alias = $(this).attr('data-id');
                    window.location.href = '{{ url("{$ADMIN}/production") }}/' + alias + '/edit';
                });
            });
        })
    </script>
@endsection