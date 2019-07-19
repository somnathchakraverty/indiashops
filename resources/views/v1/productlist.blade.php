<?php
  $cur_url = Request::url();
  if( empty( $c_name ) )
   $c_name = "";
?>
@if ( !isset($ajax) )
   @extends('v1.layouts.master')
     @if(isset($description))
      @section('description')
         <meta name="description" content="{{$description}}" /> <!-- Description from controller -->
      @endsection
   @endif
   @section('meta')      
      <?php if( $book ):?>
         <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--c--<?=$scat?>--576" />
      <?php else: ?>
         <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--c--<?=$scat?>" />
      <?php endif; ?>
   @endsection
   @section('content')
   
   <!--==============All product=============-->	
   <div class="container">
   	<div class="row">
   		<div class="col-sm-4 col-md-3 hidden-xs">
   			@include('v1.common.detail_filter', ['aggr' => $facets ] )
   		</div>
           <!-------------------right------------------------>			
           <div class="col-md-9 col-sm-8 col-xs-12" style="min-height: 709px;">
			<div id="right-container">
           	<!-----------------right category---------------------->
            <div class="col-sm-12 col-xs-12 row"><div class="alert alert-success" id="message-div" style="display: none;"></div></div>
            <div class="clearfix"></div>
            {!! Breadcrumbs::render() !!}
            <div class="bot-links">
               @if(isset($suggestion))
                  @foreach( $suggestion as $s )
                  <a href="{{$s['url']}}">{{ucwords($s['title'])}}</a>
                  @endforeach
               @endif
            </div>
            
            @if( $book )
               @if( !empty( $product ) )
                  @include('v1.common.books_desc', [ 'book' => $product[0]  ] )
               @endif
            @elseif(!empty($query))
                <h1>{{ucwords(urldecode($query))}}</h1>
            @else
               @include('v1.common.list_desc', ['c_name' => $c_name ] )
            @endif

            @if (count($product) > 0)
           	<div class="hidden-xs hidden-sm ">
           		<div id='product-list-cat-menu'>
           			<ul>
           			<li><h4 class="sort-by">Sort By:</h4></li>
                   <?php $qstr = ( Request::getQueryString() ) ? Request::getQueryString()."&" : "";
                        $search = array("sort=f&","sort=s-a&","sort=s-d&","sort=d-d&");
                        $qstr = str_replace( $search, "", $qstr);
                   ?>
           			   <li class='<?=( @$sort == "f" || @$sort == "" ) ? "active" : ""?>'><a href='?<?=$qstr?>sort=f'><h4>Fresh Arrivals</h4></a></li>
           			   <li class='<?=( @$sort == "s-a" ) ? "active" : ""?>'><a href='?<?=$qstr?>sort=s-a'><h4>Price Low to High </h4></a></li>
           			   <li class='<?=( @$sort == "s-d" ) ? "active" : ""?>'><a href='?<?=$qstr?>sort=s-d'><h4>Price High to Low </h4></a></li>
           			   <li class='<?=( @$sort == "d-d" ) ? "active" : ""?>'><a href='?<?=$qstr?>sort=d-d'><h4>Discount</h4></a></li>
           			</ul>
           		</div>
               <div id="appliedFilter"></div>
           	</div>
            <div class="row" id="product_wrapper" style="min-height: 150px; margin-top: 10px;">
            @else
           	<div class="row" id="product_wrapper" style="min-height: 150px;">
                <?php $type = ( @$book ) ? "Book" : "Product"; ?>
                <h3>Sorry!! No <?=$type ?> found!!!</h3>
                <script type="text/javascript">
                  var $no_products = true;
                </script>
            @endif  
            <!-----------------Product 1---------------------->
   @endif
            @include('v1.common.products', [ 'product' => $product, 'book' => @$book ] )
   @if ( !isset($ajax) )

           	</div>
           	</div>
			<div class="clearfix"></div>
            @include('v1.template.snippets', [ 'product' => $snippet, 'book' => @$book ] )
           </div>
       </div>
    </div>
   @endsection
   @section('script')
   <script type="text/javascript">
      var load_image = "<?=newUrl('images/v1/loading.gif')?>"; // This variable will be used by ProductList.js file
      var sort_by = "<?=@$sort?>"; // This variable will be used by ProductList.js file 
      var product_wrapper = $( "#product_wrapper" ); // This variable will be used by ProductList.js file
      var pro_min = <?=($minPrice)? $minPrice: 0 ?>; // This variable will be used by ProductList.js file 
      var pro_max = <?=($maxPrice)? $maxPrice: 0?>; // This variable will be used by ProductList.js file
      $( document ).ready(function(){
         $(document).on("mouseenter",".product-items",function(){
            $(this).addClass("hovered");
         });
         $(document).on("mouseleave",".product-items",function(){
            $(this).removeClass("hovered");
         });
      })
   </script>
   <link rel="stylesheet" type="text/css" href="<?=newUrl('css/v1/jquery-ui.css')?>" />
   <script type="text/javascript" src="<?=newUrl('js/v1/jquery-ui-1.10.3.slider.js')?>"></script>
   <script type="text/javascript" src="<?=newUrl('js/v1/productlist.js')?>"></script>
   <script type="text/javascript" src="<?=newUrl('js/v1/compare.js')?>"></script>
   <script type="text/javascript" src="<?=newUrl("js/v1/jquery.nanoscroller.js")?>"></script>
   <script>
      $(document).ready(function(){
        $(".nano").nanoScroller({ alwaysVisible: true });
        $(".nano1").nanoScroller({ alwaysVisible: true,paneClass: 'scrollPane'});
      });
      <?php if( count( $product ) == 0 || $page==0):?>
         ListingPage.model.vars.auto_load  = false;
      <?php else: ?>
         ListingPage.model.vars.auto_load  = true;
      <?php endif; ?>
   </script>
   <style type="text/css">
   div#appliedFilter {
      background: #f2f2f2 none repeat scroll 0 0;
      margin-top: 10px;
      width: auto;
   }
   h1{ font-size: 25px; color: #D70D00; }
   .wishlist-icon.wish-added{ color: #D70D00  }
   div#message-div{ margin-top: 10px; width: auto; }
   div#appliedFilter.applied{  padding: 10px; }
   div#appliedFilter div { display: inline; margin-left: 10px; }
   div#appliedFilter div:last-child{ margin-right: 10px;  }
   div#appliedFilter .fltr-label { font-weight: bolder;  }
   div#appliedFilter .clear-all{ cursor: pointer; text-decoration: underline;  }
   div#appliedFilter .single-fltr div:hover{ cursor: pointer; text-decoration: line-through;  }
   div#appliedFilter .fltr-remove{ margin-left:  5px; }
   .product-items{ position: relative;  }
   .product-items .show-more{ opacity: 0; position: absolute; top: 90%; margin-top: 0px; }
   .hovered .show-more {
     z-index: 9;
     background: #fff;
     left: -1px;
     opacity: 1;
     margin-top: -4px;
     width: 100.4%;
     border: 1px solid #dddddd;
     border-top: none;
     padding: 10px;
     -moz-transition: opacity .2s ease-in-out;
   -o-transition: opacity .2s ease-in-out;
   -webkit-transition: opacity .2s ease-in-out;
   transition: opacity .2s ease-in-out;
     top: 101%!important;
   }
   .product-items:hover
   {
   -webkit-box-shadow: 0px -4px 23px -10px rgba(215, 13, 0, 0.37);
   -moz-box-shadow: 0px -4px 23px -10px rgba(215, 13, 0, 0.37);
   box-shadow: 0px -4px 23px -10px rgba(215, 13, 0, 0.37);
   }
   .product-item:hover
   {
   -webkit-box-shadow: 0px 0px 23px -10px rgba(215, 13, 0, 0.37);
   -moz-box-shadow: 0px 0px 23px -10px rgba(215, 13, 0, 0.37);
   box-shadow: 0px 0px 23px -10px rgba(215, 13, 0, 0.37);
   }
   .hovered .show-more
   {
   -webkit-box-shadow: 0px 13px 23px -10px rgba(215, 13, 0, 0.37);
   -moz-box-shadow: 0px 13px 23px -10px rgba(215, 13, 0, 0.37);
   box-shadow: 0px 13px 23px -10px rgba(215, 13, 0, 0.37);
   }
   </style>
   @endsection
@endif