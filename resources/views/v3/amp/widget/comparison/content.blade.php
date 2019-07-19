<amp-selector role="tablist" layout="container" class="ampTabContainer">
    @foreach( $products as $category => $compare_products )
        <div role="tab" class="tabButton tab40px tableft15" {!! ( $category == 'phone' ) ? 'selected' : '' !!} option="a"></div>
        <div role="tabpanel" class="tabContent">
            <amp-carousel class="full-bottom" height="270" layout="fixed-height" type="carousel">
                @foreach( $compare_products as $products )
                    <div class="thumnailcompar">
                        <?php $product1 = collect($products[0]); ?>
                        <?php $product2 = collect($products[1]); ?>
                        <?php
                        $mobile1 = create_slug($product1->get('name') . " " . $product1->get('id'));
                        $mobile2 = create_slug($product2->get('name') . " " . $product2->get('id'));
                        ?>
                        <a target="_blank" href="{{route('compare-mobiles',[ $mobile1, $mobile2 ])}}">
                            <div class="comparisonpro">
                                <div class="comparisonproimg">
                                    <amp-img class="comparison-productimg" src="{{getImageNew($product1->get('image_url'),'S')}}" alt="productimg" width="60" height="90"></amp-img>
                                </div>
                                <div class="comparestats-container">
                                    <div class="product_name compareproname">{{$product1->get('name')}}</div>
                                    <div class="star-ratingreviews">
                                        <div class="star-ratings-sprite">
                                            <span class="star-ratings-sprite-rating rating81"></span>
                                        </div>
                                    </div>
                                    <div class="product_price">Rs {{number_format($product1->get('saleprice'))}} </div>
                                </div>
                            </div>
                            <div class="orcomp">OR</div>
                            <div class="comparisonpro">
                                <div class="comparisonproimg">
                                    <amp-img class="comparison-productimg" src="{{getImageNew($product2->get('image_url'),'S')}}" alt="productimg" width="60" height="90"></amp-img>
                                </div>
                                <div class="comparestats-container">
                                    <div class="product_name compareproname">{{$product2->get('name')}}</div>
                                    <div class="star-ratingreviews">
                                        <div class="star-ratings-sprite">
                                            <span class="star-ratings-sprite-rating rating81"></span>
                                        </div>
                                    </div>
                                    <div class="product_price">Rs {{number_format($product2->get('saleprice'))}} </div>
                                </div>
                            </div>
                        <span class="productbutton">
                    Compare Now
                </span>
                        </a>
                    </div>
                @endforeach
            </amp-carousel>
            @if( $category == 'phone' )
                <div class="allcateglink">
                    <a href="{{url('most-compared-mobiles.html')}}">
                        View All Comparisons <i class="fa fa-angle-right right-arrow"></i>
                    </a>
                </div>
            @endif
        </div>
    @endforeach
</amp-selector>