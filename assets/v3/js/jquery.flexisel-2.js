! function(e) {
    e.fn.flexisel2 = function(t) {
        var n, i, l, a, o = e.extend({
                visibleItems: 4,
                itemsToScroll: 4,
                animationSpeed: 400,
                infinite: !0,
                navigationTargetSelector: null,
                autoPlay: {
                    enable: !1,
                    interval: 5e3,
                    pauseOnHover: !0
                },
                responsiveBreakpoints: {
                    portrait: {
                        changePoint: 480,
                        visibleItems: 1,
                        itemsToScroll: 1
                    },
                    landscape: {
                        changePoint: 640,
                        visibleItems: 2,
                        itemsToScroll: 2
                    },
                    tablet: {
                        changePoint: 768,
                        visibleItems: 3,
                        itemsToScroll: 3
                    }
                },
                loaded: function() {},
                before: function() {},
                after: function() {},
                resize: function() {}
            }, t),
            s = e(this),
            r = e.extend(o, t),
            c = !0,
            f = r.visibleItems,
            d = r.itemsToScroll,
            u = [],
            h = {
                init: function() {
                    return this.each(function() {
                        h.appendHTML(), h.setEventHandlers(), h.initializeItems()
                    })
                },
                initializeItems: function() {
                    var t = r.responsiveBreakpoints;
                    for (var l in t) u.push(t[l]);
                    u.sort(function(e, t) {
                        return e.changePoint - t.changePoint
                    });
                    var a = s.children();
                    a.first().addClass("index2"), n = h.getCurrentItemWidth(), i = a.length, a.width(n), r.infinite && (h.offsetItemsToBeginning(Math.floor(a.length / 2)), s.css({
                        left: -n * Math.floor(a.length / 2)
                    })), e(window).trigger("resize"), s.fadeIn(), r.loaded.call(this, s)
                },
                appendHTML: function() {
                    if (s.addClass("nbm-flexisel2-ul"), s.wrap("<div class='nbm-flexisel2-container'><div class='nbm-flexisel2-inner'></div></div>"), s.find("li").addClass("nbm-flexisel2-item"), r.navigationTargetSelector && e(r.navigationTargetSelector).length > 0 ? e("<div class='nbm-flexisel2-nav-left'></div><div class='nbm-flexisel2-nav-right'></div>").appendTo(r.navigationTargetSelector) : (r.navigationTargetSelector = s.parent(), e("<div class='nbm-flexisel2-nav-left'></div><div class='nbm-flexisel2-nav-right'></div>").insertAfter(s)), r.infinite) {
                        var t = s.children(),
                            n = t.clone(),
                            i = t.clone();
                        s.prepend(n), s.append(i)
                    }
                },
                setEventHandlers: function() {
                    var t = this,
                        i = s.children();
                    e(window).on("resize", function(a) {
                        c = !1, clearTimeout(l), l = setTimeout(function() {
                            c = !0, h.calculateDisplay(), n = h.getCurrentItemWidth(), i.width(n), r.infinite ? s.css({
                                left: -n * Math.floor(i.length / 2)
                            }) : (h.clearDisabled(), e(r.navigationTargetSelector).find(".nbm-flexisel2-nav-left").addClass("disabled"), s.css({
                                left: 0
                            })), r.resize.call(t, s)
                        }, 100)
                    }), e(r.navigationTargetSelector).find(".nbm-flexisel2-nav-left").on("click", function(e) {
                        h.scroll(!0)
                    }), e(r.navigationTargetSelector).find(".nbm-flexisel2-nav-right").on("click", function(e) {
                        h.scroll(!1)
                    }), r.autoPlay.enable && (h.setAutoplayInterval(), r.autoPlay.pauseOnHover === !0 && s.on({
                        mouseenter: function() {
                            c = !1
                        },
                        mouseleave: function() {
                            c = !0
                        }
                    })), s[0].addEventListener("touchstart", h.touchHandler.handleTouchStart, !1), s[0].addEventListener("touchmove", h.touchHandler.handleTouchMove, !1)
                },
                calculateDisplay: function() {
                    var t = e("html").width(),
                        n = u[u.length - 1].changePoint;
                    for (var i in u) {
                        if (t >= n) {
                            f = r.visibleItems, d = r.itemsToScroll;
                            break
                        }
                        if (t < u[i].changePoint) {
                            f = u[i].visibleItems, d = u[i].itemsToScroll;
                            break
                        }
                    }
                },
                scroll: function(e) {
                    if ("undefined" == typeof e && (e = !0), 1 == c) {
                        if (c = !1, r.before.call(this, s), n = h.getCurrentItemWidth(), r.autoPlay.enable && clearInterval(a), r.infinite) s.animate({
                            left: e ? "+=" + n * d : "-=" + n * d
                        }, r.animationSpeed, function() {
                            r.after.call(this, s), c = !0, e ? h.offsetItemsToBeginning(d) : h.offsetItemsToEnd(d), h.offsetSliderPosition(e)
                        });
                        else {
                            var t = n * d;
                            e ? s.animate({
                                left: h.calculateNonInfiniteLeftScroll(t)
                            }, r.animationSpeed, function() {
                                r.after.call(this, s), c = !0
                            }) : s.animate({
                                left: h.calculateNonInfiniteRightScroll(t)
                            }, r.animationSpeed, function() {
                                r.after.call(this, s), c = !0
                            })
                        }
                        r.autoPlay.enable && h.setAutoplayInterval()
                    }
                },
                touchHandler: {
                    xDown: null,
                    yDown: null,
                    handleTouchStart: function(e) {
                        this.xDown = e.touches[0].clientX, this.yDown = e.touches[0].clientY
                    },
                    handleTouchMove: function(e) {
                        if (this.xDown && this.yDown) {
                            var t = e.touches[0].clientX,
                                n = e.touches[0].clientY,
                                i = this.xDown - t;
                            this.yDown - n;
                            Math.abs(i) > 0 && (i > 0 ? h.scroll(!1) : h.scroll(!0)), this.xDown = null, this.yDown = null, c = !0
                        }
                    }
                },
                getCurrentItemWidth: function() {
                    return s.parent().width() / f
                },
                offsetItemsToBeginning: function(e) {
                    "undefined" == typeof e && (e = 1);
                    for (var t = 0; e > t; t++) s.children().last().insertBefore(s.children().first())
                },
                offsetItemsToEnd: function(e) {
                    "undefined" == typeof e && (e = 1);
                    for (var t = 0; e > t; t++) s.children().first().insertAfter(s.children().last())
                },
                offsetSliderPosition: function(e) {
                    var t = parseInt(s.css("left").replace("px", ""));
                    e ? t -= n * d : t += n * d, s.css({
                        left: t

                    })
                },
                getOffsetPosition: function() {
                    return parseInt(s.css("left").replace("px", ""))
                },
                calculateNonInfiniteLeftScroll: function(t) {
                    return h.clearDisabled(), h.getOffsetPosition() + t >= 0 ? (e(r.navigationTargetSelector).find(".nbm-flexisel2-nav-left").addClass("disabled"), 0) : h.getOffsetPosition() + t
                },
                calculateNonInfiniteRightScroll: function(t) {
                    h.clearDisabled();
                    var l = i * n - f * n;
                    return h.getOffsetPosition() - t <= -l ? (e(r.navigationTargetSelector).find(".nbm-flexisel2-nav-right").addClass("disabled"), -l) : h.getOffsetPosition() - t
                },
                setAutoplayInterval: function() {
                    a = setInterval(function() {
                        c && h.scroll(!1)
                    }, r.autoPlay.interval)
                },
                clearDisabled: function() {
                    var t = e(r.navigationTargetSelector);
                    t.find(".nbm-flexisel2-nav-left").removeClass("disabled"), t.find(".nbm-flexisel2-nav-right").removeClass("disabled")
                }
            };
        return h[t] ? h[t].apply(this, Array.prototype.slice.call(arguments, 1)) : "object" != typeof t && t ? void e.error('Method "' + method + '" does not exist in flexisel2 plugin!') : h.init.apply(this)
    }
}(jQuery);