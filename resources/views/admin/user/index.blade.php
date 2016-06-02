@extends('admin.template.template')

@section('title', '用户管理 - 魔豆树')

@section('header', '用户管理')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table id="order" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>昵称</th>
                    <th>性别</th>
                    <th>魔豆</th>
                    <th>推荐人</th>
                    <th>冻结金额</th>
                    <th>可用金额</th>
                    <th>总金额</th>
                    <th>关注时间</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>昵称</th>
                    <th>性别</th>
                    <th>魔豆</th>
                    <th>推荐人</th>
                    <th>冻结金额</th>
                    <th>可用金额</th>
                    <th>总金额</th>
                    <th>关注时间</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="{{ url("{$ADMIN}/user/{$user->id}") }}">{{ $user->id }}</a></td>
                        <td>{{ $user->nickname }}</td>
                        <td>{{ $user->sex == 1 ? '男': '女' }}</td>
                        <td>{{ $user->can_qrcode ? '是' : '否'}}</td>
                        <td>{{ $user->referee }}</td>
                        <td>{{ $user->freeze_total }}</td>
                        <td>{{ $user->available_total }}</td>
                        <td>{{ $user->total }}</td>
                        <td>{{ $user->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('moreScript')
    <script src="{{ asset('assets') }}/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('table').DataTable();
        });
    </script>
@endsection

@section('moreCss')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/jquery.dataTables.min.css">
@endsection