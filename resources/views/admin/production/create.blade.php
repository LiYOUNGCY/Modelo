@extends('admin.template.template')

@section('title', '新建服装 - 魔豆树')

@section('header', '新建服装')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1" id="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">第一步：添加服装</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name">服装名称：</label>
                        <input class="form-control" id="name" name="name">
                    </div>

                    <div class="form-group">
                        <label for="alias">服装别名：</label>
                        <input class="form-control" id="alias" name="alias">
                        <p class="help-block">服装名称的英文名，允许数字、英文、下划线（必填）</p>
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
                        <label for="series_id">所属系列：</label>
                        <select name="series_id" id="series_id" class="form-control">
                            @foreach($series as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-primary" id="createProduction">确定</button>
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal" disabled>
                        为服装添加款式
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">创建款式</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="color">款式名称：</label>
                        <input class="form-control" id="color" name="color" placeholder="迷彩绿">
                    </div>
                    <div class="form-group">
                        <label for="color">款式别名：</label>
                        <input class="form-control" id="color_alias" name="color_alias" placeholder="Camouflage green">
                    </div>
                    <div class="form-group">
                        <label for="price">价格：</label>
                        <input class="form-control" id="price" name="price" placeholder="99.99">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="createColor">确定</button>
                </div>
            </div>
        </div>
    </div>

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

    <template id="colorTemplate">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <h3 class="panel-title"></h3>
            </div>
            <div class="panel-body">
                <div data-name="size">
                </div>
                <div data-name="image">
                </div>
            </div>
            <div class="panel-footer">
                <button type="button" class="btn btn-primary" data-name="createSize">添加尺码</button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#image">
                    添加图片
                </button>
                <button class="btn btn-success" type="button" data-name="submit">确定</button>
            </div>
        </div>
    </template>

    <template id="sizeTemplate">
        <div class="row">
            <div class="col col-md-6">
                <div class="form-group">
                    <label>尺码：</label>
                    <select class="form-control" name="size[]">
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                    </select>
                </div>
            </div>
            <div class="col col-md-6">
                <div class="form-group">
                    <label>库存：</label>
                    <input class="form-control" name="quantity[]">
                </div>
            </div>
        </div>
    </template>

    <template id="imageTemplate">
        <div class="row">
            <div class="col col-md-6">
                <div class="form-group">
                    <label>图片名称：</label>
                    <input class="form-control" name="image_id[]" type="hidden">
                    <input type="text" class="form-control" name="name" disabled value="">
                </div>
            </div>
            <div class="col col-md-6">
                <div class="form-group">
                    <label>图片类型：</label>
                    <select class="form-control" name="primary[]">
                        <option value="1">主图</option>
                        <option value="2">细节图</option>
                    </select>
                </div>
            </div>
        </div>
    </template>
@endsection

@section('moreScript')
    <script>
        $(document).ready(function () {
            var $container = $('#container');
            var container = null;
            var ADMINURL = '{{ url("{$ADMIN}") }}';
            var pid = null;
            var cid = null;

            bindClick();

            $('#createProduction').click(function () {
                var createButton = $(this);
                var name = $('#name').val();
                var alias = $('#alias').val();
                var series_id = $('#series_id').val();
                var cover_id = $('#cover_id').val();
                console.log(series_id);

                $.ajax({
                    url: '{{ url("{$ADMIN}/production/store") }}',
                    data: {
                        name: name,
                        alias: alias,
                        series_id: series_id,
                        cover_id: cover_id
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success == 0) {
                            var button = $('button[data-target=#myModal]');
                            pid = data.production_id;
                            button.removeAttr('disabled');
                            createButton.attr('disabled', 'true');
                        }
                    }
                });
            });

            $('#createColor').click(function () {
                var colorName = $('#color').val();
                var price = $('#price').val();
                var alias = $('#color_alias').val();

                $.ajax({
                    url: ADMINURL + '/production/' + pid + '/color/store',
                    data: {
                        name: colorName,
                        price: price,
                        alias: alias
                    },
                    success:function(data) {
                        if(data.success == 0) {
                            cid = data.color_id;
                            createColor(colorName);
                        } else {
                            alert('创建款式失败，没有该商品！');
                        }
                    }
                });
            });

            /**
             * 创建款式
             */
            function createColor(colorName) {
                var colorTemplate = $($('#colorTemplate').html());
                colorTemplate.find('.panel-title').html(colorName);

                $(colorTemplate).find('button[data-target=#image]').on('click', function () {
                    container = $(colorTemplate);
                });
                $(colorTemplate).find('button[data-name=createSize]').click(createSize);
                $(colorTemplate).find('button[data-name=submit]').click(function(){
                    var wrapper = $(this).parent().prev();
                    submitImage(wrapper);
                    submitSize(wrapper);
                });

                //hide the modal
                $('#myModal').modal('hide');
                $container.append(colorTemplate);
            }

            //submit
            function submitSize(container) {
                container = $(container).children('div[data-name=size]');
                var sizeInput = $(container).find('select');
                var quantityInput = $(container).find('input');
                var data = new Object();

                for(var i = 0; i < sizeInput.length; i ++) {
                    data['size[' + i + ']'] = sizeInput[i].value;
                    data['quantity[' + i + ']'] = quantityInput[i].value;
                }

                if(pid == 'undefined' || pid == null) {
                    alert('保存尺码失败，没有该商品！');
                    return ;
                }

                if(cid == 'undefined' || cid == null) {
                    alert('保存尺码失败，没有该款式');
                    return ;
                }

                $.ajax({
                    url: ADMINURL + '/production/' + pid + '/color/' + cid + '/size/store',
                    data: data,
                    success: function(data) {
                        if(data.success == 0) {
                            alert('操作成功');
                        } else if(data.error == 0) {
                            alert(data.message);
                        }
                    }
                });
            }

            function submitImage(container){
                container = $(container).children('div[data-name=image]');
                var image_id = $(container).find('input[type=hidden]');
                var type = $(container).find('select');
                var data = new Object();

                for(var i = 0; i < image_id.length; i ++) {
                    data['images_id[' + i + ']'] = image_id[i].value;
                    data['primary[' + i + ']'] = type[i].value;
                }


                if(pid == 'undefined' || pid == null) {
                    alert('保存尺码失败，没有该商品！');
                    return ;
                }

                if(cid == 'undefined' || cid == null) {
                    alert('保存尺码失败，没有该款式');
                    return ;
                }

                $.ajax({
                    url: ADMINURL + '/production/' + pid + '/color/' + cid + '/image/store',
                    data: data,
                    success: function(data) {
                        if(data.success == 0) {
                            alert('操作成功');
                        } else if(data.error == 0 && (data.message != 'undefined')) {
                            alert(data.message);
                        }
                    }
                });
            }

            function createSize() {
                var sizeTemplate = $('#sizeTemplate').html();
                var self = $(this).parent().prev();
                $(self).find('div[data-name=size]').append(sizeTemplate);
            }

            function bindClick() {
                $('.image-content ul li').each(function (i, ele) {
                    $(ele).click(function () {
                        $('#image').modal('hide');

                        if (container == null) {
                            alert('警告！没选择对象!');
                            return;
                        }

                        var imageTemplate = $($('#imageTemplate').html());
                        var imageName = $(this).html();
                        var imageId = $(this).attr('data-id');
                        var inputName = $(imageTemplate).find('input[name=name]');
                        var inputId = $(imageTemplate).find('input[type=hidden]');

                        inputName = $(inputName[0]);
                        inputId = $(inputId[0]);

                        inputName.val(imageName);
                        inputId.val(imageId);

                        $(container).find('div[data-name=image]').append(imageTemplate);
                    });
                });
            }
        });
    </script>
@endsection