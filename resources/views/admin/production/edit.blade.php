@extends('admin.template.template')

@section('title', '修改服装信息 - 魔豆树')

@section('header', '修改服装信息')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1" id="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">修改服装信息</h3>
                </div>
                <div class="panel-body">
                    <form id="productionFrom" action="{{ url('production/store') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="name">服装名称：</label>
                            <input class="form-control" id="name" name="name" value="{{ $production->name }}">
                        </div>
                        <div class="form-group">
                            <label for="series_id">所属系列：</label>
                            <select name="series_id" id="series_id" class="form-control">
                                @foreach($series as $s)
                                    @if($s->id == $production->series_id)
                                        <option value="{{ $s->id }}" selected>{{ $s->name }}</option>
                                    @else
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">封面图：</label>
                            <select name="cover_id" id="cover_id" class="form-control">
                                @foreach($images as $image)
                                    @if($image->id == $production->cover_id)
                                        <option value="{{ $image->id }}" selected>{{ $image->name }}</option>
                                    @else
                                        <option value="{{ $image->id }}">{{ $image->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">主题图：</label>
                            <select name="series_image" id="series_image" class="form-control">
                                @foreach($images as $image)
                                    @if($image->id == $production->series_image)
                                        <option value="{{ $image->id }}" selected>{{ $image->name }}</option>
                                    @else
                                        <option value="{{ $image->id }}">{{ $image->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">成分说明图：</label>
                            <select name="fabric_info_id" id="fabric_info_id" class="form-control">
                                @foreach($images as $image)
                                    @if($image->id == $production->fabric_info_id)
                                        <option value="{{ $image->id }}" selected>{{ $image->name }}</option>
                                    @else
                                        <option value="{{ $image->id }}">{{ $image->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">尺码说明图：</label>
                            <select name="size_info_id" id="size_info_id" class="form-control">
                                @foreach($images as $image)
                                    @if($image->id == $production->size_info_id)
                                        <option value="{{ $image->id }}" selected>{{ $image->name }}</option>
                                    @else
                                        <option value="{{ $image->id }}">{{ $image->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cover_id">分类:</label>
                            @foreach($categories as $category)
                                <?php $flag = false; ?>
                                @foreach($productionCategory as $value)
                                    @if($value->category_id == $category->id)
                                        <?php $flag = true; ?>
                                    @endif
                                @endforeach

                                <label class="checkbox-inline">
                                    @if($flag)
                                        <input type="checkbox" value="{{ $category->id }}" name="category[]"
                                               checked>{{ $category->name }}
                                    @else
                                        <input type="checkbox" value="{{ $category->id }}"
                                               name="category[]">{{ $category->name }}
                                    @endif
                                </label>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-success" id="createColor">
                        添加款式
                    </button>
                </div>
            </div>

            {{-- 款式 --}}
            @foreach($productionColors as $productionColor)
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <h3 class="panel-title"></h3>
                    </div>
                    <div class="panel-body">
                        <form data-name="colorForm" data-id="{{ $productionColor->id }}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="colorName">款式名称：</label>
                                <input class="form-control" id="colorName" name="colorName" placeholder="迷彩绿"
                                       value="{{ $productionColor->name }}">
                            </div>
                            <div class="form-group">
                                <label for="colorImage">款式图片：</label>
                                <select class="form-control" id="colorImage" name="colorImage">
                                    @foreach($images as $image)
                                        @if($image->id == $productionColor->image_id)
                                            <option value="{{ $image->id }}" selected>{{ $image->name }}</option>
                                        @else
                                            <option value="{{ $image->id }}">{{ $image->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="colorName">款式价格：</label>
                                <input class="form-control" id="colorPrice" name="colorPrice" placeholder="99.99"
                                       value="{{ $productionColor->price }}">
                            </div>

                            <div data-name="size">
                                @foreach($productionSizes[$productionColor->id] as $productionSize)
                                    <div class="form-inline" style="margin-top: .5em;"
                                         data-id="{{ $productionSize->id }}">
                                        <input type="hidden" name="sizeId[]" value="{{ $productionSize->id }}">
                                        <div class="form-group">
                                            <label>尺码：</label>
                                            <input type="text" name="size[]" class="form-control" data-name="size"
                                                   value="{{ $productionSize->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label>库存：</label>
                                            <input class="form-control" name="quantity[]" data-name="quantity"
                                                   value="{{ $productionSize->quantity }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>添加库存：</label>
                                            <input class="form-control" name="amount[]" data-name="quantity"
                                                   value="0">
                                        </div>
                                        <button class="btn btn-danger" type="button" data-name="sizeDelete">删除</button>
                                    </div>
                                @endforeach
                            </div>

                            <div data-name="image">
                                @foreach($productionImages[$productionColor->id] as $productionImage)
                                    <div class="form-inline" style="margin-top: .5em;"
                                         data-id="{{ $productionImage->id }}">
                                        <input type="hidden" name="imageId[]" value="{{ $productionImage->id }}">
                                        <div class="form-group">
                                            <label for="colorImage">图片：</label>
                                            <select class="form-control" id="colorImage" name="image[]">
                                                @foreach($images as $image)
                                                    @if($image->id == $productionImage->image_id)
                                                        <option value="{{ $image->id }}"
                                                                selected>{{ $image->name }}</option>
                                                    @else
                                                        <option value="{{ $image->id }}">{{ $image->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <button class="btn btn-danger" type="button" data-name="imageDelete">删除</button>
                                    </div>
                                @endforeach
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
                        <button type="button" class="btn btn-danger" data-name="colorDelete" data-id="{{ $productionColor->id }}">
                            删除该款式
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <button class="btn btn-success" type="button" id="save"
                    style="width: 100%; display: block; margin: 0 auto; margin-bottom: 2em;;">
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
            <input type="hidden" name="sizeId[]" value="0">
            <div class="form-group">
                <label>尺码：</label>
                <input type="text" name="size[]" class="form-control" data-name="size">
            </div>
            <div class="form-group">
                <label>库存：</label>
                <input class="form-control" name="quantity[]" data-name="quantity">
                <input class="form-control" name="amount[]" value="0" type="hidden">
            </div>
            <button class="btn btn-danger" type="button" data-name="delete">删除</button>
        </div>
    </template>

    <template id="imageTemplate">
        <div class="form-inline" style="margin-top: .5em;">
            <input type="hidden" name="imageId[]" value="0">
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
            var $container = $('#container');
            var productionId = {{ $production->id }};
            //删除池
            var sizePool = [];
            var imagePool = [];
            var colorPool = [];

            //init
            registerEvent($container);
            registerDeleteEvent();
            //end init

            //添加款式
            $('#createColor').click(function () {
                createColor();
            });

            function createColor() {
                var $colorTemplate = $($('#colorTemplate').html());

                //注册事件
                registerEvent($colorTemplate);

                $container.append($colorTemplate);
            }

            function registerEvent($wrapper) {
                //注册事件
                $wrapper.find('button[data-name=createSize]').click(function () {
                    var $sizeTemplate = $($('#sizeTemplate').html());
                    $sizeTemplate.find('button[data-name=delete]').click(function () {
                        $(this).parent().remove();
                    });
                    $(this).parent().prev().find('div[data-name=size]').append($sizeTemplate);
                });

                $wrapper.find('button[data-name=createImage]').click(function () {
                    var $imageTemplate = $($('#imageTemplate').html());
                    $imageTemplate.find('button[data-name=delete]').click(function () {
                        $(this).parent().remove();
                    });
                    $(this).parent().prev().find('div[data-name=image]').append($imageTemplate);
                });
            }

            function registerDeleteEvent() {
                $('button[data-name=sizeDelete]').click(function () {
                    var id = $(this).parent().attr('data-id');
                    sizePool.push(id);
                    console.log(sizePool);
                    $(this).parent().remove();
                });

                $('button[data-name=imageDelete]').click(function () {
                    var id = $(this).parent().attr('data-id');
                    imagePool.push(id);
                    console.log(imagePool);
                    $(this).parent().remove();
                });

                $('button[data-name=colorDelete]').click(function () {
                    var id = $(this).attr('data-id');
                    colorPool.push(id);
                    $(this).parent().parent().fadeOut();
                    $(this).parent().parent().remove();
                })
            }

            $('#save').click(function () {
                //先处理删除
                deleteSize();
                deleteImage();
                deleteColor();

                submitProduction();

                $('form[data-name=colorForm]').each(function () {
                    var colorId = $(this).attr('data-id');
                    if (!isNaN(colorId)) {
                        updateProductionColor($(this));
                    } else {
                        storeProductionColor($(this));
                    }
                });

                alert('成功保存');
                window.location.reload();
            });

            function submitProduction() {
                var production = $('#productionFrom').serialize();

                $.ajax({
                    url: ADMIN + '/production/' + productionId + '/update',
                    data: production,
                    type: 'post',
                    async: false,
                    success: function (data) {
                        console.log(data);
                    }
                });
            }

            function updateProductionColor(form) {
                var data = $(form).serialize();
                var colorId = $(form).attr('data-id');
                console.log(data);

                $.ajax({
                    url: ADMIN + '/color/' + colorId + '/update',
                    type: 'post',
                    async: false,
                    data: data,
                    success: function (data) {
                        console.log(data);
                    }
                });
            }

            function storeProductionColor(form) {
                var color = $(form).serialize();
                console.log(color);

                $.ajax({
                    url: ADMIN + '/production/' + productionId + '/color/store',
                    type: 'post',
                    async: false,
                    data: color,
                    success: function (data) {
                        console.log(data);
                        if (data.error == 0) {
                            alert('发生错误，请重新编辑！');
                        }
                    }
                });
            }

            function deleteColor() {
                for(var i in colorPool) {
                    var colorId = colorPool[i];
                    $.ajax({
                        url: ADMIN + '/color/' + colorId + '/destroy',
                        type: 'post',
                        success: function (data) {
                            console.log(data);
                        }
                    });
                }
            }

            function deleteImage() {
                for(var i in imagePool) {
                    var imageId = imagePool[i];
                    $.ajax({
                        url: ADMIN + '/production/image/' + imageId + '/destroy',
                        type: 'post',
                        success: function (data) {
                            console.log(data);
                        }
                    });
                }
            }

            function deleteSize() {
                for(var i in sizePool) {
                    var sizeId = sizePool[i];
                    $.ajax({
                        url: ADMIN + '/production/size/' + sizeId + '/destroy',
                        type: 'post',
                        success: function (data) {
                            console.log(data);
                        }
                    });
                }
            }
        })
    </script>
@endsection