(function ($) {
    var Notify = function (options) {
        var settings = $.extend({
            wrapper: $("#web_subscribe"),
            hideClass: 'hide_web_notify_box',
        }, options);

        var cont = {
            wrapper: settings.wrapper,
            hideClass: settings.hideClass,
            init: function () {
                this.registerEvent();
                this.showNotificationBox();
            },
            registerEvent: function () {
                this.wrapper.find(".close_web_notify").click(function () {
                    if (cont.wrapper.hasClass('top_show')) {
                        cont.wrapper.removeClass('top_show');
                        cont.wrapper.addClass('top_hide');

                        setCookie(cont.hideClass, 'yes', 2);
                    }
                });

                this.wrapper.find("#allow_notify").click(function () {
                    var jsElm = document.createElement("script");
                    // set the type attribute
                    jsElm.type = "application/javascript";
                    // make the script element load file
                    jsElm.src = '/assets/v2/js/fcm_app.js';
                    // finally insert the element to the body element in order to load the script
                    document.body.appendChild(jsElm);

                    if (cont.wrapper.hasClass('top_show')) {
                        cont.wrapper.removeClass('top_show');
                        cont.wrapper.addClass('top_hide');

                        setCookie(cont.hideClass, 'yes', 2);
                    }
                });
            },
            showNotificationBox: function () {
                if (!getCookie(this.hideClass) && Notification.permission != 'granted') {
                    cont.wrapper.removeClass('top_hide');
                    cont.wrapper.addClass('top_show');
                }
            },
        };
        setTimeout(function () {
            cont.init();
        }, 15000);
    };

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/;";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    Notify();
}(jQuery));