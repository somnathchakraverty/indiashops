/*==========================header===================*/
	$(function(){
	$("header").before($(".StickyHeader").clone().addClass("fixed"));
	var sidebar_top = 0;
	$(window).scroll(function(){
		var scrolled = $(window).scrollTop();
        var window_half = $("#wrapper1").height();
        var right_div = $("#right-container").height();
        
		if($(window).scrollTop() >= 150 && $(window).width() >= 768 ){
            
			$('.StickyHeader.fixed').addClass('slideDown');
			if( ( scrolled + window_half ) >= right_div )
			{
				$('#sidebar-wrapper').removeClass('sticky');
				$('#sidebar-wrapper').addClass('smooth');
                if( sidebar_top == 0 )
                    sidebar_top = scrolled;

                var scrolling = scrolled - sidebar_top;
                $('#sidebar-wrapper').parent().attr( "style","top:-"+scrolling+"px" );
			}
			else
			{
				$('#sidebar-wrapper').addClass('sticky');
				$('#sidebar-wrapper').removeClass('smooth');
                sidebar_top = 0;
                $('#sidebar-wrapper').parent().removeAttr("style");
			}
		}
	else{
		$('.StickyHeader.fixed').removeClass('slideDown');
		$('#sidebar-wrapper').removeClass('sticky');
        $('#sidebar-wrapper').parent().removeAttr("style");
	}

    var stick_div = $(".stick");
    var win_half = $("#right-container").height() - 70;

    if( $(window).scrollTop() >= 150 )
    {
        if( ( scrolled + stick_div.height() ) >= win_half )
        {
            if( sidebar_top == 0 )
                sidebar_top = scrolled;

            var scrolling = scrolled - sidebar_top;
            stick_div.parent().attr( "style","top:-"+scrolling+"px" );

            stick_div.parent().removeClass("sticky-div");
        }
        {
            stick_div.parent().addClass("sticky-div");
        }
    }
    else
    {
        stick_div.parent().removeClass("sticky-div");
    }
    
	});
});

/*==========================Category===================*/
                        //<![CDATA[
                        var VMEGAMENU_POPUP_EFFECT = 2;
                        //]]>

                        $(document).ready(function() { 
							$("#pt_vmegamenu").hide();
                            $("#pt_ver_menu_link ul li").each(function() {
                                var url = document.URL;
                                $("#pt_ver_menu_link ul li a").removeClass("act");
                                $('#pt_ver_menu_link ul li a[href="' + url + '"]').addClass('act');
                            });
							
							$(".pt_vmegamenu_title").hover(function(){
								$("#pt_vmegamenu").stop( true, true ).slideDown();
							});
							
							$(".pt_vegamenu").mouseleave(function(){
								$("#pt_vmegamenu").stop( true, true ).fadeOut();
							});
							
                            $('.pt_menu.active').hover(function() {
                                if (VMEGAMENU_POPUP_EFFECT == 0) $(this).find('.popup').stop(true, true).slideDown('fast');
                                if (VMEGAMENU_POPUP_EFFECT == 1) $(this).find('.popup').stop(true, true).fadeIn('fast');
                                if (VMEGAMENU_POPUP_EFFECT == 2) $(this).find('.popup').stop(true, true).show('fast');
                            }, function() {
                                if (VMEGAMENU_POPUP_EFFECT == 0) $(this).find('.popup').stop(true, true).slideUp('fast');
                                if (VMEGAMENU_POPUP_EFFECT == 1) $(this).find('.popup').stop(true, true).fadeOut('fast');
                                if (VMEGAMENU_POPUP_EFFECT == 2) $(this).find('.popup').stop(true, true).hide('fast');
                            });
                        });


                        //<![CDATA[
                        var CUSTOMMENU_POPUP_EFFECT = 0;
                        var CUSTOMMENU_POPUP_TOP_OFFSET = 46;
                        //]]>					
/*==========================Slider======================*/
                            $(window).load(function() {
                                $('#pos-slideshow-home').nivoSlider({
                                    effect: 'random',
                                    slices: 15,
                                    boxCols: 8,
                                    boxRows: 4,
                                    animSpeed: '600',
                                    pauseTime: '6000',
                                    startSlide: 0,
                                    directionNav: 1,
                                    controlNav: false,
                                    controlNavThumbs: false,
                                    pauseOnHover: true,
                                    manualAdvance: false,
                                    prevText: '<i class="glyphicon glyphicon-menu-left"></i>',
                                    nextText: '<i class="glyphicon glyphicon-menu-right"></i>',
                                });
                            });
