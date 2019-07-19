    <div class="whitecolorbg">
        <div class="container">
            <h3>Top Deals on Accessories</h3>
            <div class="product-tabs css-carouseltab padding-btm0">                    
                        <ul class="tabs">
                            <?php $i = 0; ?>
                            @foreach( $cat_tabs as $key => $products )
                                <li class="tab">
                                    <a class="{{($i++ == 0) ? 'active' : ''}}" href="#deals_under_{{create_slug($key)}}">{{ucwords($key)}}</a>
                                </li>
                            @endforeach
                        </ul>                   
             
            </div>
            @foreach( $cat_tabs as $key => $products )
                <div class="tab-content" id="deals_under_{{create_slug($key)}}">
                    @include("v3.mobile.product.carousel")
                   
                        @if( !in_array($main_product->category_id, config('vendor.remove_brand_link')) )
                            <?php $Category = \indiashopps\Category::find($products->first()->category_id); ?>
                            <a class="allcateglink" href="{{getCategoryUrl($Category)}}">
                                VIEW ALL {{ucwords($Category->name)}}
                                <span class="right-arrow"></span>
                            </a>
                        @endif
                    
                </div>
            @endforeach
        </div>
    </div>
