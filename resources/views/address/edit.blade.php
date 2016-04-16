@extends('template.template')

@section('title', "编辑收货地址 - 魔豆树")

@section('body')
    <div class="wrapper">
        <div class="block-w withback-title">
            <a href="javascript:history.go(-1);">
                <div class="button back">返回</div>
            </a>
            填写收货信息
        </div>
        <div class="block-w editaddress-form">
            <form action="{{ url("address/{$userAddress->id}") }}" method="post">
                {!! csrf_field() !!}
                <div class="input-group">
                    <label for="contact">联系人：</label>
                    <input type="text" name="contact" id="contact" value="{{ $userAddress->contact }}">
                </div>
                <div class="input-group">
                    <label for="tel">联系电话：</label>
                    <input type="tel" name="phone" id="phone" value="{{ $userAddress->phone }}">
                </div>
                <div class="input-group">
                    <label>联系地址：</label>
                    <div class="address">
                        <div class="adreee-selete">
                            <select id="Province" name="area1"></select>
                            <select id="City" name="area2"></select>
                            <select id="Area" name="area3"></select>
                        </div>
                        <textarea id="address" name="address"></textarea>
                    </div>
                </div>

                <button id="update" class="btn button full confirm-address" type="button">
                    确认收货信息
                </button>
            </form>
        </div>
    </div>
@endsection

@section('moreScript')
    <script src="{{ url('assets') }}/js/address.js"></script>
    <script type="text/javascript">
        addressInit('Province', 'City', 'Area');
        $("#update").bind('click', function () {
            var Contact = $("#contact").val();
            var Tel = $("#phone").val();
            var Address = $("#address").val();
            var reg = /(^13\d{9}$)|(^14)[5,7]\d{8}$|(^15[0,1,2,3,5,6,7,8,9]\d{8}$)|(^17)[6,7,8]\d{8}$|(^18\d{9}$)/g;

            if (isNull(Contact) || isNull(Tel) || isNull(Address)) {
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

        function isNull(val) {
            return (val == null || val == 'undefined');
        }
    </script>
@endsection
