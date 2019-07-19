<style>
    .fixed-header{position:fixed;top:0;left:0;width:100%;height:37px;}
    select-catlist{width:100%;background:#292f36;postion:fixed;z-index:10;}
    .panel-groupselect{margin-bottom:0px!important;}
    .whitecolorbg{background:#fff;margin:10px;padding:10px;overflow:hidden;}
    .haddingcategory{background:#bfbfbf;margin:0px;padding:6px;font-size:14.5px;color:#000;text-align:center;text-shadow:2px 2px 2px rgb(134, 134, 134);font-weight:bold;text-transform:uppercase;}
    .productimgcat{width:100px;height:100px;margin:15px auto;border:1px solid #f8f8f8;align-items:center;display:flex;justify-content:center;overflow:hidden;border-radius:5px;}
    .imgproductsize{height:80px;width:auto;}
    .categorynametext{text-align:center;font-size:16px;color:#000;}
    .categorylink{margin:10px auto;padding:0;display:block;text-align:center;}
    .categorylink ul{margin:0 auto;padding:0;display:block;text-align:center;}
    .categorylink ul li{list-style:none;overflow:hidden;width:128px;text-align:left;margin:5px 5px 5px 5px;padding:10px 5px;display:inline-block;background:#f8f8f8;border:1px solid #c8c8c8;}
    .categorylink ul li a{margin:0;padding:0;font-size:13px;color:#008bca;text-decoration:none;}
    .categorylistmenu label{border-bottom:1px solid #dadada;width:100%;padding-bottom:6px;}
    .categorylistmenu label a{ font-size:14px;color:#424242;text-decoration:none;display:block;}
</style>
<div class="breadcrumb-bg">
    <div class="container">
        <ul class="breadcrumb">
            <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a href="{{route("home_v2")}}" itemprop="url"><span itemprop="title">Home</span></a>
            </li>
            <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="active">
                <span itemprop="title">{{ucwords($c_name)}}</span>
            </li>
        </ul>
    </div>
</div>
<div class="fullbgpro">
    <div class="container">
        <select-catlist>
            <div class="panel-group panel-groupselect" id="accordion" role="tablist" aria-multiselectable="true" style="margin-bottom:15px!important;">
                <div class="panel panel-default">
                    <div class="panel-heading selectbg" role="tab" id="heading1">
                        <h4 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1"> SELECT CATEGORIES <span class="icontab glyphicon glyphicon-menu-down" aria-hidden="true"></span></a> </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1">
                        <div class="panel-body">
                            <div class="categorylistmenu">
                                @foreach($categories as $category)
                                    <label>
                                        <a href="#cat{{create_slug($category->name)}}">{{$category->name}}</a>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </select-catlist>
    </div>
    </select-catlist>
    @foreach($categories as $category)
        <div id="cat{{create_slug($category->name)}}">
        <div class="container">
            <div class="haddingcategory">{{$category->name}}</div></div>
            @if($category->children->isNotEmpty())
                @foreach( $category->children as $child )
                    <?php
                        if( !empty($cat_name) ) $category->group_name = $cat_name;
                    ?>
                    <?php $url = newUrl( create_slug($category->group_name)."/".create_slug( $category->name )."/".seoUrl( create_slug($child->name) ) ); ?>
                    <div class="whitecolorbg">
                        <div class="productimgcat">
                            <a href="{{$url}}" title="{{$child->name}}">
                                <img class="imgproductsize" src="{{$child->image}}" alt="{{$child->name}} Image">
                            </a>
                        </div>
                        <div class="categorynametext">
                            <a href="{{$url}}" title="{{$child->name}}">
                                {{$child->name}}
                            </a>
                        </div>
                        @if( isset($cat_brands) && isset($cat_brands->{$child->id}) )
                            <div class="categorylink">
                                <ul>
                                    @foreach( $cat_brands->{$child->id} as $brand )
                                        @if(!empty($brand))
                                            <?php $brand_url = route('brand_category_list', [
                                                    create_slug($brand),
                                                    create_slug($child->group_name),
                                                    create_slug($child->name)
                                            ]); ?>
                                            <li>
                                                <a href="{{$brand_url}}">&raquo; {{$brand}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="whitecolorbg">
                    <div class="productimgcat">
                        <a href="{{route('sub_category',[$category->group_name,create_slug($category->name)])}}-price-list-in-india.html" title="{{$category->name}}">
                            <img class="imgproductsize" src="{{$category->image}}" alt="{{$category->name}} Image">
                        </a>
                    </div>
                    <div class="categorynametext">
                        <a href="{{route('sub_category',[$category->group_name,create_slug($category->name)])}}-price-list-in-india.html" title="{{$category->name}}">
                            {{$category->name}}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
    </div>
    <div class="clearfix"></div>
    @if(isset($list_desc) && isset($list_desc->text))
    <div class="bottomcontbg">
        <div class="container" style="text-align:justify">            
                @if( isset($list_desc->text) )
                    {!! $list_desc->text !!}
                @endif
            </div>
        </div>
    @endif
    <!--END-PART-1-->

<script>
    var interval = setInterval(function(){
        if( typeof $ !== 'undefined' )
        {
            $(window).scroll(function(){
                if ($(window).scrollTop() >= 100) {
                    $('select-catlist').addClass('fixed-header');
                }
                else {
                    $('select-catlist').removeClass('fixed-header');
                }
            });

            $(document).on('click','.categorylistmenu a',function(){
                $('#collapse1').collapse('hide');
            });

            $(document).on('click','.fullbgpro .whitecolorbg',function(){
                $('#collapse1').collapse('hide');
            });

            clearInterval(interval);
        }
    },1000);
</script>
