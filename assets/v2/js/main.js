$(function(){$("header").before($(".StickyHeader").clone().addClass("fixed"));var g=0;$(window).scroll(function(){var a=$(window).scrollTop();var b=$("#wrapper1").height();var c=$("#right-container").height();if($(window).scrollTop()>=150&&$(window).width()>=768){$('.StickyHeader.fixed').addClass('slideDown');if((a+b)>=c){$('#sidebar-wrapper').removeClass('sticky');$('#sidebar-wrapper').addClass('smooth');if(g==0)g=a;var d=a-g;$('#sidebar-wrapper').parent().attr("style","top:-"+d+"px")}else{$('#sidebar-wrapper').addClass('sticky');$('#sidebar-wrapper').removeClass('smooth');g=0;$('#sidebar-wrapper').parent().removeAttr("style")}}else{$('.StickyHeader.fixed').removeClass('slideDown');$('#sidebar-wrapper').removeClass('sticky');$('#sidebar-wrapper').parent().removeAttr("style")}var e=$(".stick");var f=$("#right-container").height()-70;if($(window).scrollTop()>=150){if((a+e.height())>=f){if(g==0)g=a;var d=a-g;e.parent().attr("style","top:-"+d+"px");e.parent().removeClass("sticky-div")}{e.parent().addClass("sticky-div")}}else{e.parent().removeClass("sticky-div")}})});
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
    image.src = "https://www.indiashopps.com/images/v1/imgNoImg.png";
    return true;
}

$("img").each(function(){
    $(this).attr('onerror','imgError(this)');
});

