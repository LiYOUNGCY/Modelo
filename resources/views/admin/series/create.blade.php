@extends('admin.template.template')

@section('title', '创建系列 - 魔豆树')

@section('header', '创建系列')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <form action="{{ url("{$ADMIN}/series/store") }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group">
                    <label for="name">系列名称：</label>
                    <input class="form-control" id="name" name="name">
                </div>

                <div class="form-group">
                    <label id="alias">系列的别名：</label>
                    <input class="form-control" id="alias" name="alias">
                    <p class="help-block">系列的英文名称，只能填写数字、英文、下划线（必填）。</p>
                </div>

                <button type="submit" class="btn btn-success">提交</button>
            </form>
        </div>
    </div>
@endsection