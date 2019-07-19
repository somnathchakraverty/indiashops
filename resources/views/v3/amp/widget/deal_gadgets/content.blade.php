<amp-selector role="tablist" layout="container" class="ampTabContainer">
    <?php $i = 0; ?>
    @foreach($products as $section => $section_products)
        <div role="tab" class="tabButton tab40px tableft15" {{($i++ == 0) ? 'selected' : ''}} option="a">
            {{ucwords($section)}}
        </div>
        <div role="tabpanel" class="tabContent">
            <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                @foreach($section_products as $product)
                    @include('v3.common.product.amp.card', [ 'product' => $product ])
                @endforeach
            </amp-carousel>
            <div class="allcateglink">
                <?php $cat = \indiashopps\Category::find(collect($section_products)->first()->category_id) ?>
                <a href="{{getCategoryUrl($cat)}}">
                    VIEW ALL {{$section}} <i class="fa fa-angle-right right-arrow"></i>
                </a>
            </div>
        </div>
    @endforeach
</amp-selector>