$(document).ready(function(){
    $("a.ssmooth").click(function(){
        var height = $("#sticky-header").height() + 20;

        $('html, body').animate({
            scrollTop: $( $.attr(this, 'href') ).offset().top - height
        }, 800);

        return false;
    });

    var send = false;
    var box = false;
    function completed(el)
    {
        try{
            $(el).autocomplete('option', 'source', completion[1])
            $(el).autocomplete("search");
            $("#autocomplete").remove();
            box = el;
        }
        catch(e)
        {
            //$.get(ajax_url+"/ajax-content/autocomplete.html");
            console.log(e)
        }
    }

    $( "form .auto_search" ).autocomplete({
        minLength: 2,
        source: completion,
        select: function( event, ui ) {
            $( "form .auto_search" ).val( ui.item.label );
            $(box).closest('form').submit();
            return false;
        }
    });

    var url = 'http://completion.amazon.co.uk/search/complete?method=completion&mkt=44571&r=0V5Z5KRFA2VES2FWP7C3&s='+amz_session+'&c=&p=Gateway&l=en_IN&sv=desktop&client=amazon-search-ui&x=String&search-alias=aps';
    var timeout;

    $(document).on('keyup',"form .auto_search",function(e){
        keys = [37,38,39,40,16,17,18];

        if($.inArray(e.keyCode,keys) > -1)
            return false;
        search_box = $(this);
        send = false;
        clearTimeout(timeout);
        var timeout = setTimeout(function(){
            send = true;
            if(send)
            {
                var script = document.createElement('script');
                script.onload = function() {
                    completed(search_box)
                };
                script.src = url+"&q="+$(search_box).val();
                script.id = 'autocomplete';

                document.getElementsByTagName('head')[0].appendChild(script);
            }
        },600);
    });

    if(typeof isExitPopupPage != 'undefined' )
    {
        function ouibounce(el, custom_config) {
            "use strict";
            var config     = custom_config || {},
                aggressive   = config.aggressive || false,
                sensitivity  = setDefault(config.sensitivity, 20),
                timer        = setDefault(config.timer, 1000),
                delay        = setDefault(config.delay, 0),
                callback     = config.callback || function() {},
                cookieExpire = setDefaultCookieExpire(config.cookieExpire) || '',
                cookieDomain = config.cookieDomain ? ';domain=' + config.cookieDomain : '',
                cookieName   = config.cookieName ? config.cookieName : 'viewedOuibounceModal',
                sitewide     = config.sitewide === true ? ';path=/' : '',
                _delayTimer  = null,
                _html        = document.documentElement;

            function setDefault(_property, _default) {
                return typeof _property === 'undefined' ? _default : _property;
            }
            function setDefaultCookieExpire(days) {
                // transform days to milliseconds
                var ms = days*24*60*60*1000;
                var date = new Date();
                date.setTime(date.getTime() + ms);
                return "; expires=" + date.toUTCString();
            }
            setTimeout(attachOuiBounce, timer);
            function attachOuiBounce() {
                if (isDisabled()) { return; }
                _html.addEventListener('mouseleave', handleMouseleave);
                _html.addEventListener('mouseenter', handleMouseenter);
                _html.addEventListener('keydown', handleKeydown);
            }
            function handleMouseleave(e) {
                if (e.clientY > sensitivity) { return; }

                _delayTimer = setTimeout(fire, delay);
            }
            function handleMouseenter() {
                if (_delayTimer) {
                    clearTimeout(_delayTimer);
                    _delayTimer = null;
                }
            }
            var disableKeydown = false;
            function handleKeydown(e) {
                if (disableKeydown) { return; }
                else if(!e.metaKey || e.keyCode !== 76) { return; }

                disableKeydown = true;
                _delayTimer = setTimeout(fire, delay);
            }
            function checkCookieValue(cookieName, value) {
                return parseCookies()[cookieName] === value;
            }
            function parseCookies() {
                // cookies are separated by '; '
                var cookies = document.cookie.split('; ');

                var ret = {};
                for (var i = cookies.length - 1; i >= 0; i--) {
                    var el = cookies[i].split('=');
                    ret[el[0]] = el[1];
                }
                return ret;
            }
            function isDisabled() {
                return checkCookieValue(cookieName, 'true') && !aggressive;
            }
            function fire() {
                if (isDisabled()) { return; }
                if (el) {}
                callback();
                disable();
            }
            function disable(custom_options) {
                var options = custom_options || {};
                if (typeof options.cookieExpire !== 'undefined') {
                    cookieExpire = setDefaultCookieExpire(options.cookieExpire);
                }
                if (options.sitewide === true) {
                    sitewide = ';path=/';
                }
                if (typeof options.cookieDomain !== 'undefined') {
                    cookieDomain = ';domain=' + options.cookieDomain;
                }
                if (typeof options.cookieName !== 'undefined') {
                    cookieName = options.cookieName;
                }
                document.cookie = cookieName + '=true' + cookieExpire + cookieDomain + sitewide;
                _html.removeEventListener('mouseleave', handleMouseleave);
                _html.removeEventListener('mouseenter', handleMouseenter);
                _html.removeEventListener('keydown', handleKeydown);
            }
            return {
                fire: fire,
                disable: disable,
                isDisabled: isDisabled
            };
        }

        var _ouibounce = ouibounce(document.getElementById('exit_popup'), {
            /*aggressive: true,*/
            timer: 0,
            cookieExpire: 1,
            callback: function() { showExitPopup(); },
            cookieName : 'exitPopupModalShown',
        });

        function showExitPopup()
        {
            if(typeof product != 'undefined' )
            {
                if( typeof page == 'undefined' )
                {
                    var img = $("#sync1").find('.item:eq(0)').find('.larg-box.fancybox').clone();
                    var li = $(".mini_description").html();
                    var newLi = '';
                    img = img.attr('href',window.location).removeAttr('rel').removeClass('fancybox');

                    newLi = li.replaceAll('fa fa-circle btn-xs','fa fa-check-square readcolornew');

                    content_url = ajax_url+"/ajax-content/exit-popup?product="+product;

                    callback = function(){
                        $("#pop_left_specs").html(newLi);
                        $("#pop_left_product").html(img);
                    }
                }
                else
                {
                    content_url = ajax_url+"/ajax-content/exit-popup?page="+page+"&product="+product;
                    callback = '';
                }

                $("#exit_popup").modal('show');
                getPopupHtml(content_url, callback)
            }
            else if(typeof page != 'undefined' )
            {
                content_url = ajax_url+"/ajax-content/exit-popup?page="+page;
                callback = '';

                $("#exit_popup").modal('show');
                getPopupHtml(content_url, callback)
            }
        }
    }

    $(document).on('submit','form.form_search',function(e){
        var search_text = $(this).find('.auto_search').val();
        var cat_id = $(this).find('.category_id').val();

        if( typeof cat_id == "undefined" )
        {
            cat_id = 0;
        }

        var search_url  = ajax_url+"/search/"+cat_id+"/"+create_slug(search_text);
        window.location = search_url;

        return false;
    })

    setTimeout(function(){
        GCM.init();
    },5000);
});

