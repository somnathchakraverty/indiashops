$(document).ready(function () {
    var send = false;
    var box = false;

    function completed(el) {
        try {
            $(el).autocomplete('option', 'source', completion[1]);
            $(el).autocomplete("search");
            $("#autocomplete").remove();
            box = el;
        }
        catch (e) {
            console.log(e)
        }
    }

    $("form .auto_search").autocomplete({
        minLength: 2,
        source: completion,
        select: function (event, ui) {
            $("form .auto_search").val(ui.item.label);
            $(box).closest('form').submit();
            return false;
        }
    });

    var url = 'https://completion.amazon.co.uk/search/complete?method=completion&mkt=44571&r=0V5Z5KRFA2VES2FWP7C3&s=' + amz_session + '&c=&p=Gateway&l=en_IN&sv=desktop&client=amazon-search-ui&x=String&search-alias=aps';
    var timeout;

    $(document).on('keyup', "form .auto_search", function (e) {
        keys = [37, 38, 39, 40, 16, 17, 18];

        if ($.inArray(e.keyCode, keys) > -1)
            return false;
        search_box = $(this);
        send = false;
        clearTimeout(timeout);
        var timeout = setTimeout(function () {
            send = true;
            if (send) {
                var script = document.createElement('script');
                script.onload = function () {
                    completed(search_box)
                };
                script.src = url + "&q=" + $(search_box).val();
                script.id = 'autocomplete';

                document.getElementsByTagName('head')[0].appendChild(script);
            }
        }, 600);
    });

    $(document).keydown(function (e) {
        if (e.shiftKey && e.ctrlKey && e.keyCode == 82) {
            localStorage.clear();
        }
    });
});
$.fn.CONTENT = {
    "uri": '',
    "force": false,
    "carousel": true,
    "pid": '',
    f: function (force) {
        this.force = force;
        return this;
    },
    load: function (section, carousel, post, callback) {
        this.showLoader(section);

        var wait = 0;
        if (wait > 0) {
            setTimeout(function () {
                CONTENT.get(section, carousel, post, callback);
            }, wait);
        }
        else {
            this.get(section, carousel, post, callback);
        }
    },
    append: function (content, section) {
        if (content.length > 0) {
            try {
                content = JSON.parse(content)
            }
            catch (e) {
            }

            if (typeof content == 'string') {
                $("#" + section).html(content);
            }
            else if (typeof content == 'object') {
                $.each(content, function (section, val) {
                    $("#" + section).html(val);
                });
            }

            $("#" + section).find('.carousel').hide();
        }
        else {
            $("#" + section).html('').closest("#" + section + '_wrapper').hide();
        }
    },
    get: function (section, carousel, post, callback) {
        url = this.uri + "/" + section;
        that = this;

        if (content = this.hasLocal(section + that.pid)) {
            if (section == "all") {
                content = $.parseJSON(content);
                $.each(content, function (sec, cont) {

                    that.append(cont, sec);
                    if (carousel) {
                        setTimeout(function () {
                            that.refresh(sec);
                        }, 500);
                    }
                    else {
                        $("#" + section).find('.carousel').fadeIn('fast');
                    }

                    if (typeof(callback) == "function") {
                        callback(cont);
                    }
                });
            }
            else {
                that.append(content, section);

                if (carousel) {
                    setTimeout(function () {
                        that.refresh(section);
                    }, 500);
                }
                else {
                    $("#" + section).find('.carousel').fadeIn('fast');
                }

                if (typeof(callback) == "function") {
                    callback(content);
                }
            }
        }
        else {
            if (typeof post != 'undefined') {
                if (typeof post.product != 'undefined')
                    url = url + "?content=" + post.product
                else {
                    var qstring = '';

                    $.each(post, function (param, value) {
                        qstring += param + "=" + value + "&";
                    });

                    url = url + "?" + qstring;
                }

                $.get(url, function (content) {

                    CONTENT.addToCache(section, content);
                    CONTENT.append(content, section);
                    if (carousel) {
                        setTimeout(function () {
                            CONTENT.refresh(section);
                        }, 500);
                    }
                    else {
                        $("#" + section).find('.carousel').fadeIn('fast');
                    }

                    if (typeof(callback) == "function") {
                        callback(content);
                    }
                }).fail(function () {
                    CONTENT.append('', section);
                });
                ;
            }
            else {
                $.get(url, function (content) {

                    CONTENT.addToCache(section, content);
                    CONTENT.append(content, section);
                    if (carousel) {
                        setTimeout(function () {
                            CONTENT.refresh(section);
                        }, 500);
                    }
                    else {
                        $("#" + section).find('.carousel').fadeIn('fast');
                    }

                    if (typeof(callback) == "function") {
                        callback(content);
                    }
                }).fail(function () {
                    CONTENT.append('', section);
                });
                ;
            }
        }
    },
    addToCache: function (section, content) {
        if (content.length > 0) {
            try {
                localStorage.setItem(section + this.pid, content);
                localStorage.setItem("date" + section, new Date().getTime());
            }
            catch (e) {
                localStorage.clear();
                localStorage.setItem(section + this.pid, content);
                localStorage.setItem("date" + section, new Date().getTime());
            }
        }
    },
    refresh: function (section) {
        var el = $("#" + section);

        if (el.is(':empty')) {
            el.closest("#" + section + "_wrapper").hide();
        }
        else {
            $(".cs_dkt_si").cssCarousel();
        }
    },
    hasLocal: function (section) {
        if (typeof localStorage == "object") {
            updated = localStorage.getItem("date" + section);
            now = new Date().getTime();
            ms = Math.abs(parseInt(now) - parseInt(updated));

            if (ms != NaN && numDays(ms) > 2 && !this.force) {
                return false;
            }
            else {
                data = localStorage.getItem(section);

                if (data != null && !this.force) {
                    return data;
                }
                else {
                    return false;
                }
            }
        }
        else {
            return false;
        }
    },
    'showLoader': function (section) {
        $("#" + section).html(loader_image);
    },
    'compare_url': "",
    'compare': {
        load: function () {

            $.ajax({
                url: CONTENT.compare_url,
                type: "GET",
                dataType: "json",
                success: function (mobiles) {
                    var option = "";
                    $.each(mobiles, function (slug, mob) {
                        option += "<option value='" + slug + "'>" + mob + "</option>";
                    });

                    $(".compare_mobiles").append(option);
                    $('#mobile1 option:eq(1)').attr('selected', 'selected');
                    $('#mobile2 option:eq(2)').attr('selected', 'selected');
                }
            });
        },
    }
};

