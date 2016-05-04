<!DOCTYPE html>
<html lang="cmn-Hans-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <meta name="_token" content="{!! csrf_token() !!}">
    {{--<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />--}}
    {{--<meta http-equiv="Pragma" content="no-cache" />--}}
    {{--<meta http-equiv="Expires" content="0" />--}}
    {{--<!--指示IE以目前可用的最高模式显示内容-->--}}
    {{--<meta http-equiv="X-UA-Compatible" content="IE=edge">--}}
    {{--<!--指示360浏览器使用极速模式-->--}}
    {{--<meta name="renderer" content="webkit">--}}
    {{--<!--禁止百度缓存-->--}}
    {{--<meta http-equiv="Cache-Control" content="no-siteapp">--}}

    {{--<!--手机模式访问网站配置-->--}}
    {{--<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->--}}
    {{--<!--apple设备优化-->--}}
    {{--<meta name="apple-mobile-web-app-capable" content="yes">--}}
    {{--<meta name="apple-mobile-web-app-title" content="MODELO-魔豆树">--}}

    {{--<!-- 针对手持设备优化，主要是针对一些老的不识别viewport的浏览器，比如黑莓 -->--}}
    {{--<meta name="HandheldFriendly" content="true">--}}
    {{--<meta name="MobileOptimized" content="320"><!-- 微软的老式浏览器 -->--}}
    {{--<!--<meta name="screen-orientation" content="portrait"> uc强制竖屏 -->--}}
    {{--<!-- <meta name="x5-orientation" content="portrait">QQ强制竖屏 -->--}}
    {{--<meta name="full-screen" content="yes"><!-- UC强制全屏 -->--}}
    {{--<meta name="x5-fullscreen" content="true"><!-- QQ强制全屏 -->--}}
    {{--<meta name="browsermode" content="application"><!-- UC应用模式 -->--}}
    {{--<meta name="x5-page-mode" content="app"><!-- QQ应用模式 -->--}}
    {{--<meta name="msapplication-tap-highlight" content="no"><!-- windows phone 点击无高光 -->--}}
    {{--<meta content="yes" name="apple-mobile-web-app-capable">--}}
    {{--<meta content="yes" name="apple-touch-fullscreen">--}}
    {{--<meta content="telephone=no,email=no" name="format-detection">--}}
    <title>@yield('title')</title>
    @yield('css')
</head>

<body>
@yield('body')
@yield('modal')

<script src="{{ asset('assets') }}/js/jquery.js"></script>
<script>
    var _token = $('meta[name=_token]').attr('content');
    var BASEURL = '{{ asset("/") }}/';
    var IMAGES = '{{ asset("images/") }}/';
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