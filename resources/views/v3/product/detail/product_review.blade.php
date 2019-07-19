<div class="comparison">
    <h2>Product Reviews</h2>
<div class="comparisontable">
    @if(isset($product_reviews) && $product_reviews->count() > 0)
        @foreach($product_reviews as $product_review)
            <div class="spec_box">
                <div class="revLeft">
                    <div class="ratings">
                        <div class="str-rtg">
                            <span style="width:{{percent($product_review->rating,5)}}%" class="str-ratg"></span>
                        </div>
                    </div>
                    <div class="user">By: {{$product_review->user}}</div>
                </div>
                <div class="reviewscont">{!! $product_review->review !!}</div>
            </div>
        @endforeach
    @endif
    <div class="pro_review_form">
        <form method="post" id="product_review_form">
            <div class="form_data">               
                    <div id="errors" class="alert-danger"></div>              
                <div class="col-md-12">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <input type="text" class="form-control rev_fild" name="name" placeholder="Enter Your Name Here..."/>
                        <fieldset class="rating">
                            <input type="radio" id="star5" name="rating" value="5"/><label class="full" for="star5" title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4"/><label class="full" for="star4" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3"/><label class="full" for="star3" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2"/><label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1" name="rating" value="1"/><label class="full" for="star1" title="Sucks big time - 1 star"></label>
                        </fieldset>
                        
                        <textarea name="user_review" class="form-control rev_fild rev_textar" rows="5"></textarea>                
                    <input type="submit" class="btn btn-default registrationsubmit rev_butt" name="submit" value="Submit Review"/>
                    {{csrf_field()}}
               
                </div>
                <div class="col-md-2"></div>
                  </div>
            </div>
        </form>
    </div>
</div>
</div>
<style>
fieldset,label{margin:0;padding:0}
.rating{border:none;float:left}
.rating > input{display:none}
.rating > label:before{margin:5px;font-size:1.5em;font-family:FontAwesome;display:inline-block;content:"\f005"}
.rating > label{color:#ddd;float:right}
.rating > input:checked ~ label,.rating:not(:checked) > label:hover,.rating:not(:checked) > label:hover ~ label{color:#FFD700}
.rating > input:checked + label:hover,.rating > input:checked ~ label:hover,.rating > label:hover ~ input:checked ~ label,.rating > input:checked ~ label:hover ~ label{color:#FFED85}
.rev_fild{height:42px!important;border-radius:4px!important;background:#fdfdfd!important;font-size:14px;color:#000;font-weight:700}
.rating{border:none;float:left;font-size:15px;margin:10px 0}
.rev_textar{height:100px!important;font-size:14px!important;font-weight:400}
.rev_butt{margin:20px 0!important}
.spec_box .revLeft{width:18.5%;float:left}
.reviewscont{font-size:15px!important;font-weight:500;font-family:'CircularSpotifyText'}
.alert-danger{width:737px;margin:auto;padding:10px 5px;color:#ff0000!important;background:none!important;}
.alert-success{width:737px;margin:15px auto;padding:10px 5px;}
</style>