@if(isset($vendors) && !empty($vendors))
    @php
        $vendors = collect($vendors)->map(function($vendor){
            if(isset($vendor->_source->rating) && !empty($vendor->_source->rating))
            {return $vendor->_source;}
        })->keyBy('vendor');
    @endphp
    @if(hasReviews($vendors))
        <div class="trendingdeals">
       <h3>Reviews and latest news</h3>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#user-review" role="tab" data-toggle="tab">
                        User Review
                    </a>
                </li>
                @if(isset($youtube_url) && !empty($youtube_url))
                    <li role="presentation">
                        <a href="#video_review" role="tab" data-toggle="tab">
                            Video Review
                        </a>
                    </li>
                @endif
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="user-review">
                    @include("v3.product.common.ajax.reviews")
                </div>
                @if(isset($youtube_url) && !empty($youtube_url))
                    <div role="tabpanel" class="tab-pane" id="video_review">
                        @include('v3.product.common.ajax.video_reviews')
                    </div>
                @endif
            </div>
            </div>
      
    @endif
@endif