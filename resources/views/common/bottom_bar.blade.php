<div class="m-bottom-bar">
    <div class="col" id="theme">
        <span class="fa fa-shopping-bag"></span> 按主题搜索
        <div class="popup hide">
            @foreach($series as $s)
            <div class="item">
                <a href="{{ url('theme') }}?s={{$s->id}}">{{$s->name}}</a>
            </div>
            @endforeach
            <div class="item nb">
                敬请期待
            </div>
        </div>
    </div>
    <div class="col" id="classify">
        <span class="fa fa-tags"></span> 商品分类
        <div class="popup hide">
            <div class="item fb">
                <a href="{{ url("production") }}">全部商品</a>
            </div>
            <div class="item">
                <a href="{{ url("production") }}?c={{ \Illuminate\Support\Facades\Config::get('constants.category.up') }}">上身</a>
            </div>
            <div class="item" >
                <a href="{{ url("production") }}?c={{ \Illuminate\Support\Facades\Config::get('constants.category.down') }}">下身</a>
            </div>
            <div class="item">
                <a href="{{ url("production") }}?c={{ \Illuminate\Support\Facades\Config::get('constants.category.upAndDown') }}">连体</a>
            </div>
        </div>
    </div>
    <div class="cf"></div>
</div>