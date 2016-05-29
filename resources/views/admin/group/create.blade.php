@extends('admin.template.template')

@section('title', '创建商品组合 - 魔豆树')

@section('header', '创建商品组合')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <form action="{{ url("{$ADMIN}/group/store") }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="series_id">所属系列：</label>
                    <select name="series_id" id="series_id" class="form-control">
                        @foreach($series as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="image_id">封面图：</label>
                    <select name="image_id" id="image_id" class="form-control">
                        @foreach($images as $image)
                            <option value="{{ $image->id }}">{{ $image->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button id="store" type="button" class="btn btn-success">提交</button>
                <button id="add" type="button" class="btn btn-primary" disabled>添加商品到组合</button>
            </form>
        </div>
    </div>

    <div class="row" id="container" style="margin-top: 1em;">

    </div>

    <div class="row" style="margin-top: 1em;" id="saveAll">
        <div class="col col-md-10 col-md-offset-1">
            <button id="save" type="button" class="btn btn-primary">保存全部</button>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(function () {
            var group_id = '1';
            $('#saveAll').hide();

            $('#store').click(function () {
                var series_id = $('#series_id').val();
                var image_id = $('#image_id').val();
                console.log(series_id);
                console.log(image_id);

                $.ajax({
                    url: ADMIN + '/group/store',
                    data: {
                        series_id: series_id,
                        image_id: image_id
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.success == 0) {
                            group_id = data.group_id;
                            $('#add').removeAttr('disabled');
                            $('#saveAll').show();
                            alert('保存成功！请添加商品！');
                        }
                    }
                });
            });

            $('#add').click(function () {
                var goods = window.good();
                var msg = '';
                for (var i in goods) {
                    var good = goods[i];
                    console.log(good);
                    msg += '<option value=' + good.id + '>' + good.name + '</option>';
                }

                var wrap = $('<div class="col col-md-10 col-md-offset-1"> <div class="form-group"> <label>商品：</label> <select name="production_id" class="form-control"> ' + msg + '</select> </div> </div>');

                $('#container').append(wrap);
            });

            $('#save').click(function () {
                var data = [];

                $('select[name=production_id]').each(function(i, ele){
                    data.push($(ele).val());
                });

                console.log(data);
                if(group_id == null || group_id == 'undefined' || group_id == '') {
                    alert('错误！请保存商品组合');
                    return 0;
                }
                $.ajax({
                    url: ADMIN + '/group/production/store',
                    data: {
                        group_id: group_id,
                        production_id: data
                    },
                    success:function(data) {
                        console.log(data);
                        if(data.success == 0) {
                            alert('保存成功!');
                        }
                    }
                });
            });
        });

        function good() {
            var goods = [];
            $.ajax({
                url: ADMIN + '/ajax/production',
                async: false,
                success: function (data) {
                    if (data.success == 0) {
                        goods = data.data;
                    }
                }
            });
            return goods;
        }
    </script>
@endsection
