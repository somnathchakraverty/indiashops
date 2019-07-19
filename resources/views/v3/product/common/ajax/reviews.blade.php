@if(isset($vendors) && hasReviews($vendors))
<div class="reviewscartbox">
        <div class="cs_dkt_si">
            <ul data-items="2">
                @foreach( $vendors as $v )
                    @if(hasReviews($v,false))
                        <li class="thumnail">                           
                                <div class="productdetailsimgcard">
                                    <img class="productimg" src="{{ config('vendor.vend_logo.'.$v->vendor) }}" alt="{{config('vendor.name.'.$v->vendor)}}">
                                </div>
                                <div class="loans-container">
                                    <div class="product_name textcenter">
                                        User rating on {{ucwords(config('vendor.name.'.$v->vendor))}}
                                    </div>
                                    <div class="pdpuserrating">
                                        <div class="prodtailspagerating">
                                            <div class="str-rtg">
                                                <span style="width:{{percent($v->rating,5)}}%" class="str-ratg"></span>
                                            </div>
                                        </div>
                                        <div class="revietext">{{ $v->rating }}/5</div>
                                    </div>
                                </div>
                                <a href="{{$v->review_link}}" class="productbutton" rel="nofollow" target="_blank">
                                    Read {{$v->review_count}} reviews
                                </a>                            
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
        </div>
@endif