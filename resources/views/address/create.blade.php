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
            <form action="{{ url('address/store') }}" method="post">
                {!! csrf_field() !!}
                <div class="input-group">
                    <label for="contact">联系人：</label>
                    <input type="text" name="contact" id="contact">
                </div>
                <div class="input-group">
                    <label for="tel">联系电话：</label>
                    <input type="tel" name="phone" id="phone">
                </div>
                <div class="input-group">
                    <label>联系地址：</label>
                    <div class="address">
                        <div class="adreee-selete">
                            <select id="Province" name="area1"></select>
                            <select id="City" name="area2"></select>
                            <select id="Area" name="area3"></select>
                        </div>
                        <textarea name="address"></textarea>
                    </div>
                </div>

                <button id="create" class="btn button full confirm-address" type="submit">
                    确认收货信息
                </button>
            </form>
        </div>
    </div>
@endsection

