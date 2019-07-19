<?php if( Request::input('quickview') != "yes" ): ?>
<!--=======================================Footer ==============================-->
<div class="footer-container">
    <footer id="footer">
        <div class="footer_center">
			<div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-5 col-md-2 footer-block">
						<h4>Mobile List</h4>
                        <ul class="toggle-footer">
                            <li class="item-footer">
                                <a href="<?=newUrl('mobile/nokia--mobiles')?>" title="Nokia Mobiles">Nokia Mobiles</a>
                            </li>
                            <li class="item-footer">
                                <a href="<?=newUrl('mobile/samsung--mobiles')?>" title="Samsung Mobiles">Samsung Mobiles</a>
                            </li>
                            <li class="item-footer">                               
                                <a href="<?=newUrl('mobile/lg--mobiles')?>" title="LG Mobile">LG Mobile</a>
                            </li>                            
							<li class="item-footer">                               
                                <a href="<?=newUrl('mobile/motorola--mobiles')?>" title="Motorola Mobiles">Motorola Mobiles</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('mobile/sony--mobiles')?>" title="Sony Mobiles">Sony Mobiles</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('mobile/htc--mobiles')?>" title="HTC Mobiles">HTC Mobiles</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('mobile/micromax--mobiles')?>" title="Micromax Mobile">Micromax Mobile</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('mobile/apple--mobiles')?>" title="Apple Mobile">Apple Mobiles</a>
                            </li>
                        </ul>
                        <!--<div class="logo_footer">
							<img src="<?=asset("/images/v1/indiashopps_logo-final.png")?>" alt="" class="img-responsive" />
                                <p>Indiashopps.com is the fastest growing E-commerce company having presence across India. We are a comparative shopping site that has set a trend in providing best deals, coupons and offers using data algorithms. The overall goal is to provide users a site to compare all websites before they buy and not to search for best deals on 50+ sites , they can just search on Indiashopps.com!!...</p>
                        </div>-->
                    </div>
                        <!-- Block CMS module footer -->
                    <div class="footer-block col-xs-12 col-sm-3 col-md-2">
                        <h4>Categories</h4>
                        <ul class="toggle-footer">
                            <li class="item-footer">
                                <a href="<?=newUrl('mobile/mobiles')?>" title="Smartphone">Smartphone</a>
                            </li>
                            <li class="item-footer">
                                <a href="<?=newUrl('computers/laptops')?>" title="Touch Mobiles">Touch Mobiles</a>
                            </li>
                            <li class="item-footer">                               
                                <a href="<?=newUrl('/blog')?>" title="Qwerty Mobiles">Qwerty Mobiles</a>
                            </li>
							<li class="item-footer">                               
                                <a href="<?=newUrl('/blog')?>" title="Slim Mobiles">Slim Mobiles</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('/blog')?>" title="Flip Mobiles">Flip Mobiles</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('/blog')?>" title="Dual Sim Mobiles">Dual Sim Mobiles</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('/blog')?>" title="3G Mobiles">3G Mobiles</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('/blog')?>" title="Bluetooth Mobile">Bluetooth Mobiles</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('/blog')?>" title="Wifi Mobile">Wifi Mobiles</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('/blog')?>" title="Android Phones">Android Phones</a>
                            </li>							
							<li class="item-footer">                               
                                <a href="<?=newUrl('/blog')?>" title="Windows Phones">Windows Phones</a>
                            </li>
                        </ul>                            

                    </div>
                    <div class="footer-block col-xs-12 col-sm-3 col-md-2">
                        <h4>About</h4>
							<ul class="toggle-footer">
                                <li class="item-footer">
                                    <a href="<?=newUrl('about-us')?>" title="About us">About us</a>
                                </li>
                                <li class="item-footer">
                                    <a href="<?=newUrl('career')?>" title="Career">Career</a>
                                </li>
                                <li class="item-footer">
                                    <a href="<?=newUrl('contact-us')?>" title="Contact us">Contact us</a>
                                </li>
                                <li class="item-footer">
                                    <a href="<?=newUrl('contact-us')?>" title="Contact us">Help</a>
                                </li>
                                <li class="item-footer">
                                    <a href="<?=newUrl('contact-us')?>" title="Contact us">Find a Mobile</a>
                                </li>
                                <li class="item-footer">
                                    <a href="<?=newUrl('contact-us')?>" title="Contact us">Mobile Site</a>
                                </li>
                                <li class="item-footer">
                                    <a href="<?=newUrl('contact-us')?>" title="Contact us">Blog</a>
                                </li>
                            </ul>
                    </div>
                        <!-- Block myaccount module -->
                    <div class="footer-block col-xs-12 col-sm-5 col-md-4 myaccount_container">
                        <h4>Most Compared Phones</h4>
                            <ul class="toggle-footer">
                                <li class="item-footer">
									<a href="<?=newUrl('compare-mobiles/apple-iphone-6-1/apple-iphone-6-plus-53')?>" title=" Compare Iphone 6 Online"  target="_blank"><img src="<?=asset("/images/v1/mobile_img.png")?>" alt="Compare Iphone 6 Online">iPhone 6 Vs iPhone 6 Plus</a>
                                </li>
                                <li class="item-footer">
									<a href="<?=newUrl('compare-mobiles/lenovo-k3-note-3/lenovo-a7000-15')?>" title="Compare Lenovo K3 Note Lenovo A7000 Online" target="_blank"><img src="<?=asset("/images/v1/mobile_img.png")?>" alt="Compare Lenovo K3 Note Lenovo A7000 Online">Lenovo K3 Note Vs Lenovo A7000</a>
                                </li>
                                <li class="item-footer">
                                    <a href="<?=newUrl('most-compared-mobiles.html')?>" title="Most Compared Mobile Phones"  target="_blank" ><img src="<?=asset("/images/v1/mobile_img.png")?>" alt="Compare Xiaomi Redmi Note 4G YU Yureka Plus Online">Most Compared Mobile Phones</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /Block myaccount module -->
                        <div class="col-xs-12 col-sm-5 col-md-2" style="margin-top:20px;">
                            <!-- Block Newsletter module -->
                            <!--<div id="newsletter_block_left" class="footer-block"></div>
                               
                                <div class="block_content toggle-footer">
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <input class="inputNew form-control grey newsletter-input" id="newsletter-input" type="text" name="email" size="18" value="Enter your e-mail" />
                                            <button type="submit" name="submitNewsletter" class="btn btn-default button button-small">
                                                <span>Ok</span>
                                            </button>
                                            <input type="hidden" name="action" value="0" />
                                        </div>
                                    </form>
                                </div>-->

                            
                            <!-- /Block Newsletter module-->

							<h4>Keep in touch</h4>
								<div id="social_block">
									<a class="facebook" href="https://www.facebook.com/indiashopps?ref=hl" target="_blank" >
										<i class="fa fa-facebook"></i>
									</a>
									<a class="twitter" href="https://twitter.com/IndiaShopps" target="_blank" >
										<i class="fa fa-twitter"></i>
									</a>
									<a class="google" href="https://plus.google.com/+Indiashopps/" target="_blank" >
										<i class="fa fa-google-plus"></i>
									</a>
								</div>
						</div>
                </div>
            </div>
        </div>
            <div class="footer_bottom">
                <div class="container">
                    <div class="copyright">
                        <p>COPYRIGHT © <?=date('Y')?> <a href="#"></a>Indiashopps.com - All Rights Reserved. </p>
                    </div>
                    <div class="sitemap" style="float:right; margin-top:10px;">
                        <p><a href='/sitemap.xml' style="color: #fff;" target="_blank">Sitemap</a></p>
                    </div>
                </div>
            </div>
    </footer>
