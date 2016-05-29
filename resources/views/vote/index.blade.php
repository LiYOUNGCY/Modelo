@extends('template.basic')

@section('title', '参与投票抽奖 - 魔豆树')

@section('body')

    <div class="v-logo">
        <img src="{{ asset('assets/images') }}/logo.jpg">
    </div>
    <!---->
    <div class="v-title">
        <p>魔豆觉醒月</p>
        <p>一次投票，双重礼遇</p>
    </div>
    <div class="v-block">
        <p>
            活动说明：
        </p>
        <p>
            这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明这是活动说明
        </p>
    </div>
    <!---->

    <form action="{{ url('vote') }}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="reason" id="reason">
        <div class="vote-list">
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/1.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo1" value="A">
                        <label for="VoteNo1">白色府绸长衬衣</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/2.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo2" value="B">
                        <label for="VoteNo2">藏青亚麻上衣</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/3.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo3" value="C">
                        <label for="VoteNo3">缎面印花半身裙</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/4.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo4" value="D">
                        <label for="VoteNo4">黑白前后拼色连衣裙</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/5.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo5" value="E">
                        <label for="VoteNo5">后镂空针织连衣裙</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/6.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo6" value="F">
                        <label for="VoteNo6">黑色雪纺连体裤</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/7.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo7" value="G">
                        <label for="VoteNo7">印花背心连衣长裙</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/8.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo8" value="H">
                        <label for="VoteNo8">亚麻短上衣</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/9.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo9" value="I">
                        <label for="VoteNo9">亚麻风琴褶阔腿裤</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/vote/10.jpg">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo10" value="J">
                        <label for="VoteNo10">印花雪纺长衬衣</label>
                    </div>
                </div>
            </div>
            <div class="cf"></div>
        </div>
        <div class="button" id="btn">投票</div>
    </form>

    <div class="follow">
        <img src="{{ asset('assets') }}/images/qrcode.jpg">
        <div class="text">
            关注我们
        </div>
        <div class="name">
            In Mods' Code 魔豆树
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/js') }}/voteImg.js"></script>
    <script>
        $(function () {
            $(".vote-list img").bind('click',function () {
                var src = $(this).attr("src");
                var content = '<div class="vote-img">' +
                        '<div class="img-box">' +
                        '<img src="' + src +'">' +
                        '</div>' +
                        '</div>';
                $("body").prepend(content);
                $(".vote-img").bind('touchend',function (event) {
                    event.preventDefault();
                    $(this).remove();
                })
            });

            $("input[name='vote']").click(function () {
                $(".vote-item").removeClass("active");
                $(this).parents(".vote-item").addClass("active");
            });
            $('#btn').bind('touchend',function (event) {
                event.preventDefault();
                var val = $('input:radio:checked');
                if(val.length == 0) {
                    alert('请选择一个进行投票!')
                } else {
                    var message_Content = '<div class="vote-message">' +
                            '<div class="box">' +
                            '<div class="top">' +
                            '<span class="left">投票留言</span>' +
                            '<span class="right" id="skip">跳过</span>' +
                            '</div>' +
                            '<textarea name="message" id="message" placeholder="你为什么会选_?"></textarea>' +
                            '<div class="button" id="submitMessage">提交</div>' +
                            '</div>' +
                            '</div>';
                    $('body').prepend(message_Content);

                    $("#skip").bind('touchend', function () {
                        $(this).parents(".vote-message").remove();
                        $('form').submit();
                    })
                    $("#submitMessage").bind('touchend', function () {
                        $('#reason').val($('#message').val());
                        $('form').submit();
                    })

                }
            })
//            $('#btn').click(function () {
//                var val = $('input:radio:checked');
//                if(val.length == 0) {
//                    showModalDialog('请选择一个进行投票!');
//                } else {
//                    $('form').submit();
//                }
//            })
        })
    </script>
@endsection

@section('css')
    {{--<link rel="stylesheet" href="{{ asset('assets/css') }}/zoom.css">--}}
    <link rel="stylesheet" href="{{ asset('assets/css') }}/vote.css">
@endsection
