<div class="alltab">
    <a href="{{route('most-compared')}}">View All Comparisons
        <span class="glyphicon glyphicon-menu-right arrow" aria-hidden="true"></span>
    </a>
</div>
<div class="trending-comparison">
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
                            <div class="compapimg">
                                <img class="comproimg" src="{{$product1->get('image_url')}}" alt="productimg">
                            </div>
                            <div class="comconr">
                                <div class="product_name">{{$product1->get('name')}}</div>                                
                                    <div class="str-rtg">
                                        <span style="width:81%" class="str-ratg"></span>
                                    </div>                               
                                <div class="product_price">Rs {{number_format($product1->get('saleprice'))}} </div>
                            </div>
                        </div>
                        <div class="orcomp">OR</div>
                        <div class="compapro">
                            <div class="compapimg">
                                <img class="comproimg" src="{{$product2->get('image_url')}}" alt="productimg">
                            </div>
                            <div class="comconr">
                                <div class="product_name">{{$product2->get('name')}}</div>                                
                                    <div class="str-rtg">
                                        <span style="width:81%" class="str-ratg"></span>
                                    </div>                               
                                <div class="product_price">Rs {{number_format($product2->get('saleprice'))}} </div>
                            </div>
                        </div>
                        <span class="compbut">Compare Now</span>
                    </a>               
            </li>
        @endforeach
    </ul>
    </div>
</div>