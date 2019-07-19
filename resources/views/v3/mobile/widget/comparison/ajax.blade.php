<div class="css-carousel">
        <ul>
            @foreach($products as $product)
                <li>
                    <?php $product1 = collect($product[0]); ?>
                    <?php $product2 = collect($product[1]); ?>
                    <?php
                    $mobile1 = create_slug($product1->get('name') . " " . $product1->get('id'));
                    $mobile2 = create_slug($product2->get('name') . " " . $product2->get('id'));
                    ?>
                    <a class="thumnailcompar" target="_blank" href="{{route('compare-mobiles',[ $mobile1, $mobile2 ])}}">
                      
                            <div class="comparisonpro">
                                <div class="comparisonproimg">
                                    <img class="comparison-productimg" src="{{getImageNew('')}}" data-src="{{getImageNew($product1->get('image_url'),"MOBILE")}}" alt="productimg">
                                </div>
                                <div class="comparestats-container">
                                    <h3>{{$product1->get('name')}}</h3>                                    
                                        <div class="star-ratings-sprite">
                                            <span style="width:81%" class="star-ratings-sprite-rating"></span></div>                                   
                                    <div class="product_price">Rs {{number_format($product1->get('saleprice'))}} </div>
                                </div>
                            </div>
                            <div class="orcomp">OR</div>
                            <div class="comparisonpro">
                                <div class="comparisonproimg">
                                    <img class="comparison-productimg" src="{{getImageNew('')}}" data-src="{{getImageNew($product2->get('image_url'),"MOBILE")}}" alt="productimg">
                                </div>
                                <div class="comparestats-container">
                                    <h3>{{$product2->get('name')}}</h3>
                                    
                                        <div class="star-ratings-sprite">
                                            <span style="width:81%" class="star-ratings-sprite-rating"></span></div>
                                   
                                    <div class="product_price">Rs {{number_format($product2->get('saleprice'))}} </div>
                                </div>
                            </div>
                            <span class="productbutton">Compare Now</span>
                       
                    </a>
                </li>
            @endforeach
        </ul>
   
</div>