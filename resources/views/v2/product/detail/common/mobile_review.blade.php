@extends('v2.master')
@section('breadcrumbs')

    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a href="{{route("home_v2")}}">Home</a> >> <a href="#">{{$product_name}} Reviews</a></li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('meta')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="fragment" content="!">
    <meta name="ROBOTS" content="noindex">
    <link rel="canonical" href="{{Request::url()}}" />
@endsection
<?php

if (!empty(json_decode($product->image_url))) {
    $images = json_decode($product->image_url);
} else {
    $images[] = $product->image_url;
}

?>
@section('content')
<style>
	.load_more_reviews{float:right;margin-top:15px;font-size:18px;border-radius:5px;}
.load_more_reviews .fa-spin{font-size:16px!important;}
</style>
    <div class="container whitecolorbg margintop">
        <h4>{{$product_name}} User Reviews</h4>
        <div class="col-md-3">
            <div class="reviewnewpagetop">
                <h2>OVERALL RATING</h2>
                <h3>{{$rating_average}}</h3>
                <p>BASED ON {{$total_reviews}} RATINGS</p>
            </div>
        </div>
        <div class="col-md-5">

            <div class="reviewnewpagetop">
                <div class="phonereviewsnew">

                    <ul>
                        @foreach($vendors as $vendor)
                            @if( isset($reviews->{$vendor}) && !empty($reviews->{$vendor}) )
                                <li>{{ucwords(config('vendor.name.'.$vendor))}}
                                    <div class="star-ratingreviews">
                                        <div class="star-ratings-sprite">
                                            <span style="width:{{percent($rating->{$vendor},5)}}%" class="star-ratings-sprite-rating" title="{{ $rating->{$vendor} }} Stars (Out Of 5)"></span>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="reviewnewpagetop">
                <div class="col-md-3">
                    <img class="productimgreviewnew" src="{{getImageNew($images[0], 'M')}}" alt="mobile">
                </div>
                <div class="col-md-9">
                    <a href="{{product_url($product)}}">
                        <img class="lowestpricesitenew" src="{{config('vendor.vend_logo.'.$product->lp_vendor )}}" alt="{{config('vendor.name.'.$product->lp_vendor )}}" onerror="imgError(this)">
                    </a>
                    <h6>{{$product->name}}</h6>
                    <h4>Rs. {{number_format($product->saleprice, 2)}}</h4>
                    <a class="btn btn-danger width48p buynowreview" href="{{product_url($product)}}">Buy Now</a></div>
            </div>
        </div>
        <div class="tabdesign">
            <!-- Nav tabs -->
            <ul class="nav  nav-tabsnewreview" role="tablist">
                <?php $key = 0; ?>
                @foreach($vendors as $key => $vendor)
                    @if( isset($reviews->{$vendor}) && !empty($reviews->{$vendor}) )
                    <li role="presentation" class="{{($key++ == 0) ? 'active' : ''}}">
                        <a href="#tab{{$vendor}}" aria-controls="home" role="tab" data-toggle="tab">
                            {{ucwords(config('vendor.name.'.$vendor))}}
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-contentreview">
                <?php $key = 0; ?>
                @foreach($vendors as $vendor)
                    @if( isset($reviews->{$vendor}) && !empty($reviews->{$vendor}) )
                        <div role="tabpanel" class="tab-pane {{($key++ == 0) ? 'active' : ''}}" id="tab{{$vendor}}">
                        <div id="reviews_content_{{$vendor}}">
                            @foreach( $reviews->{$vendor} as $review )
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
                        </div>
                        <div class="row">
                            <div class="col-md-3"></div>
                            <div class="col-md-9">
                                <a class="btn btn-danger load_more_reviews" href="javascript:;" vendor="{{$vendor}}" page="2" pid="{{$pid}}">Load More...</a>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="application/javascript">
        $(document).ready(function(){
            $(document).on('click',".load_more_reviews",function(e){
                el = $(this);
                var ajax_url_reviews = '{{route('reviews_ajax',$pid)}}';
                var data = [];
                var review_wrapper = $("#reviews_content_"+el.attr('vendor'));

                data['vendor'] = el.attr('vendor');
                data['page'] = el.attr('page');
                data['product_id'] = el.attr('pid');

                ajax_url_reviews += "?vendor="+data['vendor']+"&page="+data['page'];
                el.html('<i class="fa fa-circle-o-notch fa-spin fa-3x fa-fw"></i> Loading...');
                el.attr('disabled','disabled');

                $.get(ajax_url_reviews,function(response){
                    if( response.length > 0 )
                    {
                        el.html("Load More");
                        el.removeAttr('disabled');
                        el.attr('page',(parseInt(data.page)+1));
                        review_wrapper.append(response);
                    }
                    else {
                        el.remove();
                    }
                });
            });
        });
    </script>
	
@endsection