<div class="breadcrumb-bg">
  <div class="container">
    <ul class="breadcrumb">
      <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"> <a href="/" itemprop="url"><span itemprop="title">Home</span></a> </li>
      <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"> <span itemprop="title">Discountinued</span> </li>
    </ul>
  </div>
</div>
<div class="fullbgpro">
  <div class="container">
    <div class="discontinueblock"> We're sorry, the product you are looking for has been discontinued. We recommend you to browse through
      our featured categories </div>
  </div>
  @if(count($products) > 0)
  <div class="sub-title">Popular {{collect($products)->first()->_source->category}}</div>
  @foreach($products as $key => $p )
  <?php $product = $p->_source; ?>
  <?php
                    if (!empty(json_decode($product->image_url))) {
                        $images = json_decode($product->image_url);
                    } else {
                        $images[0] = $product->image_url;
                    }
                    ?>
  <div class="col-xs-6 col-sm-6">
    <div class="thumnail">
      <div class="productbox"> <a href="{{product_url($p)}}" title="{{$product->name}}"> <img class="productimg" alt="{{$product->name}} Image" title="{{$product->name}}"
                                     src="{{$images[0]}}" onerror="imgError(this)"> </a> </div>
      <div class="productname"> <a href="{{product_url($p)}}" title="{{$product->name}}">
        {{truncate($product->name,30)}}
        </a> </div>
      <div class="star-ratingreviews">
        <div class="star-ratings-sprite"> <span style="width:52%" class="star-ratings-sprite-rating"></span> </div>
      </div>
      <a href="#" class="price" role="button"> Rs. {{number_format($product->saleprice)}} </a> </div>
  </div>
  @if( $key >= 7 )
  <?php break; ?>
  @endif
  <?php unset($products[$key]) ?>
  @endforeach
  
  @endif
  <?php $products = array_values(array_filter($products));?>
  @if(count($products) > 0)
  <div class="sub-title"> Popular {{collect($products)->first()->_source->parent_category}}</div>
  @foreach($products as $key => $p )
  <?php $product = $p->_source; ?>
  <?php
                    if (!empty(json_decode($product->image_url))) {
                        $images = json_decode($product->image_url);
                    } else {
                        $images[0] = $product->image_url;
                    }
                    ?>
  <div class="col-xs-6 col-sm-6">
    <div class="thumnail">
      <div class="productbox"> <a href="{{product_url($p)}}" title="{{$product->name}}"> <img class="productimg" alt="{{$product->name}} Image" title="{{$product->name}}"
                                     src="{{$images[0]}}" onerror="imgError(this)"> </a> </div>
      <div class="productname"> <a href="{{product_url($p)}}" title="{{$product->name}}">
       {{truncate($product->name,30)}}
        </a> </div>
      <div class="star-ratingreviews">
        <div class="star-ratings-sprite"> <span style="width:52%" class="star-ratings-sprite-rating"></span> </div>
      </div>
      <a href="#" class="price" role="button">Rs. {{number_format($product->saleprice)}} </a> </div>
  </div>
  @if( $key >= 7 )
  <?php break; ?>
  @endif
  <?php unset($products[$key]) ?>
  @endforeach </div>
@endif
<style>
.discontinueblock{background:#e40046;margin-top:5px;padding:10px;text-align:center;font-size:15px;color:#fff;}
.thumbnaildis{padding-top:6px;background-color:#fff;height:300px;border-radius:2px;}
.sub-title{background:#fff;margin:15px 0px 5px 0px;text-align:center;padding:10px;font-size:16px;clear:both;}
</style>
