@extends('admin.template.template')

@section('title', '编辑最新商品 - 魔豆树')

@section('header', '编辑最新商品')

@section('content')
    <div class="row">
        <button id="addRow" class="btn btn-success" type="button">添加列</button>
        <button id="store" class="btn btn-primary" type="button">保存</button>
    </div>

    <div class="wrapper" id="container"></div>
@endsection

@section('modal')
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label>偏移量（一个12列）</label>
                                <select class="form-control" id="offset">
                                    @for($i = 0; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col col-md-4">
                            <div class="form-group">
                                <label>占位（一个12列）</label>
                                <select class="form-control" id="size">
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-4">
                            <div class="form-group">
                                <label>类型</label>
                                <select class="form-control" id="type">
                                    <option value="1">图片</option>
                                    <option value="2">商品链接</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-md-offset-1 col-md-10" id="contentW">
                            <div class="form-group">
                                <label>内容</label>
                                <select class="form-control" id="content">
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-offset-1 col-md-10">
                            <div class="form-group">
                                <label>图片链接</label>
                                <select class="form-control" id="imageUrl">
                                </select>
                            </div>
                        </div>

                        <div class="col col-md-offset-1 col-md-10">
                            <div class="form-group">
                                <label for="">商品链接文字</label>
                                <input type="text" class="form-control" id="productionText">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" id="confirm">确定</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('moreScript')
    <script src="{{ asset('assets') }}/js/latest.edit.js"></script>
    <script>
        $(document).ready(function () {
            var container = $('#container');
            var wrapper = new Wrapper(container);

            $('#addRow').click(function () {
                wrapper.createRow();
            });

            $('#confirm').click(function () {
                var size = $('#size').val();
                var offset = $('#offset').val();
                var type = $('#type').val();
                var content = $('#content').val();
                var url = $('#imageUrl').val();
                var productionText = $('#productionText').val();

                wrapper.createColumn({
                    'size': size,
                    'offset': offset,
                    'type': type,
                    'content': content,
                    'url': url,
                    'productionText': productionText
                });

                $('#myModal').modal('hide');
            });

            $('#type').change(getByContent);

            function getByContent() {
                var type = $('#type').val();
                var container = $('#content');
                var imageUrl = $('#imageUrl');
                var productionText = $('#productionText');
                container.empty();

                //如果是插入图片
                if (type == 1) {
                    var images = getImages();
                    productionText.attr('disabled', true);
                    for (var i in images) {
                        var image = images[i];
                        var value = image.path + ',' + image.name;
                        container.append('<option value="' + value + '">' + image.name + '</option>');
                    }

                    var productions = getProduction();

                    imageUrl.empty();
                    for (var i in productions) {
                        var production = productions[i];
                        var value = BASEURL + 'production/' + production.id;
                        imageUrl.append('<option value="' + value + '">' + production.name + '</option>');
                    }
                } else if (type == 2) {
                    //如果是插入链接
                    var productions = getProduction();
                    for (var i in productions) {
                        var production = productions[i];
                        var value = BASEURL + 'production/' + production.id + ',' + production.name;
                        container.append('<option value="' + value + '">' + production.name + '</option>');
                    }
                    productionText.attr('disabled', false);
                    imageUrl.empty();
                }
            }

            getByContent();

            function getImages() {
                var images = '';

                $.ajax({
                    url: ADMIN + 'ajax/image',
                    async: false,
                    success: function (data) {
                        if (data.success == 0) {
                            images = data.data;
                            console.log(images);
                        }
                    }
                });

                return images;
            }

            function getProduction() {
                var production = '';

                $.ajax({
                    url: ADMIN + 'ajax/production',
                    async: false,
                    success: function (data) {
                        if (data.success == 0) {
                            production = data.data;
                            console.log(production);
                        }
                    }
                });

                return production;
            }

            $('#store').click(function () {
                console.log('click');
                wrapper.submit();
            });
        });
    </script>
@endsection

@section('moreCss')
    <style>
        .row[data-id] {
            border: .1em solid #EEEEEE;
            margin: 1em auto;
        }

        .create-col {
            padding: 1em;
            display: inline-block;
        }

        .create-col a {
            color: grey;

            cursor: pointer;
            text-decoration: none;
            outline: none;
            -webkit-transition: color .5s ease-in-out;
            -moz-transition: color .5s ease-in-out;
            -ms-transition: color .5s ease-in-out;
            -o-transition: color .5s ease-in-out;
            transition: color .5s ease-in-out;
        }

        .create-col a:hover,
        .create-col a:focus {
            color: black;
            text-decoration: none;
            outline: none;
        }

        .col img {
            display: block;
            max-width: 100%;
        }
    </style>
@endsection