function getPopupHtml($url, callback)
{
    $.get(content_url,function(content){
        $('#exit_popup').removeClass('fade').addClass('zoomIn animated');
        $("#poup_content").html(content);

        if( typeof callback == 'function' )
        {
            callback();
        }

        if( typeof page == 'undefined') page = 'comp';

        ga('send', 'event', 'exit_popup_on_'+page, 'opened')
    });
}


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

var GCM = {
    wrapper : $("#web_subscribe"),
    hideClass: 'hide_web_notify_box',
    init : function(){
        this.registerEvent();
        this.showNotificationBox();
    },
    registerEvent: function(){
        this.wrapper.find(".close_web_notify").click(function(){
            if( GCM.wrapper.hasClass('top_show') )
            {
                GCM.wrapper.removeClass('top_show');
                GCM.wrapper.addClass('top_hide');

                setCookie(GCM.hideClass, 'yes', 4);
            }
        });

        this.wrapper.find("#allow_notify").click(function(){
            if( GCM.wrapper.hasClass('top_show') )
            {
                GCM.wrapper.removeClass('top_show');
                GCM.wrapper.addClass('top_hide');

                setCookie(GCM.hideClass, 'yes', 4);
            }
        });
    },
    showNotificationBox: function(){
        if( !getCookie(this.hideClass) && Notification.permission == 'default' )
        {
            GCM.wrapper.removeClass('top_hide');
            GCM.wrapper.addClass('top_show');
        }
    },
};
var CONTENT = {
    "uri" : '',
    "force" : false,
    "owl"   : true,
    "pid" : '',
    f : function(force){
        this.force = force;
        return this;
    },
    load : function( section, owl, post, callback )
    {
        this.get(section, owl, post, callback);
    },
    append : function( content, section )
    {
        if( content.length > 0 )
        {
            try {
                content = JSON.parse(content)
            }
            catch(e){}

            if(typeof content == 'string')
            {
                $( "#"+section ).html( content );
                $( "#"+section+"-wrapper" ).hide().fadeIn("slow");
            }
            else if(typeof content == 'object' )
            {
                $.each(content,function(section,val){
                    $( "#"+section ).html( val );
                    $( "#"+section+"-wrapper" ).hide().fadeIn("slow");
                });
            }
            // $( "#"+section ).html( content ).show();
        }
        else
        {
            $( "#"+section ).html('').closest("#"+section+'-wrapper').hide();
        }
    },
    get : function( section, owl, post, callback )
    {
        url = this.uri+"/"+section;
        that = this;

        if( content = this.hasLocal(section+that.pid) )
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
            if( typeof post != 'undefined' )
            {
                if(typeof post.product != 'undefined')
                    url = url+"?content="+post.product

                $.get( url, function( content ){

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
                });
            }
            else
            {
                $.get( url, function( content ){

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
                });
            }
        }
    },
    addToCache: function( section, content )
    {
        if( content.length > 0 )
        {
            try{
                localStorage.setItem( section+this.pid, content );
                localStorage.setItem( "date"+section, new Date().getTime() );
            }
            catch(e)
            {
                localStorage.clear();
                localStorage.setItem( section+this.pid, content );
                localStorage.setItem( "date"+section, new Date().getTime() );
            }
        }
    },
    refresh: function( section )
    {
        var el = $("#"+section);

        if( el.is(':empty') )
        {
            el.closest("#"+section+"-wrapper").parent().hide();
        }
        else
        {
            el.owlCarousel({
                items: 4, //10 items above 1000px browser width
                itemsDesktop: [1000,5], //5 items between 1000px and 901px
                itemsDesktopSmall: [900,3], // betweem 900px and 601px
                itemsTablet: [600,2], //2 items between 600 and 0
                itemsMobile: false // itemsMobile disabled - inherit from itemsTablet option
            });

            // Custom Navigation Events
            el.closest("#"+section+"-wrapper").find(".customNavigation .next").click(function() {
                el.trigger('owl.next');
            });

            el.closest("#"+section+"-wrapper").find(".customNavigation .prev").click(function() {
                el.trigger('owl.prev');
            })
        }
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
                    $('#mobile1 option:eq(1)').attr('selected', 'selected');
                    $('#mobile2 option:eq(2)').attr('selected', 'selected');
                }
            });
        },
    }
};
function numDays( ms )
{
    return Math.round( (((ms/1000)/60)/60)/24 );
}

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'ig'), replacement);
};