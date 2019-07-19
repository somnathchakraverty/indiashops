@if(isset($key) && $key == 'phone')
    <div class="alltab">
        <a href="{{route('most-compared')}}">View All Comparisons
            <span class="arrow">&rsaquo;</span>
        </a>
    </div>
@endif
<div class="trendingdealsprobox">
    <div class="cs_dkt_si">
        <ul data-items="3">
            @foreach($products as $product)
                <li class="thucom">                  
                        <?php $product1 = collect($product[0]); ?>
                        <?php $product2 = collect($product[1]); ?>
                        <?php
                        $mobile1 = create_slug($product1->get('name') . " " . $product1->get('id'));
                        $mobile2 = create_slug($product2->get('name') . " " . $product2->get('id'));
                        ?>
                        <a target="_blank" href="{{route('compare-mobiles',[ $mobile1, $mobile2 ])}}">
                            <div class="compapro">
                                <span class="compapimg">
                                  <img class="comproimg" src="{{getImageNew("","M")}}" data-src="{{$product1->get('image_url')}}" alt="productimg">
                                </span>
                                <div class="comconr">
                                    <span class="product_name">{{$product1->get('name')}}</span>                                   
                                        <div class="str-rtg">
                                            <span style="width:81%" class="str-ratg"></span>
                                        </div>                                  
                                    <span class="product_price">Rs {{number_format($product1->get('saleprice'))}} </span>
                                </div>
                            </div>
                            <span class="orcomp">OR</span>
                            <div class="compapro">
                                <span class="compapimg">
                                    <img class="comproimg" src="{{getImageNew("","M")}}" data-src="{{$product2->get('image_url')}}" alt="productimg">
                                </span>
                                <div class="comconr">
                                    <span class="product_name">{{$product2->get('name')}}</span>                                    
                                        <div class="str-rtg">
                                            <span style="width:81%" class="str-ratg"></span>
                                        </div>                                  
                                    <span class="product_price">Rs {{number_format($product2->get('saleprice'))}} </span>
                                </div>
                            </div>
                        <span class="compbut">Compare Now</span>
                        </a>                   
                </li>
            @endforeach
        </ul>
    </div>
</div>