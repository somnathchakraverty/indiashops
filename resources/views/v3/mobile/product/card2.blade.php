<?php
if (isset($product->_source)) {
    $product = $product->_source;
}

?>
@if( isComparativeProduct($product) )
    <?php $product_url = route('product_detail_v2', [create_slug($product->name), $product->id]); ?>
@else
    <?php $group = (isset($product->grp)) ? $product->grp : ((isset($product->group) ? $product->group : ''));
    $product_url = route('product_detail_non', [
            create_slug($group), create_slug($product->name), $product->id, $product->vendor
    ]); ?>
@endif

<a href="{{$product_url}}" class="thumnailcard" target="_blank" title="{{$product->name}}">
    <div class="card2imgbox">
        <img class="productimg" src="{{getImageNew('')}}" data-src="{{getImageNew($product->image_url,'MOBILE')}}" alt="{{$product->name}}"/>
    </div>
    <div class="card2textbox">
        <?php $product_name = addAttributesToProductName($product) ?>
        <h3 title="{{$product_name}}">
            {{truncate($product_name,55)}}
        </h3>
        @if(isset($product->mini_spec))
            <div class="details">{!! getMiniSpecV3($product->mini_spec,2) !!}</div>
        @endif
        <?php $rating = (isset($product->rating) ? (int)$product->rating : 4); ?>
        <?php $rating = ($rating > 0) ? $rating : 4 ?>

        <div class="star-ratings-sprite">
            <span style="width:{{percent($rating,5)}}%" class="star-ratings-sprite-rating"></span></div>

        <div class="product_price">Rs {{number_format($product->saleprice)}}
            @if($product->price > 0 && $product->price > $product->saleprice )
                <span>Rs {{number_format($product->price)}}</span>
            @endif
        </div>
        @if($product->price > 0 && $product->price > $product->saleprice )
            <div class="discount-price">( upto {{percent($product->saleprice,$product->price)}}% Off )</div>
        @endif
        @if(isComparativeProduct($product) && false)
            <div class="addcompare">
                <input type="checkbox" name="product-{{$product->id}}" id="product-{{$product->id}}" class="add-to-compare" prod-id="{{$product->id}}" cat="{{$product->category_id}}">
                <label for="product-{{$product->id}}" class="addcomparetext" title="Add {{$product->name}} to compare list">
                    <div></div>
                    add to compare
                </label>
            </div>
        @endif

    </div>
        <span class="productbutton2">
            @if(isset($product->price) && $product->price > $product->saleprice )
                Get this offer
            @else
                Buy Now
            @endif
        </span>
</a>
