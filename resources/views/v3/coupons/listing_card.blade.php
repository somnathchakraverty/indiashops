@if(count($coupons) > 0)
    <?php $opened = false; ?>
    @foreach($coupons as $key => $coupon )
        <?php $coupon = $coupon->_source ?>
        <?php $parts = explode('|', $coupon->offer_name); ?>
        <div class="coufullbox">
            {{--<div class="go_hot">Hot Deal</div>--}}
            <div class="cou_cont">
                <div class="couofrbox">
                    <div class="coudis">{{$parts[0]}}
                        @if(isset($parts[1]))
                            <span>{{$parts[1]}}</span>
                        @endif
                    </div>
                </div>
                <div class="con_part">
                <div class="cou_name">{{$coupon->title}}</div>
                <div class="go-cbt"> Expires: <span>{{$coupon->expiry_date}}</span></div>
                <div class="coutwobutto">
                    @if($coupon->description)
                        <a class="cou_butto" data-toggle="collapse" href="#details{{$key}}">Show Description</a>
                    @endif
                    <a class="view_butto coupon_thum" href="javascript:void(0);" data-in-page="{{route('category_page_v2',[create_slug($coupon->category)])}}" data-type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" data-out-page="{{route('coupon_out_page',[$coupon->offerid])}}" data-code="{{base64_encode($coupon->code)}}">
                        View {{( $coupon->type == 'coupon' ) ? 'Code' : 'Offer' }}
                    </a>
                </div>
                </div>
                <div class="couofrbox cou_venr">
                    <img class="vndr_im" src="{{$coupon->image_url}}" alt="vendor logo">
                </div>
            </div>
            @if($coupon->description)
                <div class="collapse" id="details{{$key}}">
                    <div class="card card-block">
                        <!--THE-POPUP-->
                        <div class="heading">What you will love</div>
                        <div class="pros">
                            {!! $coupon->description !!}
                        </div>
                        <a data-toggle="collapse" class="clebutton" href="#details{{$key}}"> &times; </a>
                    </div>
                </div>
        @endif
        <!--END-POPUP-->
        </div>
    @endforeach
@endif
<div class="button" style="text-align: center;height: 50px;padding-top: 9px;">
    @if(isset($page) && $page > 1)
        <a href="javascript:void(0)" class="btn btn-default registrationsubmit" id="prev-page">Prev</a>
    @endif

    @if(count($coupons) == config('app.listPerPage'))
        <a href="javascript:void(0)" class="btn btn-default registrationsubmit" id="next-page">Next</a>
    @endif
</div>