/*==========================Latest Products======================*/
                        $(document).ready(function() {
                            var featuredSlide = $(".featuredSlide");
                            featuredSlide.owlCarousel({
                                items: 4,
                                itemsDesktop: [1199, 4],
                                itemsDesktopSmall: [991, 3],
                                itemsTablet: [767, 2],
                                itemsMobile: [480, 1],
                                autoPlay: false,
                                stopOnHover: false,
                                addClassActive: true,
                            });

                            // Custom Navigation Events
                            $(".pos_featured_product .nexttab").click(function() {
                                featuredSlide.trigger('owl.next');
                            });
                            $(".pos_featured_product .prevtab").click(function() {
                                featuredSlide.trigger('owl.prev');
                            });
                        });
/*==========================Hot Deals======================*/		
                        // $(document).ready(function() {
                        //     var hotdeals = $(".hotdeals");
                        //     hotdeals.owlCarousel({
                        //         items: 4,
                        //         itemsDesktop: [1199, 4],
                        //         itemsDesktopSmall: [991, 3],
                        //         itemsTablet: [767, 2],
                        //         itemsMobile: [480, 1],
                        //         autoPlay: false,
                        //         stopOnHover: false,
                        //         addClassActive: true,
                        //     });

                        //     // Custom Navigation Events
                        //     $(".hot_deals_product .nexttab").click(function() {
                        //         hotdeals.trigger('owl.next');
                        //     })
                        //     $(".hot_deals_product .prevtab").click(function() {
                        //         hotdeals.trigger('owl.prev');
                        //     })
                        // });		
						
/*==========================Top Brand;======================*/
/*-------------mobile-------------*/
                                    $(document).ready(function() {
                                        var postabcateslider1 = $("#tab1_0_in");
                                        postabcateslider1.owlCarousel({
                                            items: 5,
                                            itemsDesktop: [1199, 4],
                                            itemsDesktopSmall: [991, 3],
                                            itemsTablet: [767, 2],
                                            itemsMobile: [480, 1],
                                            autoPlay: false,
                                            stopOnHover: false,
                                            addClassActive: true,
                                        });
                                        $(".postabcateslider.postabcateslider1 #navi1_0 .nexttab").click(function() {
                                            postabcateslider1.trigger('owl.next');
                                        });
                                        $(".postabcateslider.postabcateslider1 #navi1_0 .prevtab").click(function() {
                                            postabcateslider1.trigger('owl.prev');
                                        });
                                    });
/*-------------Electronics-------------*/			
                                    $(document).ready(function() {
                                        var postabcateslider1 = $("#tab1_1_in");
                                        postabcateslider1.owlCarousel({
                                            items: 5,
                                            itemsDesktop: [1199, 4],
                                            itemsDesktopSmall: [991, 3],
                                            itemsTablet: [767, 2],
                                            itemsMobile: [480, 1],
                                            autoPlay: false,
                                            stopOnHover: false,
                                            addClassActive: true,
                                        });
                                        $(".postabcateslider.postabcateslider1 #navi1_1 .nexttab").click(function() {
                                            postabcateslider1.trigger('owl.next');
                                        });
                                        $(".postabcateslider.postabcateslider1 #navi1_1 .prevtab").click(function() {
                                            postabcateslider1.trigger('owl.prev');
                                        });
                                    });
/*-------------Dresses -------------*/	
                                    $(document).ready(function() {
                                        var postabcateslider1 = $("#tab1_2_in");
                                        postabcateslider1.owlCarousel({
                                            items: 5,
                                            itemsDesktop: [1199, 4],
                                            itemsDesktopSmall: [991, 3],
                                            itemsTablet: [767, 2],
                                            itemsMobile: [480, 1],
                                            autoPlay: false,
                                            stopOnHover: false,
                                            addClassActive: true,
                                        });
                                        $(".postabcateslider.postabcateslider1 #navi1_2 .nexttab").click(function() {
                                            postabcateslider1.trigger('owl.next');
                                        });
                                        $(".postabcateslider.postabcateslider1 #navi1_2 .prevtab").click(function() {
                                            postabcateslider1.trigger('owl.prev');
                                        });
                                    });
