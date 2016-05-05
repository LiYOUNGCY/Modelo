@extends('template.template')

@section('title', "编辑收货地址 - 魔豆树")

@section('body')
    <div class="wrapper">
        <div class="m-head">
            <div class="m-name">In Mods' Code</div>
            <div class="icon-group">
                <div class="l-icon fl">
                    <a href="javascript:history.go(-1);"><span class="fa fa-reply fl"></span></a>
                </div>
                <div class="r-icon fr show-nav">
                    <span class="fa fa-navicon"></span>
                </div>
            </div>
        </div>

        <div class="m-title-usual">
            填写收货地址
        </div>
        <form action="{{ url('address/store') }}" method="post">
            {!! csrf_field() !!}
            <div class="m-edit-address">
                <div class="input-group">
                    <label for="contact">联系人：</label>
                    <input type="text" name="contact" id="contact">
                </div>
                <div class="input-group">
                    <label for="phone">联系电话：</label>
                    <input type="tel" name="phone" id="phone">
                </div>
                <div class="input-group">
                    <label for="address">联系地址：</label>
                    <div class="address">
                        <div class="adreee-selete">
                            <select id="Province" name="area1"></select>
                            <select id="City" name="area2"></select>
                            <select id="Area" name="area3"></select>
                        </div>
                        <textarea name="address" id="address"></textarea>
                    </div>
                </div>
            </div>
            <button class="btn full confirm-address">确认收货地址</button>
        </form>
    </div>
@endsection

@section('moreScript')
    <script src="{{ asset('assets/js/address.js') }}"></script>
    <script>
        addressInit('Province', 'City', 'Area');
        $(".confirm-address").bind('click', function () {
            var Contact = $("#contact").val();
            var Tel = $("#phone").val();
            var Address = $("#address").val();
            var reg = /(^13\d{9}$)|(^14)[5,7]\d{8}$|(^15[0,1,2,3,5,6,7,8,9]\d{8}$)|(^17)[6,7,8]\d{8}$|(^18\d{9}$)/g;

            if (Contact == "" || Tel == "" || Address == "") {
                showModalDialog("请输入完整的收货信息");
                return;
            }
            if (Contact.length > 10) {
                showModalDialog("联系人字数不得超过10");
                return;
            } else if (!reg.test(Tel)) {
                showModalDialog("无效的手机号码");
                return;
            }

            $('form').submit();
        });
        function showModalDialog(text) {
            var modal = '' +
                    '<div class="m-modal"><div class="block"><p>' + text + '</p><p style="color: #5c595c">（点击关闭）</p></div></div>';
            $("body").prepend($(modal));
            $("body").on('click', ".m-modal", function () {
                $(this).remove();
            });
        }
    </script>
@endsection

