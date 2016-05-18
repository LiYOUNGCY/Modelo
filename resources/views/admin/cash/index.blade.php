@extends('admin.template.template')

@section('title', '提现 - 魔豆树')

@section('header', '提现')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>用户</th>
                    <th>状态</th>
                    <th>金额</th>
                    <th>时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->user->nickname }}</td>
                        <td>{{ $value->status->name }}</td>
                        <td>{{ $value->cash }}</td>
                        <td>{{ $value->updated_at }}</td>
                        <td>
                            @if($value->status_id == \Illuminate\Support\Facades\Config::get('constants.CashStatus.pending'))
                                <button data-name="accept" class="btn btn-success" data-id="{{ $value->id }}">允许</button>
                                <button class="btn btn-danger">拒绝</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('moreScript')
    <script>
        $(function(){
            $('button[data-name=accept]').each(function(i, ele){
                $(ele).click(function(){
                    var id = $(this).attr('data-id');
                    $.ajax({
                        url: ADMIN + 'cash/accept',
                        data: { id: id},
                        success: function(data) {
                            console.log(data);
                            if(data.success == 0) {
                                window.location.reload();
                            }
                        }
                    });
                });
            });
        });
    </script>
@endsection