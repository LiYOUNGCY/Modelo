@extends('admin.template.template')

@section('title', '系列 - 魔豆树')

@section('header', '系列')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <td>#</td>
                    <td>名称</td>
                    <td>别名</td>
                    <td>操作</td>
                </tr>
                </thead>
                <tbody>
                @foreach($series as $s)
                    <tr data-id="{{ $s->id }}">
                        <td>{{ $s->id }}</td>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->alias }}</td>
                        <td><a herf="javascript:;" name="delete" data-id="{{ $s->id }}"><i class="fa fa-trash-o fa-lg"></i></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(document).ready(function(){
            $('a[name=delete]').each(function(i, ele){
                $(ele).click(function(){
                    if(confirm('删除系列会删除所有该系列的商品，你确定删除')) {
                        var id = $(this).attr('data-id');
                        $.ajax({
                            url: '{{ url("{$ADMIN}/series") }}/' + id,
                            data: {
                                _method: 'DELETE'
                            },
                            success: function(data) {
                                if(data.success == 0) {
                                    alert('操作成功');
                                    window.location.reload();
                                } else {
                                    alert('操作失败');
                                }
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection