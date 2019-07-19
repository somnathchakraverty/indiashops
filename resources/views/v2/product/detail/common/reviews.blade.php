@if(isset($reviews) && isset($reviews->reviews) && isset($reviews->total))
    <div class="whitecolorbg">
        <div class="sub-title"><span>{{ucwords($name)}} - customer reviews</span></div>
        {{--<div class="col-md-5"><a href="#" class="btn btn-success buttonreviews">WRITE A REVIEW</a></div>--}}
        <h3>{{$reviews->total}} user reviews</h3>
        @foreach($reviews->reviews as $r)
            <h4>{{$r->title}}</h4>
            <div class="reviewsdate">{{$r->review_date}} By {{config('vendor.name.'.$r->vendor)}} customer
                on {{config('vendor.url.'.$r->vendor)}}</div>
            <p>{{$r->text}}</p>
        @endforeach
        @if( $reviews->total > 5 )
            <a href="{{route('mobile_review_page',[create_slug($name),$product_id])}}" class="reviewslink" target="_blank" rel="nofollow">{{ucwords($name)}} User Reviews</a>
        @endif
    </div>
@endif