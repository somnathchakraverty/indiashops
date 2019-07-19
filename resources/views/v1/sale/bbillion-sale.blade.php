<?php
  $cur_url = Request::url();
  if( empty( $c_name ) )
   $c_name = "";
?>
@if ( !isset($ajax) )
   @extends('v1.layouts.master')
   @section('meta')
      <link rel="canonical" href="{{Request::URL()}}"/>
      <meta name="keywords" content="flipkart, Online Shopping, online mobile shopping ,phones, smartphones, big billion sale, offers">
      <meta name="news_keywords" content="flipkart, Online Shopping, online mobile shopping ,phones, smartphones, big billion sale, offers"/>
      <meta name="taboola:title" content="flipkart, Online Shopping, online mobile shopping ,phones, smartphones, big billion sale, offers | Flipkart.com only on Indiashopps.com"/>
   @endsection
   @section('title')
      <title>{{$title}}</title>
   @endsection
   @section('description')
      <meta name="description" content="Flipkart Big Billion Day Sale, Oct 1-5, 10% additional instant discount on SBI Credit & Debit Cards. Discount Coupons, Vouchers , Deals also available. Cash on delivery at India's very own favourite Online Shop - Flipkart.com only at Indiashopps.com"/>
   @endsection
   @section('content')
      <!--==========Slider===============- -->
      <div class="container-fliud">
        <img class="img-responsive" width="100%" src="images/v1/flipkart_img/india_biggest_sale_slider.jpg" alt="flipkart The Big Billion Day Sale" />
        <!--==============All product=============--> 
        <div class="container">
          <hr>
          <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12">
              <a href="#">
                <img class="img-responsive" width="100%" src="images/v1/flipkart_img/2_oct.jpg" alt="flipkart The Big Billion Day Sale on 2nd october 2016">
              </a>
            </div>    
            <div class="col-md-3 col-sm-3 col-xs-12">
              <a href="#">
                <img class="img-responsive" width="100%" src="images/v1/flipkart_img/3_oct.jpg" alt="flipkart The Big Billion Day Sale on 3rd tober 2016" />
              </a>
            </div>  
            <div class="col-md-3 col-sm-3 col-xs-12">
              <a href="#">
                <img class="img-responsive" width="100%" src="images/v1/flipkart_img/4_oct.jpg" alt="flipkart The Big Billion Day Sale on 4th tober 2016" />
              </a>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <a href="#">
                <img class="img-responsive" width="100%" src="images/v1/flipkart_img/5_oct.jpg" alt="flipkart The Big Billion Day Sale on 5th and 6th october 2016" />
              </a>
            </div>    
          </div>
        </div>
          <img class="img-responsive" width="100%" src="images/v1/flipkart_img/discount_sale.jpg" alt="flipkart The Big Billion Day Sale SBI 10% instant discount" />
        <div class="container">
          <div class="row">
            <div class="col-md-7 col-sm-8 col-xs-12">
              <h1 class="biggest_sale_heading">Flipkart | The Big Billion Day Sale is back. Itne mein Itnaa.</h1>
              <div class="biggest_sale_content">
                The Big Billion Day Sale is back. The punch line this time is "Itne mein Itnaa" .
                As consumers we hope this time Flipkart team has done all the homework to perfection. Unlike the first time when site got crashed and deliveries were not done. Moreover, some users also spotted artificial price increase just to show high discounts. In this scenario comparative sites like www.indiashopps.com comes pretty handy. All user have to do is compare the price before they hit the buy button. There can be further reduction if users get discount coupons codes vouchers clubbed with cashback from SBI Credit Debit cards. The online shopping experience with the crazy deals should be a pleasant one. After all its festive season , the mood should be festive. 
              </div>
              <h5><b>Lets hope Flipkart live up to the punch line of "itne mein Itnaa".</b></h5>
            </div>    
            <div class="col-md-5 col-sm-4 col-xs-12">
              <img class="img-responsive" width="100%" src="images/v1/flipkart_img/be_ready1.jpg" alt="flipkart The Big Billion Day Sale" />
            </div>    
          </div>
        </div>
      </div>
   @endsection
   @section('script')   
       <style>
      .biggest_sale_heading{
        color: #d70d00;
        font-family: initial;
        font-size: 29px;
      }
      .biggest_sale_content {
        color: #999;
        font-size: 15px;
      }
    </style>
   @endsection
@endif