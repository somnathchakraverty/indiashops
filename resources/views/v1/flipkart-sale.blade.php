<?php
  $cur_url = Request::url();
  if( empty( $c_name ) )
   $c_name = "";
?>
@if ( !isset($ajax) )
   @extends('v1.layouts.master')
   @section('meta')
      <link rel="canonical" href="{{Request::URL()}}"/>
      <meta name="keywords" content="flipkart, android, tech, phones, smartphones, freedom sale, offers">
      <meta name="news_keywords" content="Freedom Sale Store, Freedom Sale Store Online Shopping Discount Deals Offers Coupons Vouchers"/>
      <meta name="taboola:title" content="Freedom Independance Sale, Get the Freedom of shopping on the best offers on Independence Day Products Sale online in India | Flipkart.com only on Indiashopps.com"/>
   @endsection
   @section('title')
      <title>{{$title}}</title>
   @endsection
   @section('description')
      <meta name="description" content="Buy Freedom Sale Products online, Aug 10-12, 10% additional instant discount on HDFC Credit & Debit Cards.Cash on delivery at India's very own favourite Online Shop - Flipkart.com only at Indiashopps.com"/>
   @endsection
   @section('content')
   <?php $flipkart_url = 'https://www.flipkart.com/offers-list/freedom-sale-specials?screen=dynamic&pk=contentTheme%3DIDFoz-FSS-TV-print_widgetType%3DdealCard&affid=affiliate7&affExtParam1=site'; ?>
    <!--==========Slider===============- -->
    <div class="container-fliud">
      <a href="{{$flipkart_url}}" target="_blank">
      <img class="img-responsive" width="100%" src="/images/v1/flipkart/flipkart_slider.png" alt="" />
      </a>
    </div>
   <!--==============All product=============-->	
   <div class="container">
      <div class="flipkart_banner">
        <p class="description">Keeping the spirit high of Make In India , our very own Indian E-commerce site is celebrating Independance Day by running a great Independance Day Sale from 10th - 12th August. Sale will have amazing deals and offers on variety of categories ranging from Mobiles , Laptops , Cameras , Electronics , Clothing , Shoes etc. As all Indians love to shop online so this is a great change to capitalize of amazing discounts. Flipkart Independance Sale on IndiaShopps.com </p>
        <h1 class="flipkart_sale_heading">Flipkart Freedom Sale More Deals More Saving </h1>
        <a href="{{$flipkart_url}}" target="_blank"><img class="img-responsive" src="/images/v1/flipkart/flipkart_banner1.png" alt="" /></a>
        <a href="{{$flipkart_url}}" target="_blank"><img class="img-responsive" src="/images/v1/flipkart/flipkart_banner2.png" alt="" /></a>
        <a href="{{$flipkart_url}}" target="_blank">
         <img class="img-responsive" src="/images/v1/flipkart/flipkart_banner3.png" alt="" />
        </a>
        <img class="img-responsive" src="/images/v1/flipkart/flipkart_banner4.png" alt="" />
      </div>
    </div>
   @endsection
   @section('script')
   
   <style type="text/css">
    .flipkart_banner{
          margin: 0 auto;
        width: 978px;
    }
    .flipkart_sale_heading {
        color: #d70d00;
        font-size: 18px;
    }
    .description {
        font-size: 14px;
    }
   </style>
   @endsection
@endif