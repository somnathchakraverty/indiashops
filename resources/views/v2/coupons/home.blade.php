@extends('v2.master')
@if(isset($meta) && is_object($meta))
@section('meta_desciption')
    <meta name="description" content="{{$meta->description}}">
@endsection
@section('title')
    <title>{{$meta->title}}</title>
@endsection
@endif
@section('meta')
    <link rel="canonical" href="{{route('coupons_v2')}}"/>
@endsection
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a href="{{route('home_v2')}}">Home</a> >> <a href="#">Coupons</a></li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="container MT15">
        <div class="row">
            <div class="col-md-3 PR0 PL0">
                <div class="sub-title"><span>Filters</span></div>
                <div class="shadow-box min-hight756">
                    <ul class="nav-left">
                        @foreach( $top_categories as $category )
                            <li class="active">
                                <a href="{{route('category_page_v2',create_slug($category->name))}}"><i
                                            class="fa {{$category->icon_class}}"></i>{{$category->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="col-md-9">
                <div class="product-listingbanner"><a href="#"><img
                                class="img-responsive" src="{{asset('assets/v2/')}}/images/coupon/coupon-banner.jpg">
                    </a></div>
                <div class="sub-title MT10">
                    <span>Top Brands</span>
                    <ul class="customNavigation">
                        <li><a class="prev1 prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next1"><i class="fa fa-angle-right"></i></a></li>

                    </ul>
                </div>

                <div id="owl-demo1" class="owl-carousel owl-theme">
                    <div class="item">
                        <div class="thumbnailcoupons P-TB MTB15">
                            <a href="{{route('vendor_page_v2','dominos')}}">
                                <img src="{{asset('assets/v2/')}}/images/brand-logo1.png" class="couponssitenamenew">
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="thumbnailcoupons P-TB MTB15">
                            <a href="{{route('vendor_page_v2','expedia')}}">
                                <img src="{{asset('assets/v2/')}}/images/brand-logo2.png" class="couponssitenamenew">
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="thumbnailcoupons P-TB MTB15">
                            <a href="{{route('vendor_page_v2','paytm')}}">
                                <img src="{{asset('assets/v2/')}}/images/brand-logo3.png" class="couponssitenamenew">
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="thumbnailcoupons P-TB MTB15">
                            <a href="{{route('vendor_page_v2','foodpanda')}}">
                                <img src="{{asset('assets/v2/')}}/images/brand-logo4.png" class="couponssitenamenew">
                            </a>
                        </div>
                    </div>
                    <div class="item">
                        <div class="thumbnailcoupons P-TB MTB15">
                            <a href="{{route('vendor_page_v2','amazon')}}">
                                <img src="{{asset('assets/v2/')}}/images/brand-logo.png" class="couponssitenamenew">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="sub-title">
                    <span>New Coupon</span>
                    <ul class="customNavigation">
                        <li><a class="prev2 prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next2"><i class="fa fa-angle-right"></i></a></li>

                    </ul>
                </div>

                <div id="owl-demo2" class="owl-carousel owl-theme">
                    @foreach( $product as $c )
                        <?php $coupon = $c->_source; unset($c); ?>
                        <div class="item">
                            <div class="thumbnailcoupons2">
                                <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code"
                                   data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}">
                                    <img src="{{$coupon->image_url}}" class="couponssitenamenew">
                                </a>
                                <h4 class="sub-title1 MB10 font-14">{{$coupon->title}}</h4>
                                <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code"
                                   data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}"
                                   onClick="ga('send', 'event', 'coupon', 'click');">
                                    <img src="{{asset('assets/v2/')}}/images/coupon-icon.gif"
                                         class="couponscodename img-responsive">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-9 PL0">

                <div class="sub-title">
                    <span>Hot Deal's</span>
                    <ul class="customNavigation">
                        <li><a class="prev3 prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next3"><i class="fa fa-angle-right"></i></a></li>

                    </ul>
                </div>

                <div id="owl-demo3" class="owl-carousel owl-theme">
                    @foreach( $product1 as $c )
                        <?php $coupon = $c->_source; unset($c); ?>
                        <div class="item">
                            <div class="thumbnailcoupons3">
                                <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code"
                                   data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}">
                                    <img src="{{$coupon->image_url}}" class="couponssitenamenew">
                                </a>
                                <h4 class="sub-title1 MB10 font-14">{{$coupon->title}}</h4>
                                @if( $coupon->type != 'promotion' )
                                    <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code"
                                       data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}"
                                       onClick="ga('send', 'event', 'coupon', 'click');">
                                        <img src="{{asset('assets/v2/')}}/images/coupon-icon.gif"
                                             class="couponscodename2 img-responsive">
                                    </a>
                                @else
                                    <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code" data=""
                                       out-url="{{$coupon->offer_page}}"
                                       onClick="ga('send', 'event', 'coupon', 'click');">
                                        <img src="{{asset('assets/v2/')}}/images/coupon-icon.gif"
                                             class="couponscodename2 img-responsive">
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="sub-title MT10"><span>Recently Used Coupons</span>
                    <ul class="customNavigation">
                        <li><a class="prev4 prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next4"><i class="fa fa-angle-right"></i></a></li>

                    </ul>
                </div>
                <div id="owl-demo4" class="owl-carousel owl-theme">
                    @foreach( $recent as $c )
                        <?php $coupon = $c->_source; unset($c); ?>
                        <div class="item">
                            <div class="thumbnailcoupons3">
                                <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code"
                                   data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}">
                                    <img src="{{$coupon->image_url}}" class="couponssitenamenew">
                                </a>
                                <h4 class="sub-title1 MB10 font-14">{{$coupon->title}}</h4>
                                @if( $coupon->type != 'promotion' )
                                    <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code"
                                       data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}"
                                       onClick="ga('send', 'event', 'coupon', 'click');">
                                        <img src="{{asset('assets/v2/')}}/images/coupon-icon.gif"
                                             class="couponscodename2 img-responsive">
                                    </a>
                                @else
                                    <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code" data=""
                                       out-url="{{$coupon->offer_page}}"
                                       onClick="ga('send', 'event', 'coupon', 'click');">
                                        <img src="{{asset('assets/v2/')}}/images/coupon-icon.gif"
                                             class="couponscodename2 img-responsive">
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @if( isset($products) )
                <div class="col-md-3 PL0">
                    <div class="sub-title" style="margin-top:12px;"><span>Top 10 Mobiles Below 15000</span></div>
                    <ul class="product-listtopmobile">
                        @foreach($products as $pro)
                            <?php $pro = $pro->_source ?>
                            <li>
                                <div class="pull-left">
                                    <a href="{{product_url($pro)}}">
                                        <img alt="100%x200" class="productmobimleft"
                                             src="{{getImageNew($pro->image_url, 'M')}}">
                                    </a>
                                </div>
                                <aside class="PT15">
                                    <a href="{{product_url($pro)}}">{{$pro->name}}</a>
                                    <div class="phonerattinghome">
                                        <div class="star-rating">
                                            <span class="fa fa-star" data-rating="1"></span>
                                            <span class="fa fa-star" data-rating="2"></span>
                                            <span class="fa fa-star" data-rating="3"></span>
                                            <span class="fa fa-star" data-rating="4"></span>
                                            <span class="fa fa-star-o" data-rating="5"></span>
                                        </div>
                                    </div>
                                    <span class="price">Rs. {{number_format($pro->saleprice)}}</span>
                                </aside>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-12 PL0">
                <div class="sub-title MT10"><span>Most Used Coupons</span>
                    <ul class="customNavigation">
                        <li><a class="prev5 prevtab"><i class="fa fa-angle-left"></i></a></li>
                        <li><a class="next5"><i class="fa fa-angle-right"></i></a></li>

                    </ul>
                </div>
                <div id="owl-demo5" class="owl-carousel owl-theme">
                    @foreach( $most as $c )
                        <?php $coupon = $c->_source; unset($c); ?>
                        <div class="item">
                            <div class="thumbnailcoupons3">
                                <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code"
                                   data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}">
                                    <img src="{{$coupon->image_url}}" class="couponssitenamenew">
                                </a>
                                <h4 class="sub-title1 MB10 font-14">{{$coupon->title}}</h4>
                                @if( $coupon->type != 'promotion' )
                                    <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code"
                                       data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}"
                                       onClick="ga('send', 'event', 'coupon', 'click');">
                                        <img src="{{asset('assets/v2/')}}/images/coupon-icon.gif"
                                             class="couponscodename2 img-responsive">
                                    </a>
                                @else
                                    <a href="{{route('coupons_v2')}}?code={{$coupon->promo}}" class="get-code" data=""
                                       out-url="{{$coupon->offer_page}}"
                                       onClick="ga('send', 'event', 'coupon', 'click');">
                                        <img src="{{asset('assets/v2/')}}/images/coupon-icon.gif"
                                             class="couponscodename2 img-responsive">
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @include('v2.coupons.modal');
    <!-- /.modal -->
