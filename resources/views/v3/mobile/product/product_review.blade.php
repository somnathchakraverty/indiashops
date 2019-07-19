<div class="whitecolorbg" id="product_reviews">
    <div class="container">
        <h2>Product Reviews</h2>
        <div class="comparisontable">
            @if(isset($product_reviews) && $product_reviews->count() > 0)
                @foreach($product_reviews as $product_review)
                    <div class="rev_box">
                        <div class="spcsLeft">
                            <div class="ratings">
                                <div class="star-ratings-sprite">
                                    <span style="width:{{percent($product_review->rating,5)}}%" class="star-ratings-sprite-rating"></span>
                                </div>
                            </div>
                            <div class="user">By: {{$product_review->user}}</div>
                        </div>
                        <div class="rev_cont">{!! $product_review->review !!}</div>
                    </div>
                @endforeach
            @endif
            <div class="pro_review_form">
                <form method="post" id="product_review_form">
                    <div class="form_data">
                        <div id="errors" class="alert-danger"></div>
                        <input type="text" class="rev_fild" name="name" placeholder="Enter your name here..."/>
                        <fieldset class="rating">
                            <input type="radio" id="star5" name="rating" value="5"/><label class="full" for="star5" title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4"/><label class="full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3"/><label class="full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2"/><label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1" name="rating" value="1"/><label class="full" for="star1" title="Sucks big time - 1 star"></label>
                        </fieldset>
                        <textarea name="user_review" class="rev_textar" rows="5"></textarea>
                        <input type="submit" class="btn btn-default registrationsubmit" name="submit" value="Submit Review"/>
                        {{csrf_field()}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    fieldset, label { margin: 0; padding: 0 }
    .rating { border: none; float: left }
    .rating > input { display: none }
    .rating > label:before { margin: 5px; font-size: 1.5em; font-family: FontAwesome; display: inline-block; content: "\f005" }
    .rating > label { color: #ddd; float: right }
    .rating > input:checked ~ label, .rating:not(:checked) > label:hover, .rating:not(:checked) > label:hover ~ label { color: #FFD700 !important }
    .rating > input:checked + label:hover, .rating > input:checked ~ label:hover, .rating > label:hover ~ input:checked ~ label, .rating > input:checked ~ label:hover ~ label { color: #FFED85 }
    .rev_cont { font-size: 15px; color: #000; font-family: 'CircularSpotifyText'; padding: 6px 0; display: inline-block; text-align: justify }
    .user { margin-top: 10px }
    .rev_box { width: 100%; display: inline-block; border-bottom: solid 1px #e0e0e0; padding-bottom: 6px; margin-bottom: 10px; font-weight:bold;}
    .rev_fild { height: 42px !important; border-radius: 4px !important; background: #fdfdfd !important; font-size: 14px; color: #000; font-weight: 700; width: 96%; border: 1px solid #e6e6e6; padding-left: 10px; outline: none }
    .rating { border: none; float: left; font-size: 14px; margin: 10px 0 }
    .rev_textar { height: 70px !important; border-radius: 4px !important; background: #fdfdfd !important; font-size: 14px; color: #000; font-weight: 700; width: 100%; outline: none; border: 1px solid #e6e6e6; width: 96%; font-weight: normal !important; padding-left: 10px;}
    .registrationsubmit { background-image: linear-gradient(to left, #ff774c, #ff3131) !important; color: #fff !important; outline: none; border: none; font-weight:bold; padding: 10px; margin-top: 10px; border-radius: 4px; font-size: 15px }
    .alert-danger { width: 94%; margin-left: 12px; padding: 10px 5px; color: red !important; background: none !important }
    .alert-danger li { font-size: 14px; list-style: disc }
    .alert-success { width: 94%; margin: 15px auto; padding: 10px 5px; font-size: 16px !important; color: #00CC00; }
</style>