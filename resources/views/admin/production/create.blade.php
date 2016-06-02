@extends('admin.template.template')

@section('title', '添加服装 - 魔豆树')

@section('header', '添加服装')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1" id="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">添加服装</h3>
                </div>
                <div class="panel-body">
                    <form id="productionFrom" action="{{ url('production/store') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="name">服装名称：</label>
                            <input class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="series_id">所属系列：</label>
                            <select name="series_id" id="series_id" class="form-control">
                                @foreach($series as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">封面图：</label>
                            <select name="cover_id" id="cover_id" class="form-control">
                                @foreach($images as $image)
                                    <option value="{{ $image->id }}">{{ $image->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">主题图：</label>
                            <select name="series_image" id="series_image" class="form-control">
                                @foreach($images as $image)
                                    <option value="{{ $image->id }}">{{ $image->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">成分说明图：</label>
                            <select name="fabric_info_id" id="fabric_info_id" class="form-control">
                                @foreach($images as $image)
                                    <option value="{{ $image->id }}">{{ $image->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">尺码说明图：</label>
                            <select name="size_info_id" id="size_info_id" class="form-control">
                                @foreach($images as $image)
                                    <option value="{{ $image->id }}">{{ $image->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">分类:</label>
                            @foreach($categories as $category)
                                <label class="checkbox-inline">
                                    <input type="checkbox" value="{{ $category->id }}" name="category[]"
                                           id="category">{{ $category->name }}
                                </label>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-success" id="createColor">添加款式
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <button class="btn btn-success" type="button" id="save" style="width: 80%; display: block; margin: 0 auto;">
                保存全部
            </button>
        </div>
    </div>
@endsection

@section('modal')
    <template id="colorTemplate">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
                <form data-name="colorForm">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="colorName">款式名称：</label>
                        <input class="form-control" id="colorName" name="colorName" placeholder="迷彩绿">
                    </div>
                    <div class="form-group">
                        <label for="colorImage">款式图片：</label>
                        <select class="form-control" id="colorImage" name="colorImage">
                            @foreach($images as $image)
                                <option value="{{ $image->id }}">{{ $image->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="colorName">款式价格：</label>
                        <input class="form-control" id="colorPrice" name="colorPrice" placeholder="99.99">
                    </div>

                    <div data-name="size">
                    </div>
                    <div data-name="image">
                    </div>
                </form>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-primary" data-name="createSize">
                    添加尺码
                </button>
                <button type="button" class="btn btn-primary" data-name="createImage">
                    添加图片
                </button>
            </div>
        </div>
    </template>

    <template id="sizeTemplate">
        <div class="form-inline" style="margin-top: .5em;">
            <div class="form-group">
                <label>尺码：</label>
                <input type="text" name="size[]" class="form-control" data-name="size">
            </div>
            <div class="form-group">
                <label>库存：</label>
                <input class="form-control" name="quantity[]" data-name="quantity">
            </div>
            <button class="btn btn-danger" type="button" data-name="delete">删除</button>
        </div>
    </template>

    <template id="imageTemplate">
        <div class="form-inline" style="margin-top: .5em;">
            <div class="form-group">
                <label for="colorImage">图片：</label>
                <select class="form-control" id="colorImage" name="image[]">
                    @foreach($images as $image)
                        <option value="{{ $image->id }}">{{ $image->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-danger" type="button" data-name="delete">删除</button>
        </div>
    </template>
@endsection

@section('moreScript')
    <script>
        $(function () {
            //Global Date
            var $container = $('#container');
            var productionId = 0;


            //添加款式
            $('#createColor').click(function () {
                createColor();
            });

            function createColor() {
                var $colorTemplate = $($('#colorTemplate').html());

                //注册事件
                $colorTemplate.find('button[data-name=createSize]').click(function () {
                    var $sizeTemplate = $($('#sizeTemplate').html());
                    $sizeTemplate.find('button[data-name=delete]').click(function () {
                        $(this).parent().remove();
                    });
                    $(this).parent().prev().find('div[data-name=size]').append($sizeTemplate);
                });

                $colorTemplate.find('button[data-name=createImage]').click(function () {
                    var $imageTemplate = $($('#imageTemplate').html());
                    $imageTemplate.find('button[data-name=delete]').click(function () {
                        $(this).parent().remove();
                    });
                    $(this).parent().prev().find('div[data-name=image]').append($imageTemplate);
                });


                $container.append($colorTemplate);
            }

//            全部保存
            $('#save').click(function () {
                var production = $('#productionFrom').serialize();
//                console.log(production);

                //保存商品
                $.ajax({
                    url: ADMIN + '/production/store',
                    type: 'post',
                    async: false,
                    data: production,
                    success: function (data) {
                        if (data.success == 0) {
                            productionId = data.production_id;
                        }
                    }
                });

                //保存款式
                $('form[data-name=colorForm]').each(function () {
                    var color = $(this).serialize();

                    $.ajax({
                        url: ADMIN + '/production/' + productionId + '/color/store',
                        type: 'post',
                        async: false,
                        data: color,
                        success: function (data) {
                            if (data.error == 0) {
                                alert('发生错误，请重新编辑！');
                            }
                        }
                    });
                });


                window.location.href = ADMIN + '/production';
            })
        });
    </script>
@endsection