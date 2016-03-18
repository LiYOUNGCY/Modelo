<!DOCTYPE html>
<html lang="cmn-Hans-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="_token" content="{!! csrf_token() !!}">
    <title>@yield('title')</title>
    @yield('css')
</head>

<body>
@yield('body')
@yield('modal')

<script src="{{ asset('assets') }}/js/jquery.js"></script>
<script>
    var _token = $('meta[name=_token]').attr('content');
    $.ajaxSetup({
        data: {
            _token: _token
        },
        type: 'POST',
        dataType: 'JSON',
        error: function (data) {
            console.log(data);
            alert('网络错误！');
        }
    });
</script>
@yield('script')
</body>
</html>