/*-------------Home & Furniture  -------------*/
                                    $(document).ready(function() {
                                        var postabcateslider1 = $("#tab1_3_in");
                                        postabcateslider1.owlCarousel({
                                            items: 5,
                                            itemsDesktop: [1199, 4],
                                            itemsDesktopSmall: [991, 3],
                                            itemsTablet: [767, 2],
                                            itemsMobile: [480, 1],
                                            autoPlay: false,
                                            stopOnHover: false,
                                            addClassActive: true,
                                        });
                                        $(".postabcateslider.postabcateslider1 #navi1_3 .nexttab").click(function() {
                                            postabcateslider1.trigger('owl.next');
                                        });
                                        $(".postabcateslider.postabcateslider1 #navi1_3 .prevtab").click(function() {
                                            postabcateslider1.trigger('owl.prev');
                                        });
                                    });
/*-------------tabs -------------*/		
                        $(document).ready(function() {
                            $(".postabcateslider.postabcateslider1 .navi").hide();
                            $(".postabcateslider.postabcateslider1 .tab_content").hide();
                            $(".postabcateslider.postabcateslider1 #navi1_0").show();
                            $(".postabcateslider.postabcateslider1 .tab_content:first").show();
                            $(".postabcateslider.postabcateslider1 ul.tabs1 li").click(function() {
                                $(".postabcateslider.postabcateslider1 ul.tabs1 li").removeClass("active");
                                $(this).addClass("active");
                                $(".postabcateslider.postabcateslider1 .tab_content").hide();
                                $(".postabcateslider.postabcateslider1 .navi").hide();
                                var activeTab1 = $(this).attr("rel");
                                var activeTab11 = $(this).attr("data-navi");
                                console.log(activeTab1);
                                $("#" + activeTab1).fadeIn();
                                $("#" + activeTab11).fadeIn();
                            });
                        });
/*----------------------new Products----------------------*/	
                        // $(document).ready(function() {
                        //     var newSlide = $(".newSlide");
                        //     newSlide.owlCarousel({
                        //         items: 4,
                        //         itemsDesktop: [1199, 3],
                        //         itemsDesktopSmall: [991, 2],
                        //         itemsTablet: [767, 2],
                        //         itemsMobile: [480, 1],
                        //         autoPlay: false,
                        //         stopOnHover: false,
                        //         addClassActive: true,
                        //     });

                        //     // Custom Navigation Events
                        //     $(".pos_new_product .nexttab").click(function() {
                        //         newSlide.trigger('owl.next');
                        //     })
                        //     $(".pos_new_product .prevtab").click(function() {
                        //         newSlide.trigger('owl.prev');
                        //     })
                        // });  
/*----------------------Recently Viewed----------------------*/		
                        //$(document).ready(function() {
                            // var recently = $(".recently");
                            // recently.owlCarousel({
                            //     items: 4,
                            //     itemsDesktop: [1199, 4],
                            //     itemsDesktopSmall: [991, 3],
                            //     itemsTablet: [767, 2],
                            //     itemsMobile: [480, 1],
                            //     autoPlay: false,
                            //     stopOnHover: false,
                            //     addClassActive: true,
                            // });

                            // // Custom Navigation Events
                            // $(".pos_recently .nexttab").click(function() {
                            //     recently.trigger('owl.next');
                            // })
                            // $(".pos_recently .prevtab").click(function() {
                            //     recently.trigger('owl.prev');
                            // })
                      //  });
						
						
						
						
						/*<script>
                        $(document).ready(function() {
                            var recently = $(".recently");
                            recently.owlCarousel({
                                items: 4,
                                itemsDesktop: [1199, 4],
                                itemsDesktopSmall: [991, 3],
                                itemsTablet: [767, 2],
                                itemsMobile: [480, 1],
                                autoPlay: false,
                                stopOnHover: false,
                                addClassActive: true,
                            });

                            // Custom Navigation Events
                            $(".pos_recently .nexttab").click(function() {
                                recently.trigger('owl.next');
                            })
                            $(".pos_recently .prevtab").click(function() {
                                recently.trigger('owl.prev');
                            })
                        });
                    </script>*/
