function getPopupHtml($url, callback) {
    $.get(content_url, function (content) {
        $("#poup_content").html(content);
        if (typeof callback == 'function') {
            callback();
        }

        if (typeof page == 'undefined') page = 'comp';

        if (typeof ga != "undefined")
            ga('send', 'event', 'exit_popup_on_' + page, 'opened');
    });
}

if (typeof isExitPopupPage != 'undefined') {
    function ouibounce(el, custom_config) {
        "use strict";
        var config = custom_config || {},
            aggressive = config.aggressive || false,
            sensitivity = setDefault(config.sensitivity, 20),
            timer = setDefault(config.timer, 1000),
            delay = setDefault(config.delay, 0),
            callback = config.callback || function () {},
            cookieExpire = setDefaultCookieExpire(config.cookieExpire) || '',
            cookieDomain = config.cookieDomain ? ';domain=' + config.cookieDomain : '',
            cookieName = config.cookieName ? config.cookieName : 'viewedOuibounceModal',
            sitewide = config.sitewide === true ? ';path=/' : '',
            _delayTimer = null,
            _html = document.documentElement;

        function setDefault(_property, _default) {
            return typeof _property === 'undefined' ? _default : _property;
        }

        function setDefaultCookieExpire(days) {
            var ms = days * 24 * 60 * 60 * 1000;
            var date = new Date();
            date.setTime(date.getTime() + ms);
            return "; expires=" + date.toUTCString();
        }

        setTimeout(attachOuiBounce, timer);
        function attachOuiBounce() {
            if (isDisabled()) {
                return;
            }
            _html.addEventListener('mouseleave', handleMouseleave);
            _html.addEventListener('mouseenter', handleMouseenter);
            _html.addEventListener('keydown', handleKeydown);
        }

        function handleMouseleave(e) {
            if (e.clientY > sensitivity) {
                return;
            }

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
            if (disableKeydown) {
                return;
            }
            else if (!e.metaKey || e.keyCode !== 76) {
                return;
            }

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
            if (isDisabled()) {
                return;
            }
            if (el) {
            }
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
        aggressive: onDevServer,
        timer: 0,
        cookieExpire: 1,
        callback: function () { showExitPopup(); },
        cookieName: 'exitPopupModalShown',
    });

    function showExitPopup() {
        if (typeof product != 'undefined') {
            if (typeof page == 'undefined') {

                content_url = ajax_url + "/ajax-content/exit-popup?product=" + product;
            }
            else {
                content_url = ajax_url + "/ajax-content/exit-popup?page=" + page + "&product=" + product;
            }

            var store_link = $(".lastpricevanderbutton");

            callback = function(){
                if( typeof store_link !== 'undefined' )
                {
                    if( typeof store_link.html() !== "undefined")
                    {
                        $("#store_name").html( store_link.html() );
                        $("#store_url").attr( "href", store_link.attr("href") );
                    }
                    else
                    {
                        if($(".col-md-3.pleft .productgoto").html() == "OUT OF STOCK")
                        {
                            $("#store_name").html( "OUT OF STOCK" );
                            $("#store_url").attr( "href", "javascript:void;" );
                            $(".popupbuttonbox .col-md-6:first-child").hide();
                        }
                        else
                        {
                            $(".popupbuttonbox").hide();
                        }
                    }
                }
                else
                {
                    $("#store_info").hide();
                }
            };

            getPopupHtml(content_url, callback);
        }
        else if (typeof page != 'undefined') {
            content_url = ajax_url + "/ajax-content/exit-popup?page=" + page;
            callback = '';

            getPopupHtml(content_url, callback);
        }

        $("#exit_popup_modal").modal('show');
    }
}