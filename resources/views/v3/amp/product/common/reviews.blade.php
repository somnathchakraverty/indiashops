@if(isset($vendors) && hasReviews($vendors))
    <amp-carousel class="full-bottom" height="175" layout="fixed-height" type="carousel">
        @foreach( $vendors as $v )
            @if(hasReviews($v,false))
                <div class="thumnail">
                    <div class="productdetailsimgcard">
                        <amp-img class="productimg" src="{{ config('vendor.vend_logo.'.$v->vendor) }}" width="156" height="53" alt="flipkart"></amp-img>
                    </div>
                    <div class="loans-container reviewscont">
                        <div class="product_name reviewscontproduct_name">
                            User rating on {{ucwords(config('vendor.name.'.$v->vendor))}}
                        </div>
                        <div class="pdpuserrating">
                            <div class="prodtailspagerating">
                                <div class="star-ratings-sprite">
                                    {!! ampStar($v->rating) !!}
                                </div>
                            </div>
                            <div class="revietext">{{ $v->rating }}/5</div>
                        </div>
                    </div>
                    <a href="{{$v->review_link}}" class="productbutton" rel="nofollow" target="_blank">
                        Read {{$v->review_count}} reviews
                    </a>
                </div>
            @endif
        @endforeach
    </amp-carousel>
@endif