<div class="whitecolorbg">
<div class="container">
<h2>Product Reviews</h2>
        <div class="comparisontable">
            @foreach($product_reviews as $product_review)
                <div class="rev_box">
                    <div class="spcsLeft">
                        <div class="ratings">
                            <div class="star-ratings-sprite">
                                {!! ampStar($product_review->rating) !!}
                            </div>
                        </div>
                        <div class="user">By: {{$product_review->user}}</div>
                    </div>
                    <div class="rev_cont">{!! $product_review->review !!}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>