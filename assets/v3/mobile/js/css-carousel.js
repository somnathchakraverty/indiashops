(function ($) {
    $.fn.cssCarousel = function (options) {
        /*Establish our default settings*/
        var controls = '<span class="prev">&lsaquo;</span><span class="next">&rsaquo;</span>';
        var current = 1;
        var manual_scroll = true;
        var sliding = false;

        var settings = $.extend({
            itemScroll: 5,
            infinite: false,
            autoplay: false,
            interval: 2000,
            navigation: true,
            slide: function () {}
        }, options);

        return this.each(function () {

            var slider = $(this);
            var ul = slider.find("ul");

            $.each(ul.find("li"), function (i, e) {
                $(e).width($(window).width());
            });

            var toScroll = ul.find("li:first-child").width();
            var totalWidth = parseInt(ul.find("li").length) * toScroll;

            if (settings.navigation) {
                slider.append(controls);
            }

            var prevBtn = $(this).find('.prev');
            var nextBtn = $(this).find('.next');

            prevBtn.click(function () {
                slide('right');
            });

            ul.scroll(function () {
                if (manual_scroll) {
                    sliding = true;
                    clearTimeout($.data(this, 'scrollTimer'));
                    $.data(this, 'scrollTimer', setTimeout(function () {
                        sliding = false;
                        slide();
                    }, 250));
                }
            });

            nextBtn.click(function () {
                slide();
            });

            if (settings.autoplay) {
                setInterval(function () {
                    if (!sliding) {
                        slide();
                    }
                }, settings.interval);
            }

            function slide(direction) {
                if (toScroll == 0 || totalWidth == 0) {
                    toScroll = ul.find("li:first-child").width();
                    totalWidth = parseInt(ul.find("li").length) * toScroll;
                }

                if (typeof direction == 'undefined') direction = 'left';

                if (typeof ul.attr('data-items') != 'undefined') {
                    var items_to_scroll = ul.attr('data-items');
                }
                else {
                    var items_to_scroll = settings.itemScroll;
                }

                if (direction == 'right')
                    var newScroll = ul.scrollLeft() - (toScroll * items_to_scroll);
                else
                    var newScroll = ul.scrollLeft() + (toScroll * items_to_scroll);

                if ((current * toScroll) != newScroll) {
                    current = Math.round(ul.scrollLeft() / toScroll);
                    newScroll = current * toScroll;
                }

                if (settings.infinite) {
                    if (newScroll < 0) {
                        scroll(ul, totalWidth);
                    }
                    else if (newScroll >= totalWidth) {
                        scroll(ul, 0);
                        current = 0;
                    }
                    else {
                        scroll(ul, newScroll);
                    }
                }
                else {

                    if (newScroll <= totalWidth) {
                        scroll(ul, newScroll);
                    }
                    else if (newScroll > totalWidth) {
                        scroll(ul, totalWidth);
                    }
                }

                settings.slide(ul);
                current++;
            }

            function scroll(el, width) {
                manual_scroll = false;

                el.animate({
                    scrollLeft: width,
                }, {
                    duration: 800,
                    complete: function () {
                        resetBtn(el);
                        setTimeout(function () {
                            manual_scroll = true;
                        }, 250);
                    }
                });

                setTimeout(function () {
                    var img = ul.find("li:eq(" + (current-1) + ") img");
                    if (!img.hasClass('lazy-loaded')) {
                        img.lazyLoadXT();
						img.closest('.banner_loading').removeClass('banner_loading');
                    }
                }, 450);
            }

            function resetBtn(el) {
                if (toScroll == 0 || totalWidth == 0) {
                    toScroll = el.find("li:first-child").width();
                    totalWidth = parseInt(el.find("li").length) * toScroll;
                }

                if (el.scrollLeft() <= 10) {
                    prevBtn.hide();
                    nextBtn.show();
                }
                else if ((el.scrollLeft() + el.width()) >= totalWidth) {
                    prevBtn.show();
                    nextBtn.hide();
                }
                else {
                    prevBtn.show();
                    nextBtn.show();
                }
            }

            resetBtn(ul);

            slider.find(".banner_loading:first-child").removeClass("banner_loading");
        });
    }
}(jQuery));