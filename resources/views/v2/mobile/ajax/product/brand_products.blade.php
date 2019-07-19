@if(isset($products))
    <ul id="by-brand-slider">
        @foreach( $products as $pro )
            <?php $product = $pro->_source;?>
            <li>
                <div class="thumnail">
                    <div class="productboxallcat">
                        <a href="{{product_url($product)}}">
                            <img class="productallcatimg" src="{{getImageNew($product->image_url, 'M')}}"
                                 alt="">
                        </a>
                    </div>
                    <div class="productname">
                        <a href="{{product_url($product)}}">
                            {{$product->name}}
                        </a>
                    </div>
                    <div class="star-ratingreviews">
                        <div class="star-ratings-sprite">
                            <span style="width:52%" class="star-ratings-sprite-rating"></span>
                        </div>
                    </div>
                    <a href="{{product_url($product)}}" class="price">
                        Rs. {{number_format($product->saleprice)}}
                    </a>
                </div>
            </li>
        @endforeach
        </ul>
@endif