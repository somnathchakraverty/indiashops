@foreach( $reviews as $review )
    <div class="col-md-12 reviewfullnew">
        <div class="col-md-3 nopaddingleft">
            <div class="reviewleftsec">
                <div class="arrow-right"></div>
                <div class="leftpartreviewcont">
                    <div class="reviewusericon">
                        <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    </div>
                    <div class="star-ratingleftsec">
                        <div class="star-ratings-sprite">
                            <span style="width:{{percent($review->user_rating,5)}}%" class="star-ratings-sprite-rating"></span>
                        </div>
                    </div>
                    <h6>{{\Carbon\Carbon::parse($review->review_date)->format('j F, Y')}}</h6>
                    <h4>By {{$review->reviewer_name}}</h4>
                    <h3>On {{ucwords(config('vendor.name.'.$vendor))}}</h3>
                    <div class="arrow-down"></div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="reviewrightsec">
                <h2>{{$review->title}}</h2>
                <hr/>
                <p>{!! preg_replace('/\\n/','<br/>',$review->text) !!}</p>
            </div>
        </div>
    </div>
@endforeach