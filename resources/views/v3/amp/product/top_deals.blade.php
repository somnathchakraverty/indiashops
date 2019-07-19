<section>
    <div class="whitecolorbg">
        <div class="container">
            <?php $Category = \indiashopps\Category::find($main_product->category_id); ?>
            <h3>Popular {{ucwords($main_product->category)}}</h3>
            <amp-carousel class="full-bottom" height="350" layout="fixed-height" type="carousel">
                @foreach($deals as $product)
                    @include('v3.common.product.amp.card')
                @endforeach
            </amp-carousel>
            <div class="allcateglinkphone">
                <a href="{{getCategoryUrl($Category)}}">
                    VIEW ALL {{ucwords($main_product->category)}} <i class="fa fa-angle-right right-arrow"></i>
                </a>
            </div>
        </div>
    </div>
</section>