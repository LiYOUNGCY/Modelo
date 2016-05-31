@extends('template.template')

@section('title', '我的二维码 - 魔豆树')

@section('body')
    <div class="wrapper qrcode-page">
        <div class="m-head">
            <div class="m-name">In Modss' Code</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="{{ url('user') }}"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-nav">
                    <span class="fa fa-navicon"></span>
                </div>
            </div>
        </div>

        <div class="share-photo-tips">
            <p>点击查看并保存图片</p>
        </div>
        <div class="share-photo-list">
            <div class="share-photo-item">
                <img src="{{ asset('assets/images') }}/vote/1.jpg">
            </div>
            <div class="share-photo-item">
                <img src="{{ asset('assets/images') }}/vote/2.jpg">
            </div>
            <div class="share-photo-item">
                <img src="{{ asset('assets/images') }}/vote/3.jpg">
            </div>
            <div class="share-photo-item">
                <img src="{{ asset('assets/images') }}/vote/4.jpg">
            </div>
            <div class="share-photo-item">
                <img src="{{ asset('assets/images') }}/vote/5.jpg">
            </div>
            <div class="share-photo-item">
                <img src="{{ asset('assets/images') }}/vote/6.jpg">
            </div>
            <div class="cf"></div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(function(){
        $(".share-photo-list img").bind('click',function () {
                var src = $(this).attr("src");
                var content = '<div class="share-photo">' +
                            '<img src="'+ src +'">' +
                            '<div class="close">关闭</div>' +
                            '<div class="tips">（长按保存图片）</div>' +
                            '</div>';
                $("body").prepend(content);
                $(".close").bind('touchend',function (event) {
                    event.preventDefault();
                    $(this).parent().remove();
                })
            });
    })
</script>
@endsection