@if(isset($vendors) && !empty($vendors))
    @php
        $vendors = collect($vendors)->map(function($vendor){
            if(isset($vendor->_source->rating) && !empty($vendor->_source->rating))
            {return $vendor->_source;}
        })->keyBy('vendor');
    @endphp
    @if(hasReviews($vendors))
        <div class="whitecolorbg">
        <div class="container">
            <h3>Reviews and latest news</h3>
            <div class="product-tabs">
                <ul class="tabs">
                    <li class="tab">
                        <a href="#user-review">
                            User Review
                        </a>
                    </li>
                    @if(isset($youtube_url) && !empty($youtube_url))
                        <li class="tab">
                            <a href="#video_review">
                                Video Review
                            </a>
                        </li>
                    @endif
                </ul>
            </div>            
            <div class="tab-content">
                <div class="tab-content" id="user-review">
                    @include("v3.product.common.ajax.reviews")
                </div>
                @if(isset($youtube_url) && !empty($youtube_url))
                    <div class="tab-content" id="video_review">
                        @include('v3.product.common.ajax.video_reviews')
                    </div>
                @endif
            </div>
            </div>
        </div>
    @endif
@endif