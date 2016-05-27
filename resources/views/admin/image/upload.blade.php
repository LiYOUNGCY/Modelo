@extends('admin.template.template')

@section('title', '多图片 - 魔豆树')

@section('header', '多图片')

@section('content')
    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="images[]" multiple>
    </span>

    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
@endsection

@section('moreScript')
    <script src="{{ asset("assets") }}/js/jquery.ui.widget.js"></script>
    <script src="{{ asset("assets") }}/js/jquery.iframe-transport.js"></script>
    <script src="{{ asset("assets") }}/js/jquery.fileupload.js"></script>
    <script>
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = window.location.hostname === 'blueimp.github.io' ?
                    '//jquery-file-upload.appspot.com/' : 'server/php/';
            $('#fileupload').fileupload({
                url: '{{ url("{$ADMIN}/ajax/image/store") }}',
                dataType: 'json',
                done: function (e, data) {
                    $.each(data.result.files, function (index, file) {
                        $('<p/>').text(file.name).appendTo('#files');
                    });
                },
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                    );
                }
            }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });
    </script>
@endsection

@section('moreCss')
    <link rel="stylesheet" href="{{ asset('assets') }}/css/jquery.fileupload.css">
@endsection