@endsection

@section('script')
    <script>
        var show_code = {{(isset($show_code)) ? 'true' : 'false'}};
        $(document).ready(function () {

            var sliders = [1, 2, 3, 4, 5];

            $.each(sliders, function (index, slider) {
                var owl = $("#owl-demo" + slider);
                owl.owlCarousel({
                    items: 4,
                    itemsDesktop: [1000, 5],
                    itemsDesktopSmall: [900, 3],
                    itemsTablet: [600, 2],
                    itemsMobile: false
                });
                $(".next" + slider).click(function () {
                    owl.trigger('owl.next');
                });
                $(".prev" + slider).click(function () {
                    owl.trigger('owl.prev');
                });
            });
        });

        $(document).ready(function () {
            $(document).on('click', '.get-code', function () {
                var data = $(this).attr('data');
                data = atob(data);

                setCookie('selected_coupon', data, 1);
                window.open($(this).attr('href'));
                window.location = $(this).attr('out-url');
                return false;
            });

            if (show_code) {
                try {
                    var data = JSON.parse(getCookie('selected_coupon'));

                    if (data.code.length > 0) {
                        $('#coupon-code').html("<span>Coupon Code: " + data.code + "</span>");
                        $('#coupon-title').html(data.description);
                        $('#couponModal').modal('show');
                        setCookie('selected_coupon', '', -1);
                    }
                }
                catch (e) {
                    console.log(e)
                }
            }
        });
    </script>
@endsection