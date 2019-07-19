(function ($) {
    $.fn.cssCarousel = function (options) {
        /*Establish our default settings*/
        var controls = '<span class="prev">&lsaquo;</span><span class="next">&rsaquo;</span>';

        var settings = $.extend({
            itemScroll: 5,
            infinite: false
        }, options);

        return this.each(function () {

            var slider = $(this);
            var ul = slider.find("ul");
            var toScroll = ul.find("li:first-child").width();
            var totalWidth = parseInt(ul.find("li").length) * toScroll;

            slider.append(controls);
            
            var prevBtn = $(this).find('.prev');
            var nextBtn = $(this).find('.next');

            prevBtn.click(function () {
                slide('right');
            });

            nextBtn.click(function () {
                slide();
            });

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

                if (settings.infinite) {
                    if (newScroll < 0) {
                        scroll(ul, totalWidth);
                    }
                    else if (newScroll > totalWidth) {
                        scroll(ul, 0);
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
            }

            function scroll(el, width) {
                el.animate({
                    scrollLeft: width,
                }, {
                    duration: 800,
                    complete: function () {
                        resetBtn(el);
                        if (typeof processLazyLoad == 'function') processLazyLoad();
                    }
                });
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
        });
    }
}(jQuery));