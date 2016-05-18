<!DOCTYPE html>
<html>
<head>
    <title>出错啦！ - 魔豆树</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <title>404 - 魔豆树</title>
    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 36px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        @if(! empty($exception->getMessage()))
            <div class="title">{{ $exception->getMessage() }}。<a href="{{ url('/') }}">回到首页</a></div>
        @else
            <div class="title">发生未知错误。<a href="{{ url('/') }}">回到首页</a></div>
        @endif
    </div>
</div>
</body>
</html>
