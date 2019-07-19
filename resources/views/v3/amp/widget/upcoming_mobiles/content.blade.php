<section>
    <amp-carousel class="full-bottom" height="370" layout="fixed-height" type="carousel">
        @foreach($products as $product )
            @include('v3.common.product.amp.card', [ 'product' => $product ])
        @endforeach
    </amp-carousel>
</section>