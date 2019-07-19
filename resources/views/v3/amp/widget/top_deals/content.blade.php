<amp-selector role="tablist" layout="container" class="ampTabContainer">
    <?php $i = 0; ?>
    <?php $mapping = ['headphones' => 'Headphones', 'speakers' => 'Speakers', 'memory_card' => 'Memory Disks', 'smart_wearables' => 'Smart Wearables']; ?>
    @foreach( $products as $category => $category_products )
        <div role="tab" class="tabButton tab40px tableft7" {{($i++==0) ? 'selected' : ''}} option="a">{{$mapping[$category]}}</div>
        <div role="tabpanel" class="tabContent">
            <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                @foreach($category_products as $product)
                    @include( 'v3.common.product.amp.card' )
                @endforeach
            </amp-carousel>
            <div class="allcateglink">
                <?php $cat = \indiashopps\Category::find(collect($category_products)->first()->category_id) ?>
                <a href="{{getCategoryUrl($cat)}}">
                    VIEW ALL {{unslug($category)}} <i class="fa fa-angle-right right-arrow"></i>
                </a>
            </div>
        </div>
    @endforeach
</amp-selector>