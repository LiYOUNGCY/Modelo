@extends('admin.template.template')

@section('title', '上传图片 - 魔豆树')

@section('header', '上传图片')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <form action="{{ url("{$ADMIN}/image/store") }}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                <div id="items">
                </div>

                <div class="page-header">
                    <h1>注意：</h1>
                </div>
                <div class="well">
                    <ul>
                        <li>一次不能上传太多图片，最多3张。</li>
                        <li>图片的大小不能太太，在500K左右最好。</li>
                    </ul>
                </div>

                <button id="add" type="button" class="btn btn-primary">添加图片</button>
                <button type="submit" class="btn btn-success">提交</button>
            </form>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(document).ready(function () {
            function createItem() {
                var $item = $('<div class="row"> <div class="col col-md-6"> <div class="form-group"> <label>图片名称:</label> <input class="form-control" name="name[]" placeholder="XX商品图1"> </div> </div> <div class="col col-md-4"> <div class="form-group"> <label>图片:</label> <input type="file" name="image[]"> </div> </div> <div class="col col-md-2" style="text-align: right;"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </div> </div>');
                $item.find('span').click(function () {
                    $(this).parent().parent().remove();
                });
                $('#items').append($item);
            }

            createItem();

            $('#add').click(function () {
                createItem();
            });
        });
    </script>
@endsection

@section('moreCss')
@endsection