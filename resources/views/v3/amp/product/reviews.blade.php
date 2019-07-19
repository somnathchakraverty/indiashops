@if(isset($vendors) && !empty($vendors))
    @php
        $vendors = collect($vendors)->map(function($vendor){
            if(isset($vendor->_source->rating) && !empty($vendor->_source->rating))
            {return $vendor->_source;}
        })->keyBy('vendor');
    @endphp
    @if(hasReviews($vendors))
        <div class="whitecolorbg">
           <div class="container bder_bott">
            <h2>Reviews and latest news</h2>
                <amp-selector role="tablist" layout="container" class="ampTabContainer">
                    <div role="tab" class="tabButton tableft15 tab40px" selected option="a">User Review</div>
                    <div role="tabpanel" class="tabContent">
                        @include("v3.amp.product.common.reviews")
                    </div>
                </amp-selector>
            </div>
        </div>
    @endif
@endif