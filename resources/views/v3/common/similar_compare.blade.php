<ul id="flexisel-compare1" class="carousel" data-items="3">
    @foreach($products as $product)
        <li class="compareboxwidth">
            <div class="thumnailcompar">
                <div class="comparisonpro">
                    <div class="comparisonproimg">
                        <img class="comparison-productimg" src="{{$image_url}}" alt="{{$name}} Image">
                    </div>
                    <div class="comparestats-container">
                        <div class="product_name">{{$name}}</div>
                        <div class="star-ratingreviews">
                            <div class="star-ratings-sprite">
                                <span style="width:81%" class="star-ratings-sprite-rating"></span>
                            </div>
                        </div>
                        <div class="product_price">Rs {{number_format($saleprice)}}</div>
                    </div>
                </div>
                <div class="orcomp">OR</div>
                <?php $product = $product->_source ?>
                <div class="comparisonpro">
                    <div class="comparisonproimg">
                        <img class="comparison-productimg" src="{{getImageNew($product->image_url,"M")}}" alt="{{$product->name}} Image">
                    </div>
                    <div class="comparestats-container">
                        <div class="product_name">{{$product->name}}</div>
                        <div class="star-ratingreviews">
                            <div class="star-ratings-sprite">
                                <span style="width:81%" class="star-ratings-sprite-rating"></span>
                            </div>
                        </div>
                        <div class="product_price">Rs {{number_format($product->saleprice)}}</div>
                    </div>
                </div>
                <a href="{{route('compare-mobiles',[create_slug($name."-".$id),create_slug($product->name."-".$product->id)])}}" target="_blank" class="compareproductbutton">Compare Now</a></div>
        </li>
    @endforeach
</ul>