</div>
<!-- #footer -->
<div class="back-top">
    <a href="#" class="back-top-button"></a>
</div>
<div id="compare-now" class="compare-holder" style="display: none;">
   <a href="javascript:void(0)" id="compare-text">Compare Now (0)</a>
</div>
<div class="sideMenu">
   <div class="padding">
      <div class="col-md-12 col-sm-12 no-margin">
         <div class="col-md-10 col-sm-10">
            <h2 class="compare-heading">Here is your compare list</h2>
         </div>
         <div class="col-md-2 col-sm-2">
            <p><a href="#" class="closeTrigger">
            <i class="fa fa-times btn-sm"></i>
            </a></p>
         </div>
      </div>
      <div class="col-md-12 col-sm-12">
         <div id="compare-product-list"></div>
         <div id="compare-button"></div>
      </div>
   </div>
</div>
<div id="extension-install">
    <div class="navbar-fixed-bottom" id="chrome-ext" style="display: none">         
        <div class="extension_bg  alert-dismissable">
            <div class="container" style="padding-left: 10%">
                <img src="<?=asset('images/v1/chrome_icon.png')?>" alt="" class="img-responsive extension_icon" />
                <p class="extension_heading">Add Our Chrome Extension & Get Rs.1000 Discount Vouchers on Sign UP.</p>
                <a onclick="INDSHP1.EXT.chromeExtInstall()">
                    <img src="<?=asset('images/v1/chrome_button.png')?>" />
                </a>
                <!--<i class="fa fa-firefox"></i>-->
                <button type="button" class="close extension-close" style="color:#fff;">×</button>
            </div>
        </div>
    </div>
    <div class="navbar-fixed-bottom" id="firefox-ext" style="display: none">         
        <div class="extension_bg  alert-dismissable">
            <div class="container" style="padding-left: 10%">
                <img src="<?=asset('images/v1/firefox_icon.png')?>" alt="" class="img-responsive extension_icon" />
                <p class="extension_heading">Add Our Firefox Add-on & Get Rs.1000 Discount Vouchers on Sign UP.</p>
                <a onclick="INDSHP1.EXT.firefoxExtInstall()">
                    <img src="<?=asset('images/v1/firefox_button.png')?>" />
                </a>
                <button type="button" class="close extension-close" style="color:#fff;">×</button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<style type="text/css">
    a:hover{ cursor: pointer; }
    @media (max-width: 600px) {
        #searchbox .xdsoft_autocomplete {
            width: 90% !important;
        }

        #searchbox .xdsoft_autocomplete_hint {
            width: 100% !important;
        }
    }
