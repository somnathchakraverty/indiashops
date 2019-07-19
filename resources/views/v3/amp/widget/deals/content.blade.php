<amp-carousel class="full-bottom" height="210" layout="fixed-height" type="carousel">
    @foreach( $deals as $deal )
        <div class="thumnail">
            <div class="loansthumnailimgbox">
                <a href="{{route('vendor_page_v2',[create_slug($deal->key)])}}" target="_blank">
                    <amp-img class="banklogoimg" src="{{get_file_url("images/coupons/logos/".create_slug($deal->key).".jpg")}}" width="100" height="100" alt="{{ucwords($deal->key)}}"></amp-img>
                </a>
            </div>
            <div class="loans-container">
                <div class="product_name textcenter">{{$deal->doc_count}} Offers</div>
                <div class="rate-starts">Cashback upto 60%</div>
            </div>
            <a href="{{route('vendor_page_v2',[create_slug($deal->key)])}}" class="productbutton">Explore Offers</a></div>
    @endforeach
</amp-carousel>