@extends('v1.layouts.master')
@section('content')

<!--==============All product=============-->	
<div class="container">
   <div class="row">
      <div class="col-md-12 col-xs-12 product-detail-tag-line">
      {!! Breadcrumbs::render() !!}
      </div>
   </div>
   <div class="update-nag">
      <div class="row">
         <div class="col-md-1 col-sm-2 col-xs-4">
            <div class="update-split">Trending</div>
         </div>
         <div class="col-md-11 col-sm-10 col-xs-8">
            <div class="update-text">
               <marquee class="trending_logo">
                  <img src="<?=asset("")?>images/v1/vendor_logo/amazon_logo.png" width="88" height="31" alt="Tutorials " border="0">
                  <img src="<?=asset("")?>images/v1/vendor_logo/flipkart_logo1.png" width="88" height="31" alt="Tutorials " border="0">
                  <img src="<?=asset("")?>images/v1/vendor_logo/jabong_logo.png" width="88" height="31" alt="Tutorials " border="0">
                  <img src="<?=asset("")?>images/v1/vendor_logo/homeshop18_logo.png" width="88" height="31" alt="Tutorials " border="0">
                  <img src="<?=asset("")?>images/v1/vendor_logo/ebayi_logo.png" width="88" height="31" alt="Tutorials " border="0">
                  <img src="<?=asset("")?>images/v1/vendor_logo/fabfurnish_logo.png" width="88" height="31" alt="Tutorials " border="0">           
                  <img src="<?=asset("")?>images/v1/vendor_logo/firstcry_logo.png" width="88" height="31" alt="Tutorials " border="0">
               </marquee>
            </div>
         </div>
      </div>
   </div>
   <!-- **************-women************** -->
   @foreach( $products as $grp => $gproducts ) 
   <h3 class="trending_pro_heading">{{ucwords($grp)}}</h3>
   <hr>
   <div class="trending_pro_bg">
      <div class="carousel slide media-carousel" id="{{create_slug($grp)}}">
         <div class="carousel-inner">
         <?php $closed = false; ?>
            @foreach( $gproducts as $key => $p )
               <?php $key++;?>
               <?php $closed = false; ?>
               @if( $key%4 == 1 )
               <div class="item  {{ ( $key == 1 ) ? 'active' : ''}}">
                  <div class="row">
               @endif
                     <?php
                        $pro = $p->_source;

                        if( $pro->vendor != 0 )
                           $proURL = newUrl('product/'.create_slug($pro->name)."/".$p->_id );
                        else
                           $proURL = newUrl('product/'.create_slug($pro->name)."/".$pro->id );

                        if(json_decode($pro->image_url) != NULL)
                        {
                           $img = json_decode($pro->image_url);
                        }
                        else
                        {
                           $img = $pro->image_url;
                        }

                        if(is_array($img))
                           $img = $img[0];

                        $img = getImageNew($img,'S');
                     ?>
                     <!-- **************Products..************** -->
                     <div class="col-md-3 col-sm-3">
                        <div class="thumbnail trending-item">
                           <a href="{{$proURL}}" class="trending-item_img">
                              <img class="img-responsive lazy" src="{{$img}}">
                           </a>
                           <div class="caption">
                              <div class="trending-title">
                                 <a href="{{$proURL}}">{{$pro->name}}</a>
                              </div>
                              <div class="row">
                                 @if( !empty( $pro->price))
                                 <div class="col-md-6 col-xs-6 btn-product">
                                    <del class="hidden-sm">Rs. {{number_format($pro->price)}}</del>
                                 </div>
                                 @endif
                                 <div class="col-md-6 col-sm-12 col-xs-6 btn-product">
                                    <a href="{{$proURL}}">Rs. {{number_format($pro->saleprice)}}</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
               @if( $key%4 == 0 )
                  <?php $closed = true; ?>
                  </div>
               </div>
               @endif
            @endforeach
            <?php if( !$closed ) echo '</div></div>'; ?>
         </div>
         <a data-slide="prev" href="#{{create_slug($grp)}}" class="left carousel-control">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
         </a>
         <a data-slide="next" href="#{{create_slug($grp)}}" class="right carousel-control">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
         </a>
      </div>    
   </div>
   @endforeach
</div>
<br/>
@endsection
@section('script')

@endsection