/*----------------------Product left fixed category----------------------*/	
(function($){
$(document).ready(function(){

$('#product-left-fixed-menu li.active').addClass('open').children('ul').show();
    $('#product-left-fixed-menu li.has-sub>a').on('click', function(){
        $(this).removeAttr('href');
        var element = $(this).parent('li');
        if (element.hasClass('open')) {
            element.removeClass('open');
            element.find('li').removeClass('open');
            element.find('ul').slideUp(200);
        }
        else {
            element.addClass('open');
            element.children('ul').slideDown(200);
            element.siblings('li').children('ul').slideUp(200);
            element.siblings('li').removeClass('open');
            element.siblings('li').find('li').removeClass('open');
            element.siblings('li').find('ul').slideUp(200);
        }
    });

});
})(jQuery);
/*----------------------Product details----------------------*/	
    $(document).ready(function() {
     
      var sync1 = $("#sync1");
      var sync2 = $("#sync2");
     
      sync1.owlCarousel({
        singleItem : true,
        slideSpeed : 1000,
        //navigation: true,
        pagination:false,
        afterAction : syncPosition,
        responsiveRefreshRate : 200
      });
     
      sync2.owlCarousel({
        items : 4,
        itemsDesktop      : [1199,4],
        itemsDesktopSmall : [979,4],
        itemsTablet       : [768,4],
        itemsMobile       : [479,4],
        pagination:false,
		autoWidth : true,
        responsiveRefreshRate : 100,
        afterInit : function(el){
          el.find(".owl-item").eq(0).addClass("synced");
        }
      });
     
      function syncPosition(el){
        var current = this.currentItem;
        $("#sync2")
          .find(".owl-item")
          .removeClass("synced")
          .eq(current)
          .addClass("synced");
        if($("#sync2").data("owlCarousel") !== undefined){
          center(current);
        }
      }
     
      $("#sync2").on("click", ".owl-item", function(e){
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo",number);
      });
     
      function center(number){
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for(var i in sync2visible){
          if(num === sync2visible[i]){
            var found = true;
          }
        }
     
        if(found===false){
          if(num>sync2visible[sync2visible.length-1]){
            sync2.trigger("owl.goTo", num - sync2visible.length+2);
          }else{
            if(num - 1 === -1){
              num = 0;
            }
            sync2.trigger("owl.goTo", num);
          }
        } else if(num === sync2visible[sync2visible.length-1]){
          sync2.trigger("owl.goTo", sync2visible[1]);
        } else if(num === sync2visible[0]){
          sync2.trigger("owl.goTo", num-1);
        }
        
      }
     
    });
/*----------------------more & less----------------------*/	
$(document).ready(function() {
    var showChar = 200;
    var ellipsestext = "...";
    var moretext = "more";
    var lesstext = "less";
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar-1, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});

$(function(){

	$('#slide-submenu').on('click',function() {		$('.filter-main').css('height','40px');
        $(this).closest('.list-group').fadeOut('slide',function(){
        	$('.mini-submenu').fadeIn();	
        });        
      });

	$('.mini-submenu').on('click',function(){	
        $(this).next('.list-group').toggle('slide');
		$('.filter-main').css('height','100%' );
        $('.mini-submenu').hide();
		
	});
});

