@extends('admin.template.template')

@section('title', '修改商品信息 - 魔豆树')

@section('header', "修改商品信息：{$production->name}")

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <input id="productionId" type="hidden" name="productionId" value="{{ $production->id }}">

            <form role="form" data-name="production">
                <div class="form-group">
                    <label for="name">服装名称：</label>
                    <input class="form-control" id="name" name="name" value="{{ $production->name }}">
                </div>

                <div class="form-group">
                    <label for="alias">服装别名：</label>
                    <input class="form-control" id="alias" name="alias" value="{{ $production->alias }}">
                    <p class="help-block">服装名称的英文名，允许数字、英文、下划线（必填）</p>
                </div>

                <div class="form-group">
                    <label for="cover_id">封面图：</label>
                    <select name="cover_id" id="cover_id" class="form-control">
                        @foreach($images as $image)
                            @if(!empty($production->cover_id) && $image->id == $production->cover_id)
                                <option value="{{ $image->id }}" selected>{{ $image->name }}</option>
                            @else
                                <option value="{{ $image->id }}">{{ $image->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="series_id">所属系列：</label>
                    <select name="series_id" id="series_id" class="form-control">
                        @foreach($series as $s)
                            @if($production->series_id == $s->id)
                                <option value="{{ $s->id }}" selected>{{ $s->name }}</option>
                            @else
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </form>


            <div data-name="colorContainer">
                @foreach($colors as $color)
                    <div class="row" data-name="color" data-id="{{ $color->id }}">
                        <div class="page-header">
                    <span class="remove" data-name="removeColor" data-alias="{{ $color->alias }}">
                        <i class="fa fa-remove fa-3x"></i></span>
                            <h1>修改款式：{{ $color->name }}</h1>
                        </div>
                        <form role="form">
                            <div class="form-group">
                                <label for="color_name">款式名称：</label>
                                <input class="form-control" id="color_name" name="color_name"
                                       value="{{ $color->name }}">
                            </div>
                            <div class="form-group">
                                <label for="color_alias">款式别名：</label>
                                <input class="form-control" id="color_alias" name="color_alias"
                                       value="{{ $color->alias }}">
                                <p class="help-block">服装名称的英文名，允许数字、英文、下划线（必填）</p>
                            </div>
                            <div class="form-group">
                                <label for="color_price">价格：</label>
                                <input class="form-control" id="color_price" name="color_price"
                                       value="{{ $color->price }}">
                            </div>

                            <div data-name="size">
                                @foreach($data[$color->alias]['size'] as $value)
                                    <div class="form-group form-inline" data-id="{{ $value->id }}">
                                        <input type="hidden" name="size_id" value="{{ $value->id }}">
                                        <label for="size_name">尺码：</label>
                                        <input class="form-control" id="size_name" name="size_name"
                                               value="{{ $value->name }}">
                                        <label for="size_quantity">库存：</label>
                                        <input class="form-control" id="size_quantity" name="size_quantity"
                                               value="{{ $value->quantity }}" disabled>
                                        <label for="size_increase">添加库存</label>
                                        <input class="form-control" id="size_increase" name="size_increase">
                                        <button type="button" class="btn btn-success">确定添加</button>
                                        <button type="button" class="btn btn-danger" data-name="removeSize"><i
                                                    class="fa fa-remove"></i>删除
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <div data-name="image">
                                @foreach($data[$color->alias]['image'] as $value)
                                    <div class="form-group form-inline" data-id="{{ $value->id }}">
                                        <label for="image_name">图片名称：</label>
                                        <input type="hidden" name="image_id" value="{{ $value->image_id }}">
                                        <input class="form-control" id="image_name" name="image_name"
                                               value="{{ $value->name }}"
                                               disabled>
                                        <label for="image_type">图片类型</label>
                                        <select name="image_type" id="image_type" class="form-control">
                                            <option value="1">主图</option>
                                            <option value="2">细节图</option>
                                        </select>
                                        <button type="button" class="btn btn-primary" data-name="moveUp">上移</button>
                                        <button type="button" class="btn btn-primary" data-name="moveDown">下移</button>
                                        <button type="button" class="btn btn-danger" data-name="removeImage">
                                            <i class="fa fa-remove"></i>删除
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <div class="option">
                                <button type="button" class="btn btn-default" data-name="createSize"><i
                                            class="fa fa-plus"></i>添加尺码
                                </button>
                                <button type="button" class="btn btn-default" data-name="createImage"
                                        data-toggle="modal"
                                        data-target="#image">
                                    <i class="fa fa-plus"></i>添加图片
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>


            <button id="createColor" type="button" class="btn btn-primary" style="width: 80%; margin: 0 auto; display: block; margin-top: 2.5em;">
                添加款式
            </button>

            <div class="page-header">
                <h1>说明：</h1>
            </div>
            <div class="well">
                <ul>
                    <li>删除款式：立即删除不用保存</li>
                    <li>若没有保存就刷新，数据会丢失。</li>
                </ul>
            </div>

            <button type="button" class="btn btn-success" id="updateProduction"
                    style="width: 80%; margin: 0 auto; display: block; margin-top: 2.5em;">保存全部
            </button>
        </div>
    </div>
@endsection

@section('modal')
    {{-- Create Image --}}
    <div class="modal fade" id="image" tabindex="-1" role="dialog" aria-labelledby="imageLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="imageLabel">选择图片</h4>
                </div>
                <div class="modal-body">
                    <div class="image-content">
                        <ul class="clearfix">
                            @foreach($images as $image)
                                <li data-id="{{ $image->id }}">{{ $image->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="createSecond">确定</button>
                </div>
            </div>
        </div>
    </div>

    <template id="sizeTemplate">
        {{-- data-id 为 0 即要创建新的 --}}
        <div class="form-group form-inline" data-id="0">
            <input type="hidden" name="size_id" value="0">
            <label for="size_name">尺码：</label>
            <input class="form-control" id="size_name" name="size_name" value="">
            <label for="size_quantity">库存：</label>
            <input class="form-control" id="size_quantity" name="size_quantity">
            <button type="button" class="btn btn-danger" data-name="removeSize">
                <i class="fa fa-remove"></i>删除
            </button>
        </div>
    </template>

    <template id="imageTemplate">
        <div class="form-group form-inline" data-id="0">
            <label for="image_name">图片名称：</label>
            <input type="hidden" name="image_id">
            <input class="form-control" id="image_name" name="image_name" disabled>
            <label for="image_type">图片类型</label>
            <select name="image_type" id="image_type" class="form-control">
                <option value="1">主图</option>
                <option value="2">细节图</option>
            </select>
            <button type="button" class="btn btn-primary" data-name="moveUp">上移</button>
            <button type="button" class="btn btn-primary" data-name="moveDown">下移</button>
            <button type="button" class="btn btn-danger" data-name="removeImage">
                <i class="fa fa-remove"></i>删除
            </button>
        </div>
    </template>

    <template id="colorTemplate">
        <div class="row" data-name="color" data-id="0">
            <div class="page-header">
                    <span class="remove" data-name="removeColor" data-alias="0">
                        <i class="fa fa-remove fa-3x"></i></span>
                <h1>新增款式</h1>
            </div>
            <form role="form">
                <div class="form-group">
                    <label for="color_name">款式名称：</label>
                    <input class="form-control" id="color_name" name="color_name" value="">
                </div>
                <div class="form-group">
                    <label for="color_alias">款式别名：</label>
                    <input class="form-control" id="color_alias" name="color_alias" value="">
                    <p class="help-block">服装名称的英文名，允许数字、英文、下划线（必填）</p>
                </div>
                <div class="form-group">
                    <label for="color_price">价格：</label>
                    <input class="form-control" id="color_price" name="color_price" value="">
                </div>

                <div data-name="size">
                </div>

                <div data-name="image">
                </div>

                <div class="option">
                    <button type="button" class="btn btn-default" data-name="createSize">
                        <i class="fa fa-plus"></i>添加尺码
                    </button>
                    <button type="button" class="btn btn-default" data-name="createImage" data-toggle="modal"
                            data-target="#image">
                        <i class="fa fa-plus"></i>添加图片
                    </button>
                </div>
            </form>
        </div>
    </template>
@endsection

@section('moreScript')
    <script>
        $(function () {
            var imageContainer = null;
            var productionId = $('#productionId').val();

            function dropElement(ele) {
                $(ele).fadeOut('slow', function () {
                    $(this).remove();
                });
            }

            function moveUp() {
                var prev = $(this).parent().prev();
                var self = $(this).parent();
                if(prev.length == 0) {
                    alert('不能向上移，已经是第一个元素');
                }

                $(self).insertBefore($(prev));
            }

            function moveDown() {
                var next = $(this).parent().next();
                var self = $(this).parent();
                if(next.length == 0) {
                    alert('不能向下移，已经是最后一个元素');
                }
                $(self).insertAfter($(next));
            }

            $('button[data-name=moveUp]').click(moveUp);
            $('button[data-name=moveDown]').click(moveDown);

            $('span[data-name=removeColor]').each(function (i, ele) {
                $(ele).click(function () {
                    var self = $(this).parent().parent();
                    if (confirm('你确定删除该款式?')) {
                        var color_alias = $(this).attr('data-alias');
                        $.ajax({
                            url: '{{ url("{$ADMIN}/color") }}/' + color_alias,
                            data: {_method: 'DELETE'},
                            success: function (data) {
                                if (data.success == 0) {
                                    dropElement(self);
                                    alert('操作成功');
                                }
                            }
                        });
                    }
                });
            });

            $('button[data-name=removeSize]').each(function (i, ele) {
                $(ele).click(function () {
                    if (confirm("你确定删除该项")) {
                        var sizeContainer = $(this).parent();
                        var sizeId = sizeContainer.attr('data-id');
                        $.ajax({
                            url: '{{ url("{$ADMIN}/production/size") }}/' + sizeId,
                            data: {_method: "DELETE"},
                            success: function (data) {
                                console.log(data);
                                if (data.success == 0) {
                                    dropElement(sizeContainer);
//                                    alert('操作成功');
                                }
                            }
                        });
                    }
                });
            });

            $('button[data-name=removeImage]').each(function (i, ele) {
                $(ele).click(function () {
                    dropImage($(this).parent());
                });
            });

            //创建款式
            $('#createColor').click(function () {
                var colorTemplate = $('#colorTemplate').html();
                $('div[data-name=colorContainer]').append(colorTemplate);

                var target = $('div[data-name=colorContainer]').children();
                target = $(target[target.length - 1]);
                target.find('button[data-name=createSize]').click(createSize);
                target.find('button[data-name=createImage]').click(createImage);
                target.find('span[data-name=removeColor]').click(function(){
                    var self = $(this).parent().parent();
                    dropElement(self);
                });
            });

            function createSize() {
                var sizeTemplate = $('#sizeTemplate').html();
                var container = $(this).parent().prev().prev();
                container.append(sizeTemplate);
                var children = container.children();
                $(children[children.length - 1]).find('button[data-name=removeSize]').click(function () {
                    dropElement($(this).parent());
                });
            }

            function createImage() {
                imageContainer = $(this).parent().prev();
            }

            /**
             * 添加 Size
             */
            $('button[data-name=createSize]').each(function (i, ele) {
                $(ele).click(createSize);
            });

            $('button[data-name=createImage]').each(function (i, ele) {
                $(ele).click(createImage);
            });

            $('.image-content > ul > li').each(function (i, ele) {
                $(ele).click(function () {
                    if (imageContainer == null || imageContainer == 'undefined') {
                        alert('发生未知错误!');
                    }

                    $('#image').modal('hide');
                    var image_id = $(this).attr('data-id');
                    var image_name = $(this).html();
                    var imageTemplate = $('#imageTemplate').html();

                    imageContainer.append(imageTemplate);

                    var children = imageContainer.children();
                    children = $(children[children.length - 1]);
                    var imageIdInput = $(children.find('input[name=image_id]')[0]);
                    var imageNameInput = $(children.find('input[name=image_name]')[0]);
                    var dropButton = $(children.find('button[data-name=removeImage]')[0]);
                    var moveUpButton = $(children.find('button[data-name=moveUp]')[0]);
                    var moveDownButton = $(children.find('button[data-name=moveDown]')[0]);
                    moveUpButton.click(moveUp);
                    moveDownButton.click(moveDown);
                    dropButton.click(function () {
                        dropImage($(this).parent());
                    });
                    imageIdInput.val(image_id);
                    imageNameInput.val(image_name);
                });
            });

            //update production
            $('#updateProduction').click(function () {
                updateProduction();
                $('div[data-name=color]').each(function (i, ele) {
                    updateProductionColor(ele, $(ele).attr('data-id'));
                });
            });


            /**
             * 更新商品信息
             */
            function updateProduction() {
                var name = getValue($('form[data-name=production]'), 'name');
                var alias = getValue($('form[data-name=production]'), 'alias');
                var cover_id = getValue($('form[data-name=production]'), 'cover_id');
                var series_id = getValue($('form[data-name=production]'), 'series_id');

                var data = new Object();
                data.name = name;
                data.alias = alias;
                data.cover_id = cover_id;
                data.series_id = series_id;
                data._method = 'PUT';
                console.log(data);

                ajax('{{ url("{$ADMIN}/production/") }}/' + productionId, data, function (data) {
                    console.log(data);
                    if (data.success == 0) {

                    } else {
                        alert('操作失败!');
                    }
                });
            }

            /**
             * 更新商品的款式
             */
            function updateProductionColor(container, color_id) {
                var data = new Object();
                data._method = 'PUT';
                var color_name = getValue(container, 'color_name');
                data.color_name = color_name;
                data.color_alias = getValue(container, 'color_alias');
                data.color_price = getValue(container, 'color_price');

                var imageContainer = $(container).find('div[data-name=image]');
                imageContainer = $(imageContainer[0]).children('div');
                for (var i = 0; i < imageContainer.length; i++) {
                    data['image[' + i + ']'] = getImages(imageContainer[i]);
                }

                var sizeController = $(container).find('div[data-name=size]');
                sizeController = $(sizeController[0]).children('div');
                for (i = 0; i < sizeController.length; i++) {
                    data['size[' + i + ']'] = getSizes(sizeController[i]);
                }

                console.log(data);

                //put production's color
                ajax('{{ url("{$ADMIN}/production/{$production->id}") }}/color/' + color_id, data, function (data) {
                    console.log(data);
                    if (data.success == 0) {
                        showSuccess('保存成功!');
                    }
                });
            }

            function getImages(container) {
                var image = new Object();
                image.image_id = getValue(container, 'image_id');
                image.image_type = getValue(container, 'image_type');
                return image;
            }

            function getSizes(container) {
                var size = new Object();
                size.id = getValue(container, 'size_id');
                size.size_name = getValue(container, 'size_name');
                size.size_quantity = getValue(container, 'size_quantity');
                return size;
            }

            function getValue(container, name) {
                var target = $(container).find('[name=' + name + ']');
                if (target.length !== 1) {
                    throw "Object Not Found:" + name;
                }
                return $(target[0]).val();
            }

            function ajax(url, data, success) {
                $.ajax({
                    url: url,
                    data: data,
                    async: false,
                    success: success
                });
            }

            function dropImage(container) {
                container = $(container);
                if (confirm('你确定要删除该商品的图片')) {
                    var image_id = container.attr('data-id');
                    console.log(image_id);
                    $.ajax({
                        url: '{{ url("{$ADMIN}/production/image") }}/' + image_id,
                        data: {_method: 'DELETE'},
                        success: function (data) {
                            console.log(data);
                            if (data.success == 0) {
                                dropElement(container);
                            } else {
                                alert('操作失败!');
                            }
                        }
                    });
                }
            }
        });
    </script>
@endsection