</style>
</body>

<link rel="stylesheet" href="<?=asset("/css/v1/animate.css")?>" type="text/css" />
<link rel="stylesheet" href="<?=asset("/css/v1/addition.css")?>" type="text/css" />
<link rel="stylesheet" href="<?=asset("/css/v1/compare.css")?>" type="text/css" />
<link rel="stylesheet" href="<?=asset("/css/v1/font-awesome.min.css")?>" type="text/css" />
<link rel="stylesheet" href="<?=asset("/css/v1/jquery.autocomplete.css")?>" type="text/css" />
<!-- ********* SCRIPTS **************** --> 
<script type="text/javascript" src="<?=asset("/js/v1/demo.js")?>"></script>
<script type="text/javascript" src="<?=asset("/js/v1/jquery.min.js")?>"></script>
<script type="text/javascript" src="<?=asset("/js/v1/bootstrap.min.js")?>"></script>
<script type="text/javascript" src="<?=asset("/js/v1/v_7_cf743db1f417650581eef7f7e48238e4.js")?>"></script>
<script src="<?=asset("/js/v1/owl.carousel.min.js")?>"></script>
<script type="text/javascript" src="<?=asset("/js/v1/main.js")?>"></script>
<script type="text/javascript" src="<?=asset("/js/v1/jquery.autocomplete.js")?>"></script>
   <script type="text/javascript" src="<?=newUrl('js/v1/compare.js')?>"></script>