/*----------------------Set Price Alert popup----------------------*/
$(document).ready(function(){

    if( window.location.href.indexOf('/compare-mobiles/') > 0 )
    {
        $(".remove-product").remove();
        $("#compare-now").remove();
    }
	$('button[data-dismiss="modal"]').click(function(){
		$("#myModal").hide();
		$(".modal-backdrop").remove();
	});

    /*----------------------Smooth Scroll when clicked on a link which has ID in HREF----------------------*/
    $("a.ssmooth").click(function(){
        var height = $("#sticky-header").height() + 20;

        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top - height
        }, 800);

        return false;
    });

    $("a.compare").click(function(){
        var height = $("#sticky-header").height() + 160 ;

        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top - height
        }, 800);

        return false;
    });

    $("a[rel='ligthbox']").fancybox();

    $("#pos-slideshow-home img").click(function(){

        var url = $(this).attr('url');

        if( typeof url !== "undefined" && url.length > 0 )
        {
            window.open(url);
        }
    });

    $("body, .dropdown-toggle").click(function(event){

        if( event.target.type != "button" && event.target.className.split(" ")[0] != "filter-option" )
        {
            $(".dropdown-menu").hide().removeClass('opened');
            $(".dropdown-toggle").removeClass("opened");
        }

        if( $(event.target).hasClass('dropdown-toggle') )
        {
            if( $(event.target).hasClass( 'opened' ) )
            {
                $(event.target).parent().find(".dropdown-menu").hide();
                $(event.target).removeClass("opened");
            }
            else
            {
                $(event.target).parent().find(".dropdown-menu").show();
                $(event.target).addClass("opened");
            }
        }
    });

    $(".dropdown-menu li a").click(function(event){
        
        $(this).closest('.dropdown-menu').hide();
        $(".dropdown-toggle").removeClass("opened");
    });

    $("a.get-code").click(function(){
        window.location.href = $(this).attr("out-url");
    });

    var showChar = 100;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more";
    var lesstext = "Show less";

    $('.moredata').each(function() {

        var content = $(this).html();
 
        if( content.length > showChar ) {
 
            var c       = content.substr(0, showChar);
            var h       = content.substr(showChar, content.length - showChar);
            var html    = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelnk">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
    });

    /*Create Show More link on product detail page, once product description is long.*/
    $(".morelnk").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });

    $(".show-toggle").click(function(){
        if( $(this).hasClass("show-more") )
        {
            $(this).fadeOut('fast',function(){
                $(".show-less").fadeIn();
            });
            if( $('.comment.more-data').hasClass('slide') )
                $('.comment.more-data').animate({'height':'250'},500).removeClass('closed');
            else
                $('.comment.more-data').css({'overflow':'auto'});
        }
        else if( $(this).hasClass("show-less") )
        {
            $(this).fadeOut('fast',function(){
                $(".show-more").fadeIn();
            });

            if( $('.comment.more-data').hasClass('slide') )
            {
                height = $('.comment.more-data').attr('data-height');
                $('.comment.more-data').animate({'height': height},500).addClass('closed');
            }
            else
            {
                $('.comment.more-data').css({'overflow':'hidden'});
                $('.comment.more-data').scrollTo(0);
            }
        }

        return false;
    });

    $(".my-account").mouseenter(function(){
        el = $(this).find(".submenu");
        el.finish();
        el.fadeIn('show');
    });

    $(".my-account").mouseleave(function(){
        el = $(this).find(".submenu");
        el.finish();
        el.fadeOut('show');
    });

    check_images();
});

/*===================================================================================*/
/*  DETECTS MOBILE DEVICE, AND SENDS ALERT TO DOWNLOAD APP..
/*===================================================================================*/
$(document).ready(function(){

    var is_mobile = window.mobilecheck();

    //if( is_mobile === true )
    if( false )
    {
        navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
        var notify = getCookie( "app-notify" );

        if (navigator.vibrate && notify != "no" )
        {
            // vibration API supported

            var modal  = '<button type="button" class="btn" data-toggle="modal" data-target="#myModal" style="display:none" id="download-app">Open Modal</button>';
                modal += '<div id="myModal" class="modal" role="dialog">';
                modal += '<div class="modal-dialog">';
                modal += '<div class="modal-content app-popup-window">';
                modal += '<div class="modal-header modal-header-popup">';
                modal += '<button type="button" class="close app-popup-window-close" data-dismiss="modal" style="border: 1px solid;">&times;</button>';
                modal += '<h4 class="modal-title">Download IndiaShopps Mobile App.</h4>';
                modal += '</div>';
                modal += '<div class="modal-body">';
                modal += '<p class="modal-title">Get Best Deals & Offers On Mobile App</p>';
                modal += '<p class="col-xs-offset-3"><a target="_blank" href="https://play.google.com/store/apps/details?id=com.indiashopps.android&amp;referrer=source%3DMobile"><img src="http://dev.indiashopps.com/images/app-download-img.png" alt="logo" class="app-popup-window-img"></a></p>';
                modal += '<p class="modal-title1 text-center">Compare Before You Buy</p>';
                modal += '</div>';
                modal += '<div class="modal-footer">';
                modal += '<button type="button" class="btn btn-default modal-footer-button pull-left" data-dismiss="modal" onclick="window.open(\'https://play.google.com/store/apps/details?id=com.indiashopps.android&referrer=source%3DSite\')">Install Now</button>';
                modal += '<button type="button" class="btn btn-default modal-footer-button-later" data-dismiss="modal">Later</button>';
                modal += '</div>';
                modal += '</div>';
                modal += '</div></div><style>#myModal .modal-content{ margin-top:20%; }</style>';

            $('body').append( modal );
            $('#myModal').modal({
                backdrop: 'static',
                keyboard: false
            });

            $("#download-app").trigger("click");

            navigator.vibrate(1000);
            setCookie("app-notify", "no", 1 );
        }
    }

    $('a.scroll-to').click(function(){
        $('html, body').animate({scrollTop:$($.attr(this,'href')).offset().top},800);
        return false;
    });

    INDSHP1.EXT.check_extension();
});

