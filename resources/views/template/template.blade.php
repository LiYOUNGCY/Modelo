@extends('template.basic')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/base.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/font-awesome/css/font-awesome.min.css">
    @yield('moreCss')
@endsection

@section('script')
    <script src="{{ asset('assets') }}/js/bootstrap.min.js"></script>
    @yield('moreScript')
@endsection