<script type="text/javascript">
    categories = [];
    
    $(document).ready(function(){
        $('.selectpicker').selectpicker();
        $.getJSON( "<?=newUrl('livesearch')?>", function( data ) {
            var categories = $.map(data, function(el) { return el });

            $(".main_search").autocomplete({
                source:[categories],
                visibleLimit: 10,
                minLength : 2,
                valueKey : 'title',
                titleKey : 'title',
                // preparse: function(items){console.log(items)},
            });
        })
        CONTENT.uri = "<?=newUrl("ajaxContent")?>";
        CONTENT.f(false).load("pt_vmegamenu",false,function(){

            $("#pt_vmegamenu").hide();
            $("#pt_menu_link ul li").each(function() {
                var url = document.URL;
                $("#pt_menu_link ul li a").removeClass("act");
                $('#pt_menu_link ul li a[href="' + url + '"]').addClass('act');
            });
            $('.pt_menu_no_child').hover(function() {
                $(this).addClass("active");
            }, function() {
                $(this).removeClass("active");
            })
            $('.pt_menu').hover(function() {
                if ($(this).attr("id") != "pt_menu_link") {
                    $(this).addClass("active");
                }
            }, function() {
                $(this).removeClass("active");
            })
            $('.pt_menu').hover(function() {
                $(this).find('.popup').css('display', 'inline-block');
                var extraWidth = 0
                var wrapWidthPopup = $(this).find('.popup').outerWidth(true);
                var actualWidthPopup = $(this).find('.popup').width();
                extraWidth = wrapWidthPopup - actualWidthPopup;
                var widthblock1 = $(this).find('.popup .block1').outerWidth(true);
                var widthblock2 = $(this).find('.popup .block2').outerWidth(true);
                var new_width_popup = 0;
                if (widthblock1 && !widthblock2) {
                    new_width_popup = widthblock1;
                }
                if (!widthblock1 && widthblock2) {
                    new_width_popup = widthblock2;
                }
                if (widthblock1 && widthblock2) {
                    if (widthblock1 >= widthblock2) {
                        new_width_popup = widthblock1;
                    }
                    if (widthblock1 < widthblock2) {
                        new_width_popup = widthblock2;
                    }
                }
                var new_outer_width_popup = new_width_popup + extraWidth;
                var wraper = $('.pt_custommenu');
                var wWraper = wraper.outerWidth();
                var posWraper = wraper.offset();
                var pos = $(this).offset();
                var xTop = pos.top - posWraper.top + CUSTOMMENU_POPUP_TOP_OFFSET;
                var xLeft = pos.left - posWraper.left;
                if ((xLeft + new_outer_width_popup) > wWraper) xLeft = wWraper - new_outer_width_popup;
                $(this).find('.popup').css('top', xTop);
                $(this).find('.popup').css('left', xLeft);
                $(this).find('.popup').css('width', new_width_popup);
                $(this).find('.popup .block1').css('width', new_width_popup);
                $(this).find('.popup').css('display', 'none');
                if (CUSTOMMENU_POPUP_EFFECT == 0) $(this).find('.popup').stop(true, true).slideDown('fast');
                if (CUSTOMMENU_POPUP_EFFECT == 1) $(this).find('.popup').stop(true, true).fadeIn('fast');
                if (CUSTOMMENU_POPUP_EFFECT == 2) $(this).find('.popup').stop(true, true).show('fast');
            }, function() {
                if (CUSTOMMENU_POPUP_EFFECT == 0) $(this).find('.popup').stop(true, true).slideUp('fast');
                if (CUSTOMMENU_POPUP_EFFECT == 1) $(this).find('.popup').stop(true, true).fadeOut('fast');
                if (CUSTOMMENU_POPUP_EFFECT == 2) $(this).find('.popup').stop(true, true).hide('fast');
            })
            $(".popup").hover(function() {
                $(this).show();
            }, function() {
                $(this).hide();
            });
        });
         
    }); 
	 (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-69454797-1', 'auto');
  ga('send', 'pageview');

</script>
</html>