window.mobilecheck = function(){
    // var check = false;

    var ua = navigator.userAgent.toLowerCase();
    var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");

    if(isAndroid)
    {
      // Do something!
      return true;
    }
    else
    {
        return false;
    }
    // (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
    // return check;
};

$(document).ajaxStop(function(){
    setTimeout(function(){ check_images() }, 1000);
});

function check_images()
{
    $("img[src='']").each(function(){
        imgError(this);
    });
}

function imgError(image) {
    image.onerror = "";
    image.src = "http://www.indiashopps.com/images/v1/imgNoImg.png";
    return true;
}

/*----------------------GET & SET COOKIE----------------------*/
function setCookie(cname, cvalue, exdays)
{
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires+";path=/;";
}

function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}

/*----------------------coupon details----------------------*/
$(function () {

    $('.toggle').click(function (event) {
        event.preventDefault();
        var target = $(this).attr('href');
        $(target).toggleClass('hidden show');
    });

});
/*----------------------coupon details end----------------------*/

/*----------------------Firefox & Chrome extension install script start----------------------*/
ua = navigator.userAgent.toLowerCase();

var INDSHP1 = {

    "EXT" :
    {
        firefoxExtInstall : function()
        {
            var params = {
                "IndiaShopps": {
                    URL: "http://www.indiashopps.com/ext/addon/indiashopps-2.1.0-fx.xpi",
                    IconURL: "http://www.indiashopps.com/ext/addon/icon64.png",
                    toString: function () {
                        return this.URL;
                    }
                }
            };

            InstallTrigger.install(params);
            $(".navbar-fixed-bottom").removeClass("open");
            INDSHP1.EXT.footerMargin('0px');
        },
        chromeExtInstall  : function()
        {
            if (!chrome.app.isInstalled) {
                chrome.webstore.install('https://chrome.google.com/webstore/detail/pgoackgjjkpbkjoomkklkofbhpkbeboc',
                    this.chromeSuccess, this.chromeFail );
            }
        },
        check_extension : function()
        {
            var notify      = getCookie("indshpHideExtSlideUp");
            var $chrome     = $("#chrome-ext");
            var $firefox    = $("#firefox-ext");

            if( notify.length == 0 )
            {
                if( this.isChrome() )
                {
                    this.detectExt( function(){ $chrome.show().addClass('open'); } );
                }
                else if( this.isFirefox() )
                {
                    this.detectExt( function(){ $firefox.show().addClass('open'); } );
                }
            }

            $(document).on('click','.extension-close',function(){
                INDSHP1.EXT.hideBottomBar();
                setCookie( "indshpHideExtSlideUp","yes", 1 );
            });
        },
        detectExt       : function( callback )
        { 
            setTimeout( function(){

                var indshp_ext = $('#dz-frame');
                
                if( indshp_ext.length == 0 )
                {
                    INDSHP1.EXT.footerMargin('50px');
                    callback();
                }

            },5000 );
        },
        hideBottomBar     : function()
        {
            $(".navbar-fixed-bottom").removeClass("open");
            INDSHP1.EXT.footerMargin('0px');
        },
        chromeSuccess     : function()
        {
            INDSHP1.EXT.hideBottomBar();
        },
        chromeFail     : function()
        {
            INDSHP1.EXT.hideBottomBar();
        },
        isChrome : function ()
        {
            var mobile = window.mobilecheck();
            return ua.indexOf("chrome") !== -1 && ua.indexOf("edge") === -1 && ua.indexOf("opr") === -1 && !mobile; // Edge UA contains "Chrome"
        },
        isFirefox : function ()
        {
            var mobile = window.mobilecheck();
            return ua.indexOf("firefox") !== -1 && !mobile;
        },
        footerMargin    : function( $px )
        {
            $("#footer").css('margin-bottom', $px );
        }
    }
};

/*----------------------Firefox & Chrome extension install script start----------------------*/

/*----------------------AJAX CONTENT ON HOME PAGE START----------------------*/
var CONTENT = {
    "uri" : '',
    "force" : false,
    "owl"   : true,
    f : function(force){
        this.force = force;
        return this;
    },
    load : function( section, owl, callback )
    {
        this.get(section,owl,callback);
    },
    append : function( content, section )
    {
        if( content.length > 0 )
        {
            $( "#"+section ).html( content ).hide().fadeIn("slow");
        }
        else
        {
            $( "#"+section ).html('').closest('.block_product').hide();
        }
    },
    get : function( section, owl, callback )
    {
        url = this.uri+"/"+section;
        that = this;

        if( content = this.hasLocal(section) )
        {
            if( section == "all" )
            {
                content =  $.parseJSON(content);
                $.each( content, function( sec, cont ){
                    
                    that.append(cont,sec);
                    if(owl)
                    {
                        setTimeout(function(){
                            that.refresh(sec);
                        },500);
                    }

                    if( typeof(callback) == "function" )
                    {
                        callback();
                    }
                });
            }
            else
            {
                that.append(content,section);

                if(owl)
                {
                    setTimeout(function(){
                        that.refresh(section);
                    },500);
                }

                if( typeof(callback) == "function" )
                {
                    callback();
                }
            }
        }
        else
        {   
            $.get( url, function( content ){

                if( section == "all" )
                {
                    that.addToCache( section, content );
                    content =  $.parseJSON(content);
                    $.each( content, function( sec, cont ){
                        
                        that.append(cont,sec);
                        setTimeout(function(){
                            that.refresh(sec);
                        },500);
                    });
                }
                else
                {
                    that.addToCache( section, content );
                    that.append(content,section);
                    if(owl)
                    {
                        setTimeout(function(){
                            that.refresh(section);
                        },500);
                    }

                    if( typeof(callback) == "function" )
                    {
                        callback();
                    }
                }
                
            });
        }
    },
    addToCache: function( section, content )
    {
        if( content.length > 0 )
        {
            localStorage.setItem( section, content );
            localStorage.setItem( "date"+section, new Date().getTime() );
        }
    },
    refresh: function( section )
    {
        var el = $("#"+section);

        el.owlCarousel({
            items: 4,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [991, 3],
            itemsTablet: [767, 2],
            itemsMobile: [480, 1],
            autoPlay: false,
            stopOnHover: false,
            addClassActive: true,
        });

        // Custom Navigation Events
        el.closest(".block_product").find(".nexttab").click(function() {
            el.trigger('owl.next');
        });

        el.closest(".block_product").find(".prevtab").click(function() {
            el.trigger('owl.prev');
        })
    },
    hasLocal: function( section )
    {
        if( typeof localStorage == "object" )
        {
            updated = localStorage.getItem( "date"+section );
            now     = new Date().getTime();
            //345600000
            //1462783862844, 1462438262844
            ms = Math.abs( parseInt(now) - parseInt(updated) );

            if( ms != NaN && numDays(ms) > 2 && !this.force )
            {
                return false;
            }
            else
            {
                data = localStorage.getItem(section);

                if( data != null && !this.force )
                {
                    return data;
                }
                else
                {
                    return false;
                }
            }
        }
        else
        {
            return false;
        }
    },
    'compare_url' : "",
    'compare' : {
        load : function(){

            $.ajax({
                url: CONTENT.compare_url,
                type: "GET",
                dataType: "json",
                success: function (mobiles) {
                    var option = "";
                    $.each( mobiles, function( slug, mob ){
                            
                        option += "<option value='"+slug+"'>"+mob+"</option>";
                    });
                    
                    $(".compare_mobiles").append( option );
                    $('#mobile1 option:eq(5)').attr('selected', 'selected');
                    $('#mobile2 option:eq(6)').attr('selected', 'selected');
                }
            });
        },
    }
};

/*----------------------AJAX CONTENT ON HOME PAGE START----------------------*/

function numDays( ms )
{
    return Math.round( (((ms/1000)/60)/60)/24 );
}