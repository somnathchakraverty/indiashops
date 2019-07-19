(function () {

    var isShowing = false;

    this.Notifier = function () {

        // Define option defaults
        var defaults = {
            autoOpen: false,
            direction: 'left',
            closeButton: false,
            content: "",
            link: "",
            element: "",
            image: "",
            json: '/json/notify.json',
            templateUrl: '/json/notify.json',
            params: {},
        }

        // Create options by extending defaults with the passed in arugments
        this.options = extendDefaults(defaults, arguments[0]);
        this.getSettings();
        this.init();
    };

    Notifier.prototype.show = function () {

        var shouldShow = this.prepareHtml();
        var _ = this;
        if (shouldShow) {
            _.updateProgressBar();
            this.el.removeClass(this.hideClass).addClass(this.showClass);
        }
    };

    Notifier.prototype.showLeft = function (first_argument) {
        this.el.removeClass(this.showClass)
        this.el.removeClass(this.hideClass)
        this.showClass = "left_show";
        this.hideClass = "left_hide";

        this.show();
    };

    Notifier.prototype.showBottom = function () {
        this.el.removeClass(this.showClass);
        this.el.removeClass(this.hideClass);
        this.showClass = "bottom_show";
        this.hideClass = "bottom_hide";

        this.show();
    };

    Notifier.prototype.hide = function () {
        this.el.removeClass(this.showClass).addClass(this.hideClass);
    };

    Notifier.prototype.init = function () {
        var _ = this;
        this.image = '';
        this.content = '';

        this.showClass = this.options.direction + "_show";
        this.hideClass = this.options.direction + "_hide";

        if (typeof this.options.element == 'string' && this.options.element.length > 0) {
            this.el = $("#" + this.options.element)
        }

        this.prepareHtml();

        if (this.options.closeButton) {
            $(document).on('click', "#" + this.options.closeButton, function () {
                setCookie('hide_notification_popup', 'yes', 5, location.pathname );
                _.hide();
            });
        }

        this.el.addClass(this.hideClass);
        this.el.removeAttr('style');
        this.startNotifications();

        $(document).on('click',"#notify_ind",function(){
            ga('send', 'event', 'notify_pop_clicked_'+environment, 'click')
        });
    };

    Notifier.prototype.startNotifications = function (first_argument) {
        var _ = this;
        this.timer = setInterval(function () {
            if (_.settings.max_notification > 0) {
                if (!_.isShowing) {
                    _.getNotification();
                    _.settings.max_notification -= 1;
                }

                if( getCookie('hide_notification_popup').length > 0 )
                {
                    clearInterval(_.timer)
                }
            }
            else {
                clearInterval(_.timer)
            }
        }, 10000);
    };

    Notifier.prototype.getNotification = function (first_argument) {
        var _ = this;
        this.isShowing = true;
        $.get(_.options.templateUrl, _.options.params).done(function (response) {

            if (typeof response.image != 'undefined' && typeof response.content != 'undefined') {
                _.setImage(response.image);
                _.setContent(response.content);

                if( typeof response.link != 'undefined' )
                {
                    _.setLink(response.link);
                }
                _.show();
            }
        });
    };

    Notifier.prototype.getSettings = function () {
        var _ = this;
        $.get(this.options.json, function (settings) {
            _.settings = settings;
        });
    };

    Notifier.prototype.setImage = function (image) {
        this.image = image;
    };

    Notifier.prototype.setContent = function (content) {
        this.content = content;
    };

    Notifier.prototype.setLink = function (link) {
        this.options.link = link;
    };

    Notifier.prototype.prepareHtml = function () {
        if (this.image.length == 0 && this.content.length == 0) {
            this.isShowing = false;
            return false;
        }

        if (this.options.link.length > 0) {
            var html = '<div id="notify_ind" class="content_box"><a href="' + this.options.link + '" target="_blank"><div class="row"><div class="col-sm-3" style="padding-right: 0px;"><div class="notify_image notify_box"><img src="' + this.image + '"></div></div><div class="col-sm-9"><div class="notify_content notify_box">' + this.content + '</div></div></div></a><div class="close_button" id="close_button">X</div><div class="progress"></div></div>'
        }
        else {
            var html = '<div id="notify_ind" class="content_box"><div class="row"><div class="col-sm-3" style="padding-right: 0px;"><div class="notify_image notify_box"><img src="' + this.image + '"d></div></div><div class="col-sm-9"><div class="notify_content notify_box">' + this.content + '</div></div></div><div class="close_button" id="close_button">X</div><div class="progress"></div></div>'
        }

        this.el.html(html);

        return true;
    };

    Notifier.prototype.updateProgressBar = function () {
        var percent = 0;
        var _ = this;

        $(".progress").show();
        $(".progress").css({width: '0%'});
        $(".progress").animate({width: '100%'}, _.settings.notification_time, function () {
            $(".progress").hide();
            _.hide();
            $(".progress").animate({width: '0%'});
            setTimeout(function () {
                _.isShowing = false;
            }, _.settings.delay_between);
        });
    };


    function extendDefaults(source, properties) {
        var property;
        for (property in properties) {
            if (properties.hasOwnProperty(property)) {
                source[property] = properties[property];
            }
        }
        return source;
    }

    function setCookie(cname, cvalue, exdays, path ) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires + ";path="+path+";";
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

}($));

if (typeof show_notification !== 'undefined' && getCookie('hide_notification_popup').length == 0 ) {
    if (typeof notification_params == 'undefined') {
        notification_params = '';
    }
    var notify = new Notifier({
        direction: 'left',
        element: "web_notify",
        closeButton: "close_button",
        templateUrl: templateUrl,
        params: notification_params
    });
}
