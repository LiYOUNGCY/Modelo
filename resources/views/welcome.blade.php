@extends('template.basic')

@section('body')
    {!! QrCode::generate('Make me into a QrCode!') !!}
@endsection