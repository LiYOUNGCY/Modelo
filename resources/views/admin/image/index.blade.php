@extends('admin.template.template')

@section('title', '图片 - 魔豆树')

@section('header', '图片')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <td>#</td>
                    <td>名称</td>
                    <td>路径</td>
                    <td>宽度</td>
                    <td>高度</td>
                    <td>创建时间</td>
                </tr>
                </thead>
                <tbody>
                @foreach($images as $image)
                    <tr data-id="{{ $image->id }}">
                        <td><a href="{{ url("{$ADMIN}/image/{$image->id}") }}">{{ $image->id }}</a></td>
                        <td>{{ $image->name }}</td>
                        <td>{{ $image->path }}</td>
                        <td>{{ $image->width }}</td>
                        <td>{{ $image->height }}</td>
                        <td>{{ $image->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection