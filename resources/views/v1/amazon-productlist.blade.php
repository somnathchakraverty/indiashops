<?php
  $cur_url = Request::url();
  if( empty( $c_name ) )
   $c_name = "";
?>
@if ( !isset($ajax) )
   @extends('v1.layouts.master')
   @section('meta')
      <meta name="news_keywords" content="amazon great india sale, amazon india sale, amazon prime, internet, sale, shopping sale"/>
      <meta name="taboola:title" content="Amazon Great India Sale Starts August 8; Prime Members Will Get Early Access to Deals"/>
      <link rel="canonical" href="{{Request::URL()}}"/>
      <meta name="description" content="Amazon India has announced that its Great India Sale will take place from August 8-10 and will give an early-access to its Prime members."/>
      <?php if( $book ):?>
         <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--c--<?=$scat?>--576" />
      <?php else: ?>
         <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--c--<?=$scat?>" />
      <?php endif; ?>
   @endsection
   @section('content')
   <div class="container-fliud container">
       <div class="amazon_slider">
         <a href="http://www.amazon.in/Great-Indian-Sale/b?ie=UTF8&node=5731634031" target="_blank">
            <img class="img-responsive" src="{{url('images/v1/amazon_slider_new.jpg')}}" alt="" />
         </a>
      </div>
   </div>
   <!--==============All product=============-->	
   <div class="container">
   	<div class="row" style="margin-top:10px;">
   		<div class="col-sm-4 col-md-3 hidden-xs">
   			@include('v1.common.amazon_filter', ['aggr' => $facets ] )
   		</div>
           <!-------------------right------------------------>			
           <div class="col-md-9 col-sm-8 col-xs-12" id="right-container"style="min-height: 709px;">
           	<!-----------------right category---------------------->
            {!! Breadcrumbs::render() !!}
            <div class="moredata">
               <p></p>
            </div>
            <div class="great_indian_sale block_product">
               <div class="title_block">
               <h3>Great Indian Sale</h3>
                  <div class="navi">
                     <a class="prevtab">
                        <i class="fa fa-angle-left"></i>
                     </a>
                     <a class="nexttab">
                        <i class="fa fa-angle-right"></i>
                     </a>
                  </div>
               </div>
               <div class="block_content">
                  <div class="row_edited">
                     <div class="great_deals slider_product">
                     <!---------item 1-------->
                     <?php $i = 0;?>
                     @foreach( $product as $key => $single )
                     <?php $pro = $single->_source; 
                        if(json_decode($pro->image_url) != NULL)
                         {
                            $img = json_decode($pro->image_url);
                         }else{
                            $img = $pro->image_url;
                         }
                         if(is_array($img))
                            $img = $img[0];
                         
                         $img = getImageNew($img,'S');
                     ?>
                        @if( true )
                        <div class="item_out">
                           <div class="item">
                              <div class="home_tab_img">
                                 <a class="product_img_link" href="{{$pro->product_url}}" target="_blank">
                                    <img src="{{$img}}" alt="{{$pro->name}} image" class="img-responsive product-item-img" />
                                 </a>
                              </div>
                              <div class="home_tab_info">
                                 <a class="product-name" href="{{$pro->product_url}}" target="_blank">
                                    {{$pro->name}}
                                 </a>
                                 <div class="row">
                                    @if( !empty( $pro->price ) )
                                    <div class="col-md-6  btn-product">
                                       <del>Rs. {{number_format($pro->price)}}</del>
                                    </div>
                                    @endif
                                    <div class="col-md-6  btn-product">
                                       <a href="{{$pro->product_url}}" target="_blank">Rs. {{number_format($pro->saleprice)}}</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endif
                     <?php unset( $product[$key] ); ?>
                     <?php
                        if( $i++ >= 11 )
                        {
                           break;
                        }
                     ?>
                     @endforeach
                     </div>
                  </div>
               </div>
            </div>
            <div class="clearfix"></div>
            <!-----------------Product 1---------------------->
            <h1 class="great_deals_heading">Great Indian Sale</h1>
            <div class="hidden-xs hidden-sm">
               <div id="appliedFilter"></div>
            </div>
            <hr>
            <div class="row" id="product_wrapper" style="min-height: 150px; margin-top: 10px;">
            <!-----------------Product 1---------------------->
   @endif
            @include('v1.common.products-amazon', [ 'product' => $product, 'book' => @$book ] )
   @if ( !isset($ajax) )
           	</div>
           </div>
       </div>
       <div class="amazon-content">
           <p>The Amazon Great Indian Sale 2017 is just here and is ready to go your senses drool over it. The e-commerce giant is hugely prepared to gladden its customers with exciting offers, irresistible deals and hefty discounts on 11th, 12th, 13th and 14th May 2017. It’s a massive Summer Sale, where you will be able to find all what you need. Just get ready to stock up your home because you will not be able to hold back seeing such unbelievable prices of the products. Savings are for sure going to be huge for this season.
           <p>Anyone who is planning to buy anything should wait till the sale and buy everything they need and want. The offers and discounts will be almost on every category including <a href="http://www.indiashopps.com/electronics" target="_blank">electronics</a>, <a href="http://www.indiashopps.com/women/accessories-price-list-in-india.html" target="_blank">fashion accessory</a>, <a href="http://www.indiashopps.com/women/clothing-price-list-in-india.html" target="_blank">apparel</a>, <a href="http://www.indiashopps.com/appliances/home-appliances-price-list-in-india.html" target="_blank">home appliances</a>, <a href="http://www.indiashopps.com/books" target="_blank">books</a>, <a href="http://www.indiashopps.com/men/shoes-price-list-in-india.html" target="_blank">footwear</a>, <a href="http://www.indiashopps.com/mobile/mobile-accessories-price-list-in-india.html" target="_blank">mobile accessories</a>, gadgets and everything you can think of.
           <p>Amazon Great Indian Sale is a big call from Amazon to its customers of which the latter should make full use of. You can call the same by various names- Amazon Great Indian Sale 2017, Amazon Great Indian Festival Offers, Amazon Great Indian Sale Offers.
           <p>The attractive deals will be lightning deals, best deals and short time deals. Gear up yourselves to grab maximum from Amazon Great Indian Sale. Shop the wide range of products at the prices you have never imagined and discounts you have never thought of. Get deals and offers on clothing, electronics, home and kitchen appliances, sports etc.
           <p>Besides offering huge deals, offers and discounts Amazon Great Indian Sale will also offer you additional discounts if you happen to be a credit and debit card holder from few banks which include HDFC Bank, Axis Bank, CitiBank, SBI and few more reputed banks. Using these banks will let you fetch even more cashbacks and returns.
           <h4>Here’s How to get Discounts on Amazon Great Indian Sale May 2017</h4>
           <ul>
               <li>Visit Great Indian Festival Sale Page</li>
               <li>Select the product you wish to buy</li>
               <li>Add your product to the shopping cart</li>
               <li>If you want to shop more products add them to the cart</li>
               <li>Once you are finished with selecting your products visit your cart</li>
               <li>Now enter the address you want your products to be delivered at</li>
               <li>Select the payment mode as per your wish and follow the payment process.</li>
               <li>If you are the holder of above mentioned credit or debit cards pay via same to avail the additional discount on your shopping.</li>
           </ul>

           <h4>A Sneak Peek into the percentage of discounts for various categories. Let’s have a look:</h4>
           <ul>
               <li><a href="http://www.amazon.in/Mens-Clothing/b/ref=nav_shopall_sbc_mfashion_clothing?ie=UTF8&node=1968024031&tag=indiashopps-21" target="_blank">Men’s Clothing at 40-80% OFF </a></li>
               <li><a href="http://www.amazon.in/s/ref=mega_sv_s23_2_2_1_1?rh=i%3Ashoes%2Cn%3A1983518031&ie=UTF8&lo=shoes&tag=indiashopps-21" target="_blank">Men’s Shoes at 40-80% OFF </a></li>
               <li>Get 40-70% off on Branded MenFootwear</li>
               <li><a href="http://www.amazon.in/s/ref=mega_sv_s23_2_3_1_1?rh=i%3Awatches%2Cn%3A2563504031&ie=UTF8&lo=watches&tag=indiashopps-21" target="_blank">Men’s Watches at 40-80% OFF </a></li>
               <li><a href="http://www.amazon.in/s/ref=mega_sv_s23_4_1_1_1?rh=i%3Aluggage%2Cn%3A2917431031&ie=UTF8&lo=luggage&tag=indiashopps-21" target="_blank">Bags & Bagpacks at 40-80% OFF </a></li>
               <li><a href="http://www.amazon.in/s/ref=mega_sv_s23_1_1_1_1?rh=i%3Aapparel%2Cn%3A1953602031&ie=UTF8&lo=apparel&tag=indiashopps-21" target="_blank">Women’s Clothing at 40-80% OFF </a></li>
               <li><a href="http://www.amazon.in/s/ref=mega_sv_s23_1_2_1_1?rh=i%3Ashoes%2Cn%3A1983578031&ie=UTF8&lo=shoes&tag=indiashopps-21" target="_blank">Women’s Shoes, Sandals, Slippers at 40-80% OFF </a></li>
               <li><a href="http://www.amazon.in/s/ref=mega_sv_s23_1_3_2_1?rh=i%3Ajewelry%2Cn%3A7124358031&ie=UTF8&lo=jewelry&tag=indiashopps-21" target="_blank">Women’s Jewellery at Flat 80% OFF </a></li>
               <li>Get 50-70% off on branded women footwear</li>
               <li><a href="http://www.amazon.in/Trimmers-Clippers/b/ref=dp_bc_4?ie=UTF8&node=1374654031&tag=indiashopps-21" target="_blank"> Trimmers at Flat 25% OFF </a></li>
               <li><a href="http://www.amazon.in/gp/browse.html/ref=pe_3062351_153483841_pe_row7_b4/?node=6629031031&tag=indiashopps-21" target="_blank">Beauty Products at upto 35% OFF </a></li>
               <li><a href="http://www.amazon.in/Handbags-Clutches/b/ref=nav_shopall_sbc_wfashion_handbags?ie=UTF8&node=1983338031&tag=indiashopps-21" target="_blank">Handbags & Cluthes at 40-70% OFF </a></li>
               <li><a href="http://www.amazon.in/mobile-phones/b/ref=nav_shopall_sbc_mobcomp_all_mobiles?ie=UTF8&node=1389401031&tag=indiashopps-21" target="_blank">Mobile Phones at upto 35% OFF </a></li>
               <li><a href="http://www.amazon.in/s/ref=sr_hi_4?rh=n%3A976442031%2Cn%3A%21976443031%2Cn%3A4951860031%2Cn%3A1380045031%2Cn%3A4375446031&bbn=4375446031&ie=UTF8&qid=1494410295&tag=indiashopps-21" target="_blank">Mixer Grinders at upto 55% OFF </a></li>
               <li><a href="http://www.amazon.in/s/ref=s9_acss_bw_cts_WCcatse6_T1L1_w?rh=i%3Aapparel%2Cn%3A1571271031%2Cn%3A%211571272031%2Cn%3A1953602031%2Cn%3A11400137031%2Cn%3A1968542031%2Cp_98%3A10440597031&bbn=1968542031&ie=UTF8&pf_rd_m=A1K21FY43GMZF8&pf_rd_s=merchandised-search-5&pf_rd_r=19AMN9K8WK7GS33NWFN7&pf_rd_t=101&pf_rd_p=94b602dd-867b-4931-b990-c39c0b826cd8&pf_rd_i=1953602031&tag=indiashopps-21" target="_blank">Girls/Women’s Tops & Tees at 50% Off or more </a></li>
               <li><a href="http://www.amazon.in/s/ref=sr_hi_3?rh=n%3A976442031%2Cn%3A%21976443031%2Cn%3A5925789031%2Cn%3A1380015031&ie=UTF8&qid=1494410536&tag=indiashopps-21" target="_blank"> Cookwares Sets at upto 40% OFF </a></li>
               <li><a href="http://www.amazon.in/Curtains/b/ref=sn_gfs_co_hk_1380479031_2?ie=UTF8&node=1380479031&pf_rd_p=872e04a4-9cf2-4b10-9166-f25540d8d54a&pf_rd_r=1H884NXTQ9CQA04YJQC3&pf_rd_s=hk-subnav-flyout-content-5&pf_rd_t=SubnavFlyout&tag=indiashopps-21" target="_blank">Curtains at upto 50% OFF and more  </a></li>
               <li><a href="http://www.amazon.in/Washing-Machines/b/ref=sn_gfs_co_hk_1380369031_3?ie=UTF8&node=1380369031&pf_rd_p=657aed74-c4e5-4300-b12b-e225a7c7601f&pf_rd_r=1VYSSBCJ55C8ADMZVKRG&pf_rd_s=hk-subnav-flyout-content-2&pf_rd_t=SubnavFlyout&tag=indiashopps-21" target="_blank">Washing Machines at upto 25% </a> </li>
               <li><a href="http://www.amazon.in/gp/browse.html/ref=pe_2447131_144771141_pe_row8_b3/?node=10613835031&tag=indiashopps-21" target="_blank">Groceries at upto 30% OFF  </a></li>
               <li><a href="http://www.amazon.in/gp/browse.html/ref=pe_2447131_144771141_pe_row8_b4/?node=10743552031&tag=indiashopps-21" target="_blank">Household Supplies at upto 22% </a> </li>
               <li>Philips Personal care products at upto 40% OFF</li>
               <li>Get Best and Amazing Deals on Mobile Phones</li>
               <li><a href="http://www.amazon.in/Mens-Shirts/b/ref=nav_shopall_sbc_mfashion_shirts?ie=UTF8&node=1968093031&tag=indiashopps-21" target="_blank">Men’s Shirts at 30-70% OFF  </a></li>
               <li><a href="http://www.amazon.in/s/ref=s9_acss_bw_cg_ESS0227_2a1_w?rh=i%3Aapparel%2Cn%3A1571271031%2Cn%3A%211571272031%2Cn%3A1953602031%2Cn%3A1968253031%2Cp_98%3A10440597031%2Cn%3A1968255031&bbn=1968255031&ie=UTF8&pf_rd_m=A1K21FY43GMZF8&pf_rd_s=merchandised-search-5&pf_rd_r=12MF93SP0Y89A426CVH8&pf_rd_t=101&pf_rd_p=8a65307e-d0e3-4556-9de3-ab28a21da06a&pf_rd_i=1968253031&tag=indiashopps-21" target="_blank">Women’s Kurtas at 50% OFF or more  </a></li>
               <li>Casual Shoes at 50-70% OFF or more</li>
               <li><a href="http://www.amazon.in/Mens-Jeans/b/ref=nav_shopall_sbc_mfashion_jeans?ie=UTF8&node=1968076031&tag=indiashopps-21" target="_blank">Men's Jeans at Minimum 50% off  </a></li>
               <li><a href="http://www.amazon.in/s/ref=s9_acss_bw_cg_ESS0227_2b1_w?rh=i%3Aapparel%2Cn%3A13358279031%2Cn%3A1968256031%2Cp_98%3A10440597031&bbn=13358279031&ie=UTF8&pf_rd_m=A1K21FY43GMZF8&pf_rd_s=merchandised-search-5&pf_rd_r=0XR07QJXAJNXAEW4XZQN&pf_rd_t=101&pf_rd_p=8a65307e-d0e3-4556-9de3-ab28a21da06a&pf_rd_i=1968253031&tag=indiashopps-21" target="_blank">Buy Saree’s at Minimum 70% OFF  </a></li>
               <li>American Tourister at flat 50% Off more</li>
               <li>Pantaloons products at upto 50% OFF</li>
               <li>Adidas products at upto 50% OFF</li>
               <li><a href="http://www.amazon.in/s/ref=lp_3474656031_nr_p_n_pct-off-with-tax_1?fst=as%3Aoff&rh=n%3A976442031%2Cn%3A!976443031%2Cn%3A1380263031%2Cn%3A3474656031%2Cp_n_pct-off-with-tax%3A2665400031&bbn=3474656031&ie=UTF8&qid=1469801565&rnid=2665398031&tag=indiashopps-21" target="_blank"> Air Conditioners at Minimum 25% off or more  </a></li>
               <li><a href="http://www.amazon.in/s/ref=lp_3474656031_nr_p_n_pct-off-with-tax_1?fst=as%3Aoff&rh=n%3A976442031%2Cn%3A!976443031%2Cn%3A1380263031%2Cn%3A3474656031%2Cp_n_pct-off-with-tax%3A2665400031&bbn=3474656031&ie=UTF8&qid=1469801565&rnid=2665398031&tag=indiashopps-21" target="_blank"> Air Conditioners at Minimum 25% off or more  </a></li>
               <li><a href="http://www.amazon.in/s?rh=i%3Aluggage%2Cn%3A2454169031%2Cp_98%3A10440597031%2Cp_n_pct-off-with-tax%3A2665401031%2Cn%3A%212454170031%2Cn%3A2917431031%2Cn%3A2917444031&bbn=2917431031&ie=UTF8&tag=indiashopps-21" target="_blank"> Buy School Bags at 50-70% OFF  </a></li>
               <li><a href="http://www.amazon.in/s/ref=sr_nr_p_n_pct-off-with-tax_3?fst=as%3Aoff&rh=n%3A1571283031%2Cn%3A!1571284031%2Cn%3A1983338031%2Cp_98%3A10440597031%2Cn%3A1983355031%2Cp_n_pct-off-with-tax%3A2665401031&bbn=1983355031&ie=UTF8&qid=1470241942&rnid=2665398031&tag=indiashopps-21" target="_blank"> Buy Handbags at 50-70% OFF  </a></li>
               <li><a href="http://www.amazon.in/b/ref=aw_lnk_sm_t2_mobiles_memory_cards?_encoding=UTF8&node=1388965031&tag=indiashopps-21" target="_blank">Memory Cards </a> </li>
               <li><a href="http://www.amazon.in/b/ref=aw_lnk_sm_t2_mobiles_memory_cards?_encoding=UTF8&node=1388965031&tag=indiashopps-21" target="_blank">Memory Cards </a></li>
               <li><a href="http://www.amazon.in/Refrigerators/b/ref=sn_gfs_co_hk_1380365031_2/ref=mh_s9_acss_cts_larow_T1?ie=UTF8&node=1380365031&pf_rd_p=1017021887&pf_rd_r=QDJ6MFHM39HS9AY5TFYX&pf_rd_s=hk-subnav-flyout-content-2&pf_rd_t=SubnavFlyout&pf_rd_m=A1VBAL9TL5WCBF&pf_rd_s=mobile-hybrid-4&pf_rd_r=1WESDXN6T459RKE75TSZ&pf_rd_t=1201&pf_rd_p=1041816727&pf_rd_i=4951860031&tag=indiashopps-21" target="_blank">Refrigerators at upto 25% off  </a></li>
               <li><a href="http://www.amazon.in/b/ref=mh_powerbanks?_encoding=UTF8&category-name=mobileacc&node=6612025031&pf_rd_m=A1VBAL9TL5WCBF&pf_rd_s=mobile-hybrid-2&pf_rd_r=1XBDTRDQ5R5XR0ZQJW0A&pf_rd_t=30901&pf_rd_p=1042776787&pf_rd_i=1389402031&tag=indiashopps-21" target="_blank">Power Banks at upto 60% OFF  </a></li>
           </ul>

           An additional discount (+ 15% Cashback on CitiBank Debit/Credit cards on Amazon app & 10% on Amazon Site) is applicable depending upon the category.
           So much to jump on! Start creating your wish list and now because you might miss some or the other thing. We would suggest you to double check your checklist before 11th of May 2017.
           Happy Shopping at Amazon Great Indian Sale!

           http://rechargetricks.in/flipkart-big-10-sale-offers-deals.html
           https://cashbackoffer.in/flipkart-cashback-offers/

           Men’s Clothing
           <a href="http://www.amazon.in/Mens-Clothing/b/ref=nav_shopall_sbc_mfashion_clothing?ie=UTF8&node=1968024031&tag=indiashopps-21
