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
		if (VMEGAMENU_POPUP_EFFECT == 0) $(this).find('.popup').stop(true, true).slideDown('slow');
		if (VMEGAMENU_POPUP_EFFECT == 1) $(this).find('.popup').stop(true, true).fadeIn('slow');
		if (VMEGAMENU_POPUP_EFFECT == 2) $(this).find('.popup').stop(true, true).show('slow');
	}, function() {
		if (VMEGAMENU_POPUP_EFFECT == 0) $(this).find('.popup').stop(true, true).slideUp('fast');
		if (VMEGAMENU_POPUP_EFFECT == 1) $(this).find('.popup').stop(true, true).fadeOut('fast');
		if (VMEGAMENU_POPUP_EFFECT == 2) $(this).find('.popup').stop(true, true).hide('fast');
	});


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
                if (CUSTOMMENU_POPUP_EFFECT == 0) $(this).find('.popup').stop(true, true).slideDown('slow');
                if (CUSTOMMENU_POPUP_EFFECT == 1) $(this).find('.popup').stop(true, true).fadeIn('slow');
                if (CUSTOMMENU_POPUP_EFFECT == 2) $(this).find('.popup').stop(true, true).show('slow');
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


//<![CDATA[
var CUSTOMMENU_POPUP_EFFECT = 0;
var CUSTOMMENU_POPUP_TOP_OFFSET = 46;
//]]>			