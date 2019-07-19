<ul id="flexisel-compare1" class="carousel" data-items="1.5" data-scroll="1">
    @foreach($products as $product)
        <li>
            <?php $product1 = collect($product[0]); ?>
            <?php $product2 = collect($product[1]); ?>
            <?php
            $mobile1 = create_slug($product1->get('name') . " " . $product1->get('id'));
            $mobile2 = create_slug($product2->get('name') . " " . $product2->get('id'));
            ?>
            <a target="_blank" href="{{route('compare-mobiles',[ $mobile1, $mobile2 ])}}">
            <div class="thumnailcompar">
                <div class="comparisonpro">
                    <div class="comparisonproimg">
                        <img class="comparison-productimg" src="{{getImageNew('')}}" data-src="{{getImageNew($product1->get('image_url'),"M")}}" alt="productimg">
                    </div>
                    <div class="comparestats-container">
                        <div class="product_name compareproname">{{$product1->get('name')}}</div>
                        <div class="star-ratingreviews">
                            <div class="star-ratings-sprite"> <span class="star-ratings-sprite-rating rating81"></span> </div>
                        </div>
                        <div class="product_price">Rs {{number_format($product1->get('saleprice'))}} </div>
                    </div>
                </div>
                <div class="orcomp">OR</div>
                <div class="comparisonpro">
                    <div class="comparisonproimg">
                        <img class="comparison-productimg" src="{{getImageNew('')}}" data-src="{{getImageNew($product2->get('image_url'),"M")}}" alt="productimg">
                    </div>
                    <div class="comparestats-container">
                        <div class="product_name compareproname">{{$product2->get('name')}}</div>
                        <div class="star-ratingreviews">
                            <div class="star-ratings-sprite"> <span class="star-ratings-sprite-rating rating81"></span> </div>
                        </div>
                        <div class="product_price">Rs {{number_format($product2->get('saleprice'))}} </div>
                    </div>
                </div>
                    <span class="productbutton">Compare Now</span>
                    </div>
            </a>
        </li>
    @endforeach
</ul>