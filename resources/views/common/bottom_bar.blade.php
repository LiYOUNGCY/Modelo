<div class="m-bottom-bar">
    <div class="col" id="theme">
        <span class="fa fa-shopping-bag"></span> 按主题搜索
        <div class="popup hide">
            <div class="item">
                VERY 90s' FOR MOTHER'S DAY
            </div>
            <div class="item">
                VERY 90s' FOR MOTHER'S DAY
            </div>
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
            <a class="item" href="{{ url("production") }}?c={{ \Illuminate\Support\Facades\Config::get('constants.category.up') }}" style="display: block;">
                上身
            </a>
            <a class="item" href="{{ url("production") }}?c={{ \Illuminate\Support\Facades\Config::get('constants.category.down') }}" style="display: block;">
                下身
            </a>
            <a class="item" href="{{ url("production") }}?c={{ \Illuminate\Support\Facades\Config::get('constants.category.upAndDown') }}" style="display: block;">
                连体
            </a>
        </div>
    </div>
    <div class="cf"></div>
</div>