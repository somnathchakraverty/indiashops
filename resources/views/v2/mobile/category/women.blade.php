<?php
    $big_cat = ['Shoes','Ethnic Clothing','Clothing', 'Bags', 'Accessories', 'Lingerie & Sleepwear'];

    foreach( $categories as $key => $category )
    {
        if( in_array( $category->name, $big_cat ) )
        {
            $lcategories[] = $category;
            unset($categories[$key]);
        }
    }
?>
<style>
.fullbgnewtop{background:#FFF;margin:0px;padding:20px 0px 10px 0px;}
.category{background:#f2f2f2;padding-bottom:0px;}
.title{background:#e40046;padding:3px 0px;font-size:20px;margin-bottom:10px;color:#fff!Important;}
.category .title h4{color:#fff;text-shadow:1px 0px 6px #0a0a0a;text-align:center;}
.uptodiscount{font-size:14px;text-align:center;margin-bottom:10px;padding:0;color:#000;font-weight:700;}
.uptodiscount span{font-size:16px;text-align:center;margin:-6px 0 10px;padding:0;color:#e40046;font-weight:700;}
.category .image{text-align:center;max-height:200px;width:auto;margin-bottom:15px;}
.list{list-style:none;padding:0px;}
.list li{list-style:none;border-bottom:1px solid #ddd;padding:5px;text-align:center;}
.list a{color:#333;}
.list li:after{font-family:'FontAwesome';position:absolute;right:30px;font-size: 20px;}
</style>
<div class="breadcrumb-bg">
  <div class="container">
    <ul class="breadcrumb">
      <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"> <a href="{{route("home_v2")}}" itemprop="url"><span itemprop="title">Home</span></a> </li>
      <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb" class="active"> <span itemprop="title">{{ucwords($c_name)}}</span> </li>
    </ul>
  </div>
</div>
@foreach( $lcategories as $key => $category )
    @if( count($category->children) > 0 )
<div class="container">
  <h5 class="catnameproduct">{{ucfirst($category->group_name)}}'s {{$category->name}}</h5>
</div>
<div class="fullbgpro">
  <div class="container">
    <ul id="flexiselDemo-{{create_slug($category->name)}}">
      @foreach( $category->children as $child )
      <?php
                        if( !empty($cat_name) ) $category->group_name = $cat_name;
                        $cat_image = str_replace("100x100","160x180",$child->image);
                    ?>
      <?php $url = newUrl( create_slug($category->group_name)."/".create_slug( $category->name )."/".seoUrl( create_slug($child->name) ) ); ?>
      <li>
        <div class="thumnail">
          <div class="productboxallcat"> <a href="{{$url}}" title="{{$child->name}}"> <img class="productallcatimg" src="{{$cat_image}}" alt="{{$child->name}} image"> </a> </div>
          <div class="productname">
              <a href="{{$url}}" title="{{$child->name}}">
                {{$child->name}}
              </a>
          </div>
          <div class="star-ratingreviews">
            <div class="star-ratings-sprite"> <span style="width:{{rand(70,100)}}%" class="star-ratings-sprite-rating"></span> </div>
          </div>
          <a href="{{$url}}" title="Explore More {{$child->name}}" target="_blank" class="price" role="button">Explore</a> </div>
      </li>
      @endforeach
    </ul>
  </div>
</div>
<!--END-PART-1-->
<!--PART-2-->
@if(isset($slider[$key]))
<div class="container"> @if( isset($slider[$key]->refer_url) && !empty($slider[$key]->refer_url) ) <a href="{{$slider[$key]->refer_url}}" target="_blank"> <img class="img-responsive adimg" src="{{$slider[$key]->image_url}}" alt="ad" /> </a> @else <img class="img-responsive adimg" src="{{$slider[$key]->image_url}}" alt="ad" /> @endif </div>
@endif
    @endif
@endforeach
@foreach( $categories as $category )
    <?php
    $cat_image = str_replace("100x100","160x180",$category->children[0]->image);
    ?>
    
    <div class="fullbgnewtop">
    <div class="container">
    <div class="col-md-4">
        <div class="category">
            <div class="title"><h4>{{$category->name}}</h4></div>
            <div class="uptodiscount">Up to <span>40%-70%</span> OFF</div>
            <div class="image">
                <?php $url = newUrl( create_slug($category->group_name)."/".seoUrl( create_slug($category->name) ) ); ?>
                <a href="{{$url}}" target="_blank">
                    <img src="{{$cat_image}}" class="img-thumbnail"/>
                </a>
            </div>
            <div class="category-list">
                <ul class="list">
                    @foreach( $category->children as $child )
                        <?php $url = newUrl( create_slug($category->group_name)."/".create_slug( $category->name )."/".seoUrl( create_slug($child->name) ) ); ?>
                        <li>
                            <a href="{{$url}}" title="Explore More {{$child->name}}" target="_blank" >{{$child->name}}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
            </div>
        </div>
    </div>
    </div>
    
    
    
@endforeach
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
<script type="text/javascript">
    var asset_url = '{{asset('assets/v2/mobile')}}/';

    var interval = setInterval(function(){
        if( typeof $ !== 'undefined')
        {
            var s = document.createElement("script");
            s.type = "text/javascript";
            s.src = asset_url + "js/jquery.flexisel.js";
            document.body.appendChild(s);

            s.addEventListener('load', function () {
                @foreach( $lcategories as $key => $cat )
                $("#flexiselDemo-{{create_slug($cat->name)}}").flexisel({
                    infinite: false
                });
                @endforeach
            }, false);
            clearInterval(interval);
        }
    },500);
</script>
