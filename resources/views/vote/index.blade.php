@extends('template.template')

@section('title', '参与投票抽奖 - 魔豆树')

@section('body')
    <div class="v-logo">
        <img src="img/logo.png">
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
        <div class="vote-list">
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo1" value="A">
                        <label for="VoteNo1">花裙子</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo2" value="B">
                        <label for="VoteNo2">花裙子</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo3" value="C">
                        <label for="VoteNo3">花裙子</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo4" value="D">
                        <label for="VoteNo4">花裙子</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo5" value="E">
                        <label for="VoteNo5">花裙子</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo6" value="F">
                        <label for="VoteNo6">花裙子</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo7" value="G">
                        <label for="VoteNo7">花裙子</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo8" value="H">
                        <label for="VoteNo8">花裙子</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo9" value="I">
                        <label for="VoteNo9">花裙子</label>
                    </div>
                </div>
            </div>
            <div class="vote-item">
                <div class="vote-info">
                    <img src="{{ asset('assets/images') }}/all-goods1.jpeg" data-action="zoom">
                    <div class="vote-name">
                        <input type="radio" name="vote" id="VoteNo10" value="J">
                        <label for="VoteNo10">花裙子</label>
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

@section('moreScript')
    <script src="{{ asset('assets/js') }}/zoom.min.js"></script>
    <script>
        $(function () {
            $("input[name='vote']").click(function () {
                $(".vote-item").removeClass("active");
//            if($(this).is(":checked")){
//
//            }
                $(this).parents(".vote-item").addClass("active");
            })

            $('#btn').click(function () {
                var val = $('input:radio:checked');
                if(val.length == 0) {
                    showModalDialog('请选择一个进行投票!');
                } else {
                    $('form').submit();
                }
            })
        })
    </script>
@endsection

@section('moreCss')
    <link rel="stylesheet" href="{{ asset('assets/css') }}/zoom.css">
    <link rel="stylesheet" href="{{ asset('assets/css') }}/vote.css">
@endsection