var CONTENT = $.fn.CONTENT;

$(document).on('click preload', '.ajax_load', function (e) {
    var section = $(this).attr('data-section');
    var carousel = $(this).attr('data-carousel');
    var sub_sec = $(this).attr('data-sub-sec');
    var params = $(this).attr('data-params');

    if (notDefined(section)) {
        return false;
    }
    else {
        if (notDefined(sub_sec)) {
            var wrapper = section;
        }
        else {
            var wrapper = section + "_" + sub_sec;
        }
        if ($("#" + wrapper).html().trim() == '') {
            if (notDefined(sub_sec)) {

                var data = {};

                if (!notDefined(params)) {
                    data = {product: params};
                }
            }
            else {
                var data = {"sub_section": sub_sec};
            }

            CONTENT.f(true).load(section, ( carousel == 'yes' ) ? true : false, data, function (response) {
                $("#" + wrapper).html(response);
                CONTENT.refresh(wrapper);
            });
        }
    }
});

$(document).on('keypress', '.Search-anything', function (e) {
    if (e.keyCode == 13) {
        $(this).closest('.input-group').find('.section_search').trigger('click');
    }
});
$(document).on('click', '.section_search', function (e) {
    var section = $(this).attr('data-section');

    if (notDefined(section)) {
        return false;
    }
    else {
        var wrapper = $(this).parent().parent();
        var search_text = wrapper.find('.Search-anything').val();

        if (search_text.trim() == '') {
            return false;
        }

        $(this).parent().parent().find('.clear_search').fadeIn();

        var data = {"search_text": search_text, "cat_id": wrapper.find('.All-Categories').val()}

        CONTENT.f(true).load(section + "_search", true, data);
    }
});

$(document).on('keyup', '.Search-anything', function (e) {
    if (e.keyCode == 13) {

    }
});

