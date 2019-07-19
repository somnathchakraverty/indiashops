<section>
    <div class="container">
        <h2>Top Deals on Accessories</h2>
        <div class="product-tabs">
            <ul class="tabs carousel" id="part-tab-7" data-items="1.7" data-scroll="1">
                <?php $i = 0; ?>
                @foreach( $tabs as $key => $products )
                    <li class="tab">
                        <a class="{{($i++ == 0) ? 'active' : ''}}" href="#deals_under_{{create_slug($key)}}">{{ucwords($key)}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="whitecolorbg">
        <div class="container">
            @foreach( $tabs as $key => $products )
                <div class="tab-content" id="deals_under_{{create_slug($key)}}">
                    <ul id="part40" class="carousel" data-items="1.5" data-scroll="1">
                        @foreach($products as $product)
                            <li>
                                @include("v3.mobile.product.card")
                            </li>
                        @endforeach
                    </ul>
                   
                        <?php $Category = \indiashopps\Category::find($product->category_id); ?>
                        <a class="allcateglink" href="{{getCategoryUrl($Category)}}">
                            VIEW ALL {{ucwords($Category->name)}}
                            <span class="right-arrow"></span>
                        </a>
                   
                </div>
            @endforeach
        </div>
    </div>
    <script>
        $("ul.tabs").tabs();
    </script>
</section>