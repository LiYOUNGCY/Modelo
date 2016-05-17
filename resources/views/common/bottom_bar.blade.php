<div class="m-bottom-bar">
    <div class="col" id="theme">
        <div class="opt"><span class="fa fa-shopping-bag"></span> 按主题搜索</div>
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
        <div class="opt"><span class="fa fa-tags"></span> 商品分类</div>
        @if(isset($category))
            <div class="popup hide">
                @foreach(\Illuminate\Support\Facades\Config::get('constants.categoryName') as $key => $value)
                    @if($category == $key)
                        <a href="{{ url("production") }}?c={{ $key }}">
                        <div class="item fb">
                            {{ $value }}
                        </div>
                        </a>
                    @else
                        <a href="{{ url("production") }}?c={{ $key }}">
                        <div class="item @if($key == 3) nb @endif">
                            {{ $value }}
                        </div>
                        </a>
                    @endif
                @endforeach
            </div>
        @else
            <div class="popup hide">
                <a href="{{ url("production") }}">
                <div class="item">
                    全部商品
                </div>
                </a>
                <a href="{{ url("production") }}?c={{ \Illuminate\Support\Facades\Config::get('constants.category.up') }}">
                <div class="item">
                   上身
                </div>
                </a>
                <a href="{{ url("production") }}?c={{ \Illuminate\Support\Facades\Config::get('constants.category.down') }}">
                <div class="item">
                    下身
                </div>
                </a>
                <a href="{{ url("production") }}?c={{ \Illuminate\Support\Facades\Config::get('constants.category.upAndDown') }}">
                <div class="item nb">
                    连体
                </div>
                </a>
            </div>
        @endif
    </div>
    <div class="cf"></div>
</div>