$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });

    $(document).on('click', '.remove_from_compare', function (e) {
        var pid = $(this).attr('data-prod-id');
        update_compare_cookie(pid, 'remove');
        window.location.reload();
    });

    $(document).on('click', '.addtocomparebuttonright', function (e) {
        $(this).html('Adding...');
        var pid = $(this).parent().find('.add_compare_model').val();
        update_compare_cookie(pid, 'add');
        window.location.reload();
    });

    $(document).on('click', '.has-children a', function (e) {
        if ($(this).attr('href') == 'undefined') {
            return false;
        }
    });

    $(document).on('click', '.coupon_thum', function (e) {
        try {
            if (typeof $(this).attr('data-type') != "undefined") {
                var code = $(this).attr('data-code');
                var outpage = $(this).attr('data-out-page');
                var inpage = $(this).attr('data-in-page');

                if ($(this).attr('data-type') == "coupon") {
                    setCookie('coupon_code', atob(code), 1);
                    window.open(inpage);
                    window.location.href = outpage;
                }
                else {
                    window.open(outpage);
                }
            }
            else {
                window.location.reload();
            }
        } catch (e) {
        }
    });
});

$(document).on('click', '.clear_search', function (e) {
    var section = $(this).attr('data-section');

    if (notDefined(section)) {
        return false;
    }
    else {
        $(this).hide();
        var wrapper = $(this).parent();
        wrapper.find('.Search-anything').val('');

        CONTENT.load(section, true);
    }
});


function notDefined(variable) {
    if (typeof variable === 'undefined') {
        return true;
    }
    else {
        return false;
    }
}
function numDays(ms) {
    return Math.round((((ms / 1000) / 60) / 60) / 24);
}

function check_category($cat_id, el) {
    var category = getCookie('compare_product_category');

    if (category.length == 0) {
        setCookie('compare_product_category', $cat_id, 100);
    }
    else if (category != $cat_id) {
        setCookie('compare_product_list', '[]', 100);
        setCookie('compare_product_category', $cat_id, 100);
    }
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + ";path=/;";
}

$.fn.setCookie = function (cname) {
    return setCookie(cname);
};

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

$.fn.getCookie = function (cname) {
    return getCookie(cname);
};

function get_products() {
    var com_cookie = getCookie('compare_product_list');
    var prods = [];

    if (com_cookie.length > 0) {
        try {
            prods = $.parseJSON(com_cookie);
        }
        catch (err) {

        }
    }

    return prods;
}

function getCategoryBrands(category_id) {
    var file = composer_url + 'cat_brand_wise_prod.php?brand_size=10&category_id=' + category_id;

    $.getJSON(file, function (res) {
        if (typeof res.aggregations.brand.buckets != 'undefined') {
            var html = '';
            $.each(res.aggregations.brand.buckets, function (i, brand) {
                html += '<option value="' + brand.key + '">' + ucwords(brand.key) + '</option>';
            });

            $('.add_compare_brand').append(html);
        }
    });
}

function getCategoryBrands(category_id) {
    var file = composer_url + 'cat_brand_wise_prod.php?brand_size=40&category_id=' + category_id;
    $('.add_compare_brand').html('<option value="">  LOADING...</option>');
    $.getJSON(file, function (res) {
        if (typeof res.aggregations.brand.buckets != 'undefined') {
            var html = '';
            $.each(res.aggregations.brand.buckets, function (i, brand) {
                html += '<option value="' + brand.key + '">' + ucwords(brand.key) + '</option>';
            });
            $('.add_compare_brand').html('<option value="">---SELECT---</option>');
            $('.add_compare_brand').append(html);
        }
    });
}

$(document).on('change', '.add_compare_brand', function () {
    $('.add_compare_model').html('<option value="">  LOADING...</option>');

    var brand = $(this).val();
    var category_id = $(this).attr("category");

    var file = composer_url + 'cat_brand_wise_prod.php?size=20&category_id=' + category_id + "&brand=" + brand;

    $.getJSON(file, function (res) {
        if (typeof res.hits.hits != 'undefined') {
            var html = '<option value="">---SELECT---</option>';
            $.each(res.hits.hits, function (i, p) {
                p = p._source;
                html += '<option value="' + p.id + '">' + ucwords(p.name) + '</option>';
            });

            $('.add_compare_model').html(html);
        }
    });
});

function ucwords(str) {
    str = str.replace("_", " ");
    str = str.replace("_", " ");
    str = str.replace(/\b[a-z]/g, function (letter) {
        return letter.toUpperCase();
    });

    return str;
}