" target="_blank">Men’s Clothing at 40-80% OFF</a>
           Men’s Shoes
           <a href="http://www.amazon.in/s/ref=mega_sv_s23_2_2_1_1?rh=i%3Ashoes%2Cn%3A1983518031&ie=UTF8&lo=shoes&tag=indiashopps-21
" target="_blank">Men’s Clothing at 40-80% OFF</a>
           Men’s Watches
           <a href="http://www.amazon.in/s/ref=mega_sv_s23_2_3_1_1?rh=i%3Awatches%2Cn%3A2563504031&ie=UTF8&lo=watches&tag=indiashopps-21
" target="_blank">Men’s Clothing at 40-80% OFF</a>
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

         $('[data-countdown]').each(function() {
           var $this = $(this), finalDate = $(this).data('countdown');
           $this.countdown(finalDate, function(event) {
             $this.html(event.strftime('%D days %H:%M:%S'));
           });
         });

         $(document).ajaxStop(function(){
            setTimeout(function(){ 
               $('[data-countdown]').each(function() {
                 var $this = $(this), finalDate = $(this).data('countdown');
                 $this.countdown(finalDate, function(event) {
                   $this.html(event.strftime('%D days %H:%M:%S'));
                 });
               });
            },1000)
         });

         var great_deals = $(".great_deals");
           great_deals.owlCarousel({
               items: 4,
               itemsDesktop: [1199, 4],
               itemsDesktopSmall: [991, 3],
               itemsTablet: [767, 2],
               itemsMobile: [480, 1],
               autoPlay: true,
               stopOnHover: false,
               addClassActive: true,
            });

           // Custom Navigation Events
         $(".great_indian_sale .nexttab").click(function() {
               great_deals.trigger('owl.next');
            })
           $(".great_indian_sale .prevtab").click(function() {
                great_deals.trigger('owl.prev');
           })
      })
   </script>
   <link rel="stylesheet" type="text/css" href="<?=newUrl('assets/v2/css/jquery-ui.css')?>" />
   <script type="text/javascript" src="<?=newUrl('assets/v2/js/jquery.lazyload.min.js')?>"></script>
   <script type="text/javascript" src="<?=newUrl('assets/v2/js/jquery-ui-1.10.3.slider.js')?>"></script>
   <script type="text/javascript" src="<?=newUrl('js/v1/productlist.js')?>"></script>
   <script type="text/javascript" src="<?=newUrl('js/v1/jquery.countdown.min.js')?>"></script>
   <script>

      <?php if( count( $product ) == 0 ):?>
         ListingPage.model.vars.auto_load  = false;
      <?php else: ?>
         ListingPage.model.vars.auto_load  = true;
      <?php endif; ?>
   </script>
   <style type="text/css">
   li {
       list-style-type: square;
   }
   .amazon-content a:link, .amazon-content a{ color: #E40046;
       text-decoration: underline; }
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
   .great_deals_heading{color: #d70d00;
    font-size: 17px;}
   
   .product-items {
    height: 350px;
   }
   .deals_time_end {
    background: #d70d00 none repeat scroll 0 0;
    bottom: 0;
    color: #fff;
    font-size: 14px;
    left: 0;
    margin-top: 10px;
    padding: 10px;
    position: absolute;
    width: 100%;}
   </style>
   @endsection
@endif