<section>
    <amp-accordion>
        <?php $key = 0; ?>
        @foreach( $vendors as $vendor_name => $products )
            <section {!! ($key++ == 0) ? 'expanded' : '' !!}>
                <h4 class="belowprice2 borderbottom">{{ucwords($vendor_name)}}
                    <i class="fa fa-angle-right rightarrowtab"></i>
                </h4>
                <div class="container">
                    <div class="carousel">
                        <amp-carousel class="full-bottom" height="370" layout="fixed-height" type="carousel">
                            @foreach($products as $product )
                                @include('v3.common.product.amp.card', [ 'product' => $product ])
                            @endforeach
                        </amp-carousel>
                    </div>
                    @php
                        $brand_url = route('brands.listing',[
                            cs($product->grp),
                            cs($vendor_name),
                            cs($product->category),
                        ]);
                    @endphp
                   
                        <a class="top_dels_phns" href="{{$brand_url}}">
                            VIEW ALL {{ucwords($vendor_name)}} PHONES <i class="fa fa-angle-right right-arrow"></i>
                        </a>
                   
                </div>
            </section>
        @endforeach
    </amp-accordion>
</section>