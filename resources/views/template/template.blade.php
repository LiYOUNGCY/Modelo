@extends('template.basic')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/bootstrap.min.css?v={{time()}}">
    <link rel="stylesheet" href="{{ asset('assets') }}/font-awesome/css/font-awesome.min.css?">
    @yield('moreCss')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/base.css?v={{time()}}">
@endsection

@section('script')
    <script src="{{ asset('assets') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js') }}/public.js"></script>
    @yield('moreScript')
@endsection
