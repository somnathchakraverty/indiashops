@extends('v3.mobile.master')
<?php
$keys = collect($keys);
$fkeys = $keys->slice(0, 4);
$rkeys = $keys->slice(4);
$products = collect($products);
?>
@section('head')
    @if(hasOneUpcomingProduct($products) )
        <meta name="robots" content="index, follow"/>
    @else
        <meta name="ROBOTS" content="noindex, nofollow">
    @endif
@endsection
@section('page_content')
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
    <!--THE-PART-1-->
    <div>
        <div class="whitecolorbgcompare">
            <div class="container">
                @foreach($products as $key => $product)
                    <?php $product = $product['details']; ?>
                    <div class="thumnailcomparepage {{($key>0) ? 'borderright' : ''}}">
                        <div class="thumnailimgboxcompare">
                            <a href="{{product_url($product)}}" target="_blank">
                                <img class="comparepagproductimg" src="{{getImageNew($product->image_url,'XXS')}}" alt="productimg">
                            </a>
                        </div>
                        <div class="stats-containercompare">
                            <a class="product_name" href="{{product_url($product)}}" target="_blank">{{$product->name}}</a>
                            <div class="product_price">Rs {{number_format($product->saleprice)}}</div>
                        </div>
                        @if(!empty($product->lp_vendor))
                            <a href="{{$product->product_url}}" class="changecompare" target="_blank">
                                Buy on {{config('vendor.name.'.$product->lp_vendor)}}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!--END-PART-1-->
    <!--THE-PART-2-->
    <div>
        <div class="container">
            <div class="summary">Summary</div>
        </div>
        <div class="whitecolorbg" id="specificationstable">
            <div class="container">
                <div class="comparedetails1">
                    <div class="comparetable">
                        @foreach($keys as $section => $features)
                            <div class="parent_div">
                                <div class="parent_heading">{{html_entity_decode($section)}}</div>
                                <table>
                                    <?php $j = 0 ?>
                                    <tbody>
                                    @foreach( $features as $key => $value )
                                        <tr>
                                            <th colspan="2" style="font-size:14px!important;">{{$key}}</th>
                                        </tr>
                                        <tr>
                                            @for( $i = 0; $i <count($products); $i++ )
                                                <td>
                                                    @if( array_key_exists( $section, @$products[$i]['features']) )
                                                        @if( array_key_exists( $key, @$products[$i]['features'][$section]) )
                                                            {!! $products->get($i)['features'][$section][$key] !!}
                                                        @else
                                                            --
                                                        @endif
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
                <a class="allcateglink" href="javascript:void(0)" id="toggle-btndetails">View More
                    <span class="right-arrow"></span></a>
            </div>
        </div>
    </div>
    <!--END-PART-2-->
    <!--THE-STICKY-->
    <select-catlist>
        <div class="comparestickyfullbox">
            @foreach($products as $key => $product)
                <?php $product = $product['details']; ?>
                <div class="comparestickycomparepage {{($key>0) ? 'borderright' : ''}}">
                    <div class="comparestickyimgbox">
                        <a href="{{product_url($product)}}" target="_blank">
                            <img class="comparestickyimgpro" src="{{getImageNew($product->image_url,'S')}}" alt="productimg">
                        </a>
                    </div>
                    <div class="comparestickycomparecont">
                        <a class="comparestickyproduct_name" href="{{product_url($product)}}" target="_blank">{{$product->name}}</a>
                        <div class="comparesticky-price">Rs {{number_format($product->saleprice)}}</div>
                    </div>
                    <div style="display:block">
                        @if(!empty($product->lp_vendor))
                            <a href="{{$product->product_url}}" class="changecompare" target="_blank">
                                Buy on {{config('vendor.name.'.$product->lp_vendor)}}
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </select-catlist>
    <!--END-STICKY-->
    <style>
        .product_name { width: 147px; color: #000; padding-bottom: 10px; }
        .changecompare { padding: 5px 0px 15px 0px; }
        .parent_heading { text-align: center; font-size: 16px; font-weight: bold; padding: 15px 0px; }
        .comparetable th { padding: 10px 0px; }
        .comparetable td { font-weight: 500; padding: 10px 15px; color: #404040 !important; font-size: 13px !important; }
        .comparedetails1 { overflow: hidden !important; max-height: 330px !important; clear: both !important; }
        .comparedetails1.show { max-height: inherit !important; }
        .allcateglink { margin-top: 0px !important; }
        .comparesticky-price { padding-top: 3px; font-size: 13px; }
        .comparestickycomparepage .changecompare { padding: 2px 0px 10px 44px; display: block; float: left; font-size: 13px; clear: both; text-align: left !important; }
    </style>
@endsection
@section('scripts')
    <script>
        function uiLoaded() {}
        afterJquery(function () {
            $(window).scroll(function () {
                if ($(window).scrollTop() >= 100) {
                    $('select-catlist').addClass('fixed-comparesticky');
                }
                else {
                    $('select-catlist').removeClass('fixed-comparesticky');
                }
            });
            $(document).on('click', '#toggle-btndetails', function () {
                if ($('.comparedetails1').hasClass('show')) {
                    $('.comparedetails1').removeClass('show');
                    $(this).html("View More <span>»</span>");

                    $('html, body').animate({
                        scrollTop: $("#specificationstable").offset().top - 20
                    }, 300);
                }
                else {
                    $('.comparedetails1').addClass('show');
                    $(this).html("Show Less <span>»</span>");
                }
            });
        });
    </script>
@endsection