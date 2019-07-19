<div class="thumnail">
    <?php
    if (isset($product->_source)) {
        $product = $product->_source;
    }

    if (isset($product->vendor)) {
        $vendor = $product->vendor;
    } else {
        $vendor = false;
    }
    ?>
    @if(isset($compare_url) && $compare_url !== false)
        <?php $product_url = $compare_url; ?>
    @elseif( empty($product->id) && isset($product->product_url) && !empty($product->product_url) )
        <?php $product_url = $product->product_url; ?>
    @elseif( isset($vendor) && ( is_array($vendor) || empty($vendor) ) )
        <?php $product_url = route('amp_detail_comp', [create_slug($product->name), $product->id]); ?>
    @else
        <?php $group = (isset($product->grp)) ? $product->grp : ((isset($product->group) ? $product->group : ''));
        if ($group == "Books") {
            $route = 'amp_detail_books';
        } else {
            $route = 'amp_detail_non_comp';
        }

        $product_url = route($route, [
                create_slug($product->name),
                $product->id,
                $vendor
        ]);
        ?>
    @endif
    <div>
        <div class="thumnailimgbox">
            <a href="{{$product_url}}" target="_blank">
                <amp-img class="productimg" src="{{getImageNew($product->image_url,"M")}}" width="75" height="104" alt="{{$product->name}}"></amp-img>
            </a>
        </div>
        <div class="stats-container">
            <a href="{{$product_url}}" target="_blank">
                <div class="product_name">{{addAttributesToProductName($product)}}</div>
            </a>
            <a href="{{$product_url}}" target="_blank">
                @if(isset($product->mini_spec))
                    <div class="details">{!! getMiniSpecV3($product->mini_spec,2) !!}</div>
                @endif
                <?php $rating = (isset($product->rating) ? (int)$product->rating : 4); ?>
                <?php $rating = ($rating > 0) ? $rating : 4 ?>
                <div class="star-ratingreviews">
                    <div class="star-ratings-sprite">
                        {!! ampStar($rating) !!}
                    </div>
                </div>
                <div class="product_price">Rs {{number_format($product->saleprice)}}
                    @if(isset($product->price) && $product->price > $product->saleprice )
                        <span>Rs {{number_format($product->price)}}</span>
                    @endif
                </div>
                @if(isset($product->discount) && isset($product->price) && $product->price > $product->saleprice )
                    <div class="discount-price">( upto {{$product->discount}}% Off )</div>
                @endif
            </a>
        </div>
        <a href="{{$product_url}}" target="_blank">
            <span class="productbutton">
                @if(isset($compare_url) && $compare_url !== false)
                    Compare Now
                @elseif(isset($product->price) && $product->price > $product->saleprice )
                    Get this offer
                @else
                    Buy Now
                @endif
            </span>
        </a>
    </div>
</div>