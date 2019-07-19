<?php
if (isset($product->_source)) {
    $product = $product->_source;
}

if (isset($product->track_stock) && $product->track_stock == 1) {
    $oo_stock = false;
} else {
    $oo_stock = true;
}
?>
<div class="thumnail2">
    @if( isComparativeProduct($product) )
        <?php $product_url = route('product_detail_v2', [create_slug($product->name), $product->id]); ?>
    @else
        <?php $group = (isset($product->grp)) ? $product->grp : ((isset($product->group) ? $product->group : ''));
        $product_url = route('product_detail_non', [
                create_slug($group),
                create_slug($product->name),
                $product->id,
                $product->vendor
        ]); ?>
    @endif

    <a href="{{$product_url}}" class="thumnailimgbox {{($oo_stock) ? "oo_stock_wrapper" : ''}}" target="_blank">
        <img class="productimg" src="{{getImageNew('')}}" data-src="{{getImageNew($product->image_url,"M")}}" alt="{{$product->name}} Image"/>
        @if($oo_stock)
            <span class="oo_stock">Out Of Stock</span>
        @endif
    </a>
    <div class="prdsts prdsts2">
        <?php $product_name = addAttributesToProductName($product) ?>
        <a href="{{$product_url}}" class="product_name" title="{{$product_name}}" target="_blank">{{$product_name}}</a>
        @if(isset($product->mini_spec))
            <span class="details" onclick="window.open('{{$product_url}}')">{!! getMiniSpecV3($product->mini_spec,2) !!}</span>
        @endif

        <?php $rating = (isset($product->rating) ? $product->rating : 0); ?>

        <div class="str-rtg">
            <span style="width:{{percent($rating,5)}}%" class="str-ratg"></span>
        </div>
        <a href="{{$product_url}}" class="product_price" target="_blank">
            Rs {{number_format($product->saleprice)}}
            @if($product->price > 0 && $product->price > $product->saleprice )
                <span>Rs {{number_format($product->price)}}</span>
            @endif
        </a>
        @if($product->price > 0 && $product->price > $product->saleprice )
            <span class="discount-price">( upto {{percent($product->price-$product->saleprice,$product->price)}}% Off )</span>
        @endif
        @if(isComparativeProduct($product) && checkSpecification($product) && isAddToCompare($product))
            <a class="addcompare">
                <input type="checkbox" name="product-{{$product->id}}" id="product-{{$product->id}}" class="add-to-compare" data-prod-id="{{$product->id}}" data-cat="{{$product->category_id}}">
                <label for="product-{{$product->id}}" class="addcomparetext" title="Add {{$product->name}} to compare list">
                    <span></span>add to compare
                </label>
            </a>
        @endif
    </div>
        <span onclick="window.open('{{$product_url}}')" class="productbutton">
            @if(isset($product->price) && $product->price > $product->saleprice )
                Get this offer
            @else
                Buy Now
            @endif
        </span>
</div>