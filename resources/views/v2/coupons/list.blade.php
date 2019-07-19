@extends('v2.master')
@if(isset($list_desc) && is_object($list_desc))
    @section('meta_description')
        <meta name="description" content="{{$list_desc->description}}">
    @endsection
    @if(isset($seo_title))
        @section('title')
            <title>{{$seo_title}}</title>
        @endsection
    @endif
@elseif(isset($meta) && is_object($meta))
    @section('meta_desciption')
        <meta name="description" content="{{$meta->description}}">
    @endsection
    @section('title')
        <title>{{$meta->title}}</title>
    @endsection
@endif
@section('meta')
    <link rel="canonical" href="{{coupons_canonical_url()}}" />
@endsection
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu breadcrumbs">
                        <li>
                            <a href="{{route("home_v2")}}">Home</a> >>
                            <a href="{{route("coupons_v2")}}">Coupons</a> >>
                            @if(isset($list_desc) && isset($list_desc->h1))
                                <h1>{{ucfirst($list_desc->h1)}}</h1>
                            @else
                                <h1>{{ucfirst($title)}} Coupons</h1>
                            @endif
                        </li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('content')
    @if(@$ajax != 'true' )
    <div class="container MT15">
        <div class="row">
            <div class="col-md-3 PR0 PL0">
                <div class="sub-title"><span>Filters</span></div>
                <div class="shadow-box P0">
                    <div class="panel panel-default">
                        <div class="panel-heading listing-panel">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseone">Offer Type<i class="indicator fa fa-toggle-on  pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseone" class="panel-collapse collapse in">
                            <div class="panel-body listing-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <label class="radio-inline width100per">
                                            <input type="radio" value="all" name="type" style="width:16px; height:16px;" checked class="fltr__src">All
                                        </label>
                                    </li>
                                    <li class="list-group-item">
                                        <label class="radio-inline width100per">
                                            <input type="radio" value="promotion" name="type" style="width:16px; height:16px;" class="fltr__src">Promotion
                                        </label>
                                    </li>
                                    <li class="list-group-item">
                                        <label class="radio-inline width100per">
                                            <input type="radio" value="coupon" name="type" style="width:16px; height:16px;" class="fltr__src">Coupons
                                        </label>
                                    </li>
                                </ul>


                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if( isset($facet['left']['vendors']) )
                    {
                        $filters = $facet['left']['vendors'];
                        $key = "vendor_name";
                        $filter = "Vendor";
                    }
                    elseif( isset($facet['left']['category']) )
                    {
                        $filters = $facet['left']['category'];
                        $key = "category";
                        $filter = "Category";
                    }
                ?>
                @if(!empty($filters))
                <div class="shadow-box P0">
                    <div class="panel panel-default">
                        <div class="panel-heading listing-panel">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                   href="#collapseTwo">
                                    {{$filter}} <i class="indicator fa fa-toggle-on  pull-right"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse in">
                            <div class="panel-body listing-body">
                                <ul class="list-group">
                                    @foreach($filters as $vendor)
                                        <li class="list-group-item">
                                            <label class="checkbox-inline width100per">
                                                <input type="checkbox" value="{{$vendor->key}}" style="width:16px; height:16px;" name="{{$key}}" class="fltr__src"> {{ucwords($vendor->key)}}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="shadow-box PB85">
                    <ul class="nav-left">
                        @foreach( $top_categories as $c )
                            <li class="active">
                                <a href="{{route('category_page_v2',create_slug($c->name))}}">
                                    <i class="fa {{$c->icon_class}}"></i>{{$c->name}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>

            <div class="col-md-9" id="right_container">
                <div class="clearfix"></div>
                <div class="product-listingbanner">
                    <a href="#">
                        <?php
                            if(isset($category))
                            {
                                $banner = asset('assets/v2/')."/images/coupon/".create_slug($category).".jpg";

                                if(!file_exists(base_path("assets/v2/images/coupon/".create_slug($category).".jpg")))
                                    $banner = asset('assets/v2/')."/images/coupon/coupon-banner.jpg";
                            }
                            else
                            {
                                $banner = asset('assets/v2/')."/images/coupon/coupon-banner.jpg";
                            }
                        ?>
                        <img src="{{$banner}}" class="img-responsive" onerror="imgError(this)">
                    </a>
                </div>
                <div class="sub-title">
                    <span>{{$title}}</span> <span class="category-count">(<span id="c_total">{{$product_count}}</span> Items)</span>
                </div>
                <div id="appliedFilter"></div>
                <div id="coupon-wrapper">
        @endif
                    @if($product_count>0)
                    <ul class="product-listing">
                        @foreach( $product as $p )
                        <?php $coupon = $p->_source; unset($p) ?>
                        <li class="MB10 width100per thumbnail1 MB0">
                            <div class="col-md-12">
                            <div class="col-md-3">
                                <a href="{{Request::url()}}?code={{$coupon->promo}}" class="get-code" data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}">
                                    <img src="{{$coupon->vendor_logo}}" class="couponimgresponsive" onerror="imgError(this)">
                                </a>
                                </div>
                                <div class="col-md-6">
                                <h2 class="font-14 red-color margin0 coupontextpadding"><b>{{$coupon->title}}</b></h2>
                                <h4 class="MB10 font-14" title="{!! $coupon->description !!}" data-toggle="tooltip" data-placement="top">{!! truncate($coupon->description,100) !!}</h4>
                            </div>
                            <div class="col-md-3">
                                @if( $coupon->type != 'promotion' )
                                    <a href="{{Request::url()}}?code={{$coupon->promo}}" class="get-code" data="{{encrypt($coupon)}}" out-url="{{$coupon->offer_page}}" onClick="ga('send', 'event', 'coupon', 'click');">
                                        <img src="{{asset('assets/v2/')}}/images/coupon-icon2.png" class="PT5 pull-right responsive couponbuttlist" style="margin:5px 0px 15px 0px;">
                                    </a>
                                @else
                                    <a href="{{Request::url()}}" class="get-code" out-url="{{$coupon->offer_page}}">
                                        <img src="{{asset('assets/v2/')}}/images/coupon-icon2.png" class="PT5 pull-right responsive couponbuttlist" style="margin:5px 0px 15px 0px;" onClick="ga('send', 'event', 'coupon', 'click');">
                                    </a>
                                @endif
                            </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                        No Coupons Found..
                    @endif
                    @if(@$ajax != 'true' )
                            </div>
                </div>
                @if(isset($list_desc) && isset($list_desc->text))
                    <div class="row">
                        <div class="col-md-12 couponscont">
                            {!! html_entity_decode($list_desc->text) !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @include('v2.coupons.modal')
    @endsection
@section('script')
    <style>
        .more-less-toggle{ overflow: hidden; height: 130px;}
        .more-less-toggle.show{ height: auto; }
    </style>
    <script type="text/javascript"> var load_image = "<?=newUrl('assets/v1/images/loading.gif')?>" </script>
    <script src="{{asset('assets/v2/')}}/js/couponlist.js" type="application/javascript"></script>
    <script>
        var show_code = {{(isset($show_code)) ? 'true' : 'false'}};

        $(document).ready(function(){
            $(".indicator").click(function(){
                if( $(this).hasClass('fa-toggle-off') )
                {
                    $(this).removeClass('fa-toggle-off').addClass('fa-toggle-on');
                }
                else{
                    $(this).removeClass('fa-toggle-on').addClass('fa-toggle-off');
                }
            });

            $(document).on('click','.get-code',function(){
                var data = $(this).attr('data');

                if(typeof data != 'undefined' && data.length > 0)
                {
                    data = atob(data);
                    setCookie('selected_coupon', data, 1);
                }

                window.open($(this).attr('href'));
                window.location = $(this).attr('out-url');
                return false;
            });

            if (show_code) {
                try {
                    var data = JSON.parse(getCookie('selected_coupon'));

                    if (data.code.length > 0) {
                        $('#coupon-code').html("<span>Coupon Code: "+data.code+"</span>");
                        $('#couponModal').modal('show');
                        setCookie('selected_coupon', '', -1);
                    }
                }
                catch (e) {
                }
            }

            $('[data-toggle="tooltip"]').tooltip();
            $(document).on('click','#toggle-btn',function(){
                if($('.more-less-toggle').hasClass('show'))
                {
                    $('.more-less-toggle').removeClass('show');
                    $(this).html("Show More");
                }
                else
                {
                    $('.more-less-toggle').addClass('show');
                    $(this).html("Show Less");
                }
            });
        });
    </script>
    @endif
@endsection