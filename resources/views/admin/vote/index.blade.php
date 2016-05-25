@extends('admin.template.template')

@section('title', '投票结果 - 魔豆树')

@section('header', '投票结果')

@section('content')
    <div class="row">
        <div class="col col-md-10 col-md-offset-1">
            <table class="table table-bordered" width="100%">
                <thead>
                <tr>
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                    <th>E</th>
                    <th>F</th>
                    <th>G</th>
                    <th>H</th>
                    <th>I</th>
                    <th>J</th>
                    <th>总票数</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $vote->A }} <strong>({{ $vote->A/$vote->total*100 }}%)</strong></td>
                    <td>{{ $vote->B }} <strong>({{ $vote->B/$vote->total*100 }}%)</strong></td>
                    <td>{{ $vote->C }} <strong>({{ $vote->C/$vote->total*100 }}%)</strong></td>
                    <td>{{ $vote->D }} <strong>({{ $vote->D/$vote->total*100 }}%)</strong></td>
                    <td>{{ $vote->E }} <strong>({{ $vote->E/$vote->total*100 }}%)</strong></td>
                    <td>{{ $vote->F }} <strong>({{ $vote->F/$vote->total*100 }}%)</strong></td>
                    <td>{{ $vote->G }} <strong>({{ $vote->G/$vote->total*100 }}%)</strong></td>
                    <td>{{ $vote->H }} <strong>({{ $vote->H/$vote->total*100 }}%)</strong></td>
                    <td>{{ $vote->I }} <strong>({{ $vote->I/$vote->total*100 }}%)</strong></td>
                    <td>{{ $vote->J }} <strong>({{ $vote->J/$vote->total*100 }}%)</strong></td>
                    <td><strong>{{ $vote->total }}</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" style="margin: 2em;">
        <div class="col col-md-10 col-md-offset-1">
            <table id="result" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>
                    <th>昵称</th>
                    <th>结果1</th>
                    <th>结果2</th>
                    <th>理由</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>昵称</th>
                    <th>结果1</th>
                    <th>结果2</th>
                    <th>理由</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($result as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->user->nickname }}</td>
                        <td>{{ $item->result_a }}</td>
                        <td>{{ $item->result_b }}</td>
                        <td>{{ $item->reason }}</td>
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
            $('#result').DataTable();
        });
    </script>
@endsection

@section('moreCss')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/jquery.dataTables.min.css">
@endsection