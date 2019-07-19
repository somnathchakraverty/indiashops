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
    @if( empty($product->id) && isset($product->product_url) && !empty($product->product_url) )
        <?php $product_url = $product->product_url; ?>
    @elseif( isset($vendor) && ( is_array($vendor) || empty($vendor) ) )
        <?php $product_url = route('product_detail_v2', [create_slug($product->name), $product->id]); ?>
    @else
        <?php $group = (isset($product->grp)) ? $product->grp : ((isset($product->group) ? $product->group : ''));
        $product_url = route('product_detail_non', [
                create_slug($group),
                create_slug($product->name),
                $product->id,
                $vendor
        ]); ?>
    @endif

    <a class="thumnailimgbox" href="{{$product_url}}" target="_blank">
        <img class="productimg" src="{{getImageNew('')}}" data-src="{{getImageNew($product->image_url,"M")}}" alt="{{$product->name}} Image" title="{{$product->name}}">
    </a>
    <div class="prdsts" onclick="window.open('{{$product_url}}')">
        <?php $product_name = addAttributesToProductName($product) ?>
        <a class="product_name" title="{{$product_name}}">
            {{$product_name}}
        </a>       
            @if(isset($product->mini_spec))
                <span class="details">{!! getMiniSpecV3($product->mini_spec,2) !!}</span>
            @endif
            <?php $rating = (isset($product->rating) ? $product->rating : 0); ?>
            <div class="str-rtg">
                <span style="width:{{percent($rating,5)}}%" class="str-ratg"></span>
            </div>
            <a class="product_price">Rs {{number_format($product->saleprice)}}
                @if(isset($product->price) && $product->price > $product->saleprice )
                    <span>Rs {{number_format($product->price)}}</span>
                @endif
            </a>
            @if($product->price > 0 && $product->price > $product->saleprice )
                <span class="discount-price">( upto {{percent($product->saleprice,$product->price)}}% Off )</span>
            @endif       
    </div>
        <span onclick="window.open('{{$product_url}}')" class="productbutton">
            @if(isset($product->price) && $product->price > $product->saleprice )
                Get this offer
            @else
                Buy Now
            @endif
        </span>

