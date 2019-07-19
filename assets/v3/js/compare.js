var compare = $('#compare-now');
var compare_div = $('#compare-product-list');
var compare_btn = "<a href='" + base_url + "/compare-products' target='_blank' class='form-control orange-button'>Compare All</a>";

$(document).on('change', '#product_wrapper .add-to-compare', function () {
    compare.fadeIn();
    var this_product = $(this).closest(".thumnail2");
    var prod_id = $(this).attr("data-prod-id");
    var cat_id = $(this).attr("data-cat");
    var imgtodrag = this_product.find("img");
    var data = [];

    check_category(cat_id, $(this));

    if ($(this).is(":checked")) {
        if (imgtodrag && update_compare_cookie(prod_id)) {
            var imgclone = imgtodrag.clone().offset({
                top: imgtodrag.offset().top, left: imgtodrag.offset().left
            }).css({
                'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            }).appendTo($('body')).animate({
                'top': compare.offset().top + 10,
                'left': compare.offset().left,
                'width': 75,
                'height': 75
            }, 1000, 'easeInOutExpo');

            imgclone.animate({'width': 0, 'height': 0}, function () {
                $(this).detach();

                data['title'] = this_product.find(".product_name").text();
                data['url'] = this_product.find("a").attr('href');
                data['price'] = this_product.find(".product_price").text().replace("Rs", "");
                data['img_src'] = this_product.find("img").attr('src');
                data['link'] = this_product.find("a").attr('href');

                update_compare_section(data, prod_id);
            });
        }
    }
    else {
        update_compare_cookie(prod_id, "remove");
    }
});

$(document).on('click', '.add_to_compare', function (e) {
    if (!$(this).hasClass('added') && !$(this).hasClass('cannot_add')) {
        var category = $(this).attr('data-cat');
        var pid = $(this).attr('data-prod-id');

        check_category(category, $(this));
        var added = update_compare_cookie(pid);

        if (added) {
            $(this).attr('href', '/compare-products').html('COMPARE');
            $(this).addClass('added');
        }
        return false;
    }
});

function check_products_compare() {
    var prod_ids = get_products();

    $.each($(".add_to_compare"), function (i, el) {
        var id = $(this).attr('data-prod-id');

        if ($.inArray(id, prod_ids) > -1) {
            $(this).attr('href', '/compare-products').html('COMPARE');
            $(this).attr('title', "Already Added");
            $(this).addClass('added');
        }
    });
}

$(document).on('change', '#add_comp_wrapper .add_compare_detail', function () {
    compare.fadeIn();
    var this_product = $(this).closest(".comp-product");
    var prod_id = $(this).attr("data-prod-id");
    var cat_id = $(this).attr("data-cat");
    var imgtodrag = this_product.find("a img");
    var data = [];
    check_category(cat_id, $(this));

    if ($(this).is(":checked")) {
        if (imgtodrag && update_compare_cookie(prod_id)) {
            var imgclone = imgtodrag.clone().offset({
                top: imgtodrag.offset().top, left: imgtodrag.offset().left
            }).css({
                'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            }).appendTo($('body')).animate({
                'top': compare.offset().top + 10,
                'left': compare.offset().left,
                'width': 75,
                'height': 75
            }, 1000, 'easeInOutExpo');

            imgclone.animate({'width': 0, 'height': 0}, function () {
                $(this).detach();

                data['title'] = this_product.find("h2 > a").text();
                data['url'] = this_product.find("h2 > a").attr('href');
                data['price'] = this_product.find(".price_comp").text().replace("Rs.", "");
                data['img_src'] = this_product.find("a img").attr('src');

                update_compare_section(data, prod_id);
            });
        }
    }
    else {
        update_compare_cookie(prod_id, "remove");
    }
});

$("#compare-add").click(function () {
    compare.fadeIn();
    var this_product = $("#product_details");
    var prod_id = $(this).attr("data-prod-id");
    var imgtodrag = this_product.find(".product-box-img.lazy");
    var img_wrapper = $("#sync1");
    var data = [];
    var el = $(this);

    if (!el.hasClass('added')) {
        if (imgtodrag && update_compare_cookie(prod_id)) {
            var imgclone = imgtodrag.clone().offset({
                top: img_wrapper.offset().top + 50, left: img_wrapper.offset().left + 90
            }).css({
                'opacity': '0.5',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            }).appendTo($('body')).animate({
                'top': compare.offset().top + 10,
                'left': compare.offset().left,
                'width': 75,
                'height': 75
            }, 1000, 'easeInOutExpo');

            imgclone.animate({'width': 0, 'height': 0}, function () {
                $(this).detach();

                data['title'] = this_product.find(".product-box-heading > a").text();
                data['url'] = this_product.find(".product-box-heading > a").attr('href');
                data['price'] = this_product.find(".product-box-heading-price").text().replace("₹", "");
                data['img_src'] = this_product.find(".product-box-img.lazy").attr('src');
                update_compare_section(data, prod_id);
                el.addClass('added').find(".comp-text").text('Remove Compare');
            });
        }
    }
    else {
        el.removeClass('added').find(".comp-text").text('Add to compare');
        update_compare_cookie(prod_id, "remove");
    }
});

function update_compare_cookie(prod_id, action) {
    var com_cookie = getCookie('compare_product_list');
    var json = get_products();

    if (typeof(action) === 'undefined') action = "add";

    if (action == "add") {

        if (json.length > 0) {
            var exists = $.inArray(prod_id, json) > -1;

            if (json.length < 3 && !exists) {
                json[json.length] = prod_id;

                if (json.length >= 3) {
                    $('input.add-to-compare:not(:checked)').attr('disabled', 'disabled');
                }
            }
            else {
                return false;
            }
        }
        else {
            var json = [prod_id];
        }
    }
    else {
        if (json) {
            var index = json.indexOf(prod_id);

            if (index > -1) {
                json.splice(index, 1);
                var checkbox = 'input[data-prod-id="' + prod_id + '"]';

                if ($(checkbox).is(":checked")) {
                    $(checkbox).prop('checked', false);
                    $(checkbox).attr('checked', false);
                }

                $("button[data-prod-id='" + prod_id + "']").closest('.product-wrapper').remove();

                if (json.length < 3) {
                    $('input.add-to-compare').removeAttr('disabled');
                }
            }
        }
    }

    setCookie('compare_product_list', JSON.stringify(json), 100);
    refresh_compare_products(true, true);

    if (location.href.indexOf("/compare-products") > -1 && action == "remove") {
        location.reload();
    }

    return true;
}

function refresh_compare_products(show, remove) {
    var count = get_products().length;

    if (typeof(show) === 'undefined') show = true;
    if (typeof(remove) === 'undefined') remove = false;

    compare.find("#compare-text").html("Compare Now (" + count + ")").hide().fadeIn();

    if (count > 0 && show) {
        if (!remove)
            $('body').addClass('sideOpen');
    }
    else {
        $('body').removeClass('sideOpen');
        compare.fadeOut('slow');
    }

    if (count >= 2) {
        $("#compare-button").html(compare_btn);
    }
    else {
        $("#compare-button").text("");
    }
}

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

function update_compare_section(prod, prod_id, show) {
    var com_cookie = getCookie('compare_product_list');
    var prods = get_products();
    var count = prods.length;
    var title = prod['title'];
    var price = prod['price'];
    var img_src = prod['img_src'];
    var purl = prod['link'];
    var char_len = 30;

    if (title.length > char_len)
        title = title.substring(0, char_len) + "...";

    if (typeof(show) === 'undefined') show = true;

    if (typeof prod['link'] != 'undefined') {
        purl = prod['link'];
    }
    else {
        if (prod_id.indexOf('-') !== -1) {
            var purl = base_url + "/" + create_slug(prod['title']) + "-price-in-india-" + prod_id;
        }
        else {
            var purl = base_url + "/" + create_slug(prod['title']) + "-price-in-india-" + prod_id;
        }
    }

    var prod_wrapper = '<div class="product-wrapper">';
    prod_wrapper += '<div class="row">';
    prod_wrapper += '<div class="col-md-3">';
    prod_wrapper += '<a href="' + purl + '" target="_blank">';
    prod_wrapper += '<img src="' + img_src + '" alt="" class="img-responsive compare-img">';
    prod_wrapper += '</a></div>';
    prod_wrapper += '<div class="col-md-9 pleft">';
    prod_wrapper += '<a href="' + purl + '" target="_blank" class="comparehadding">';
    prod_wrapper += '' + title + '';
    prod_wrapper += '</a>';
    prod_wrapper += '<div class="compare-price-color">Rs. ' + price + '</div>';
    prod_wrapper += '<p><button class="orange-button remove-product" data-prod-id="' + prod_id + '">Remove</button></p>';
    prod_wrapper += '</div>';
    prod_wrapper += '</div>';
    prod_wrapper += '</div>';

    $("#compare-product-list").append(prod_wrapper).hide().slideDown();
    refresh_compare_products(show);
}

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

function getImage(img_json) {
    try {
        imgs = $.parseJSON(img_json);
        return imgs[0];
    }
    catch (err) {
        return img_json;
    }
}

$(document).ready(function () {
    refresh_compare_list();
    check_products_compare();
    $(document).on('click', '#compare-product-list .remove-product, .remove-product', function () {
        var prod_id = $(this).attr("data-prod-id");
        var prodID = $("#productID").val();
        update_compare_cookie(prod_id, "remove");

        if (typeof prodID !== "undefined") {
            if (prodID == prod_id) {
                $("#compare-add").removeClass('added').find(".comp-text").text('Add to compare');
            }
        }
    });

    $(document).ajaxComplete(function () {
        var prods = get_products();
        var prodID = $("#productID").val();
        $(".add-to-compare").prop('checked', false);

        $.each(prods, function (key, prod_id) {
            $('input[data-prod-id="' + prod_id + '"]').prop('checked', true);

            if (typeof prodID !== "undefined") {
                if (prodID == prod_id) {
                    $("#compare-add").addClass('added').find(".comp-text").text('Remove compare');
                }
            }
        });

        if (prods.length < 4) {
            $(".add-to-compare").removeAttr('disabled');
        }
        else {
            $('input.add-to-compare:not(:checked)').attr('disabled', 'disabled');
        }
    });

    $('#compare-now').click(function () {
        $('body').toggleClass('sideOpen');
        return false;
    });

    $('a.closeTrigger').click(function () {
        $('body').removeClass('sideOpen');
        return false;
    });
});

function refresh_compare_list() {
    var data = [];

    var ids = getCookie('compare_product_list');

    if (ids.length > 2) {
        var url = composer_url + 'query_mget.php?ids=' + ids;
        var has_product = false;

        $.get(url, function (response) {
            try {
                result = $.parseJSON(response);
                var prods = result.docs;

                $(".add-to-compare").prop('checked', false);
                $(".add-to-compare").removeAttr('disabled');

                $("#compare-product-list").html("");

                $.each(prods, function (key, prod) {
                    data['title'] = prod._source.name;
                    data['img_src'] = getImage(prod._source.image_url);
                    data['price'] = new Intl.NumberFormat().format(prod._source.saleprice);

                    $('input[data-prod-id="' + prod._id + '"]').prop('checked', true);

                    update_compare_section(data, prod._id, false);

                    has_product = true;
                });

                if (result.docs.length >= 4) {
                    $('input.add-to-compare:not(:checked)').attr('disabled', 'disabled');
                }
            }
            catch (err) {

            }

            if (has_product) {
                compare.css({"right": "-100px"}).show().delay(1000);
                compare.animate({"right": "-50px"}, "fast");
            }
        });
    }

}

function check_category($cat_id, checkbox) {
    var category = getCookie('compare_product_category');

    if (category.length == 0) {
        setCookie('compare_product_category', $cat_id, 100);
    }
    else if (category != $cat_id) {
        $(".add-to-compare").prop('checked', false);
        checkbox.prop('checked', true);
        setCookie('compare_product_list', '[]', 100);
        setCookie('compare_product_category', $cat_id, 100);
        $("#compare-product-list").html('');
    }
}

function create_slug(str) {
    str = str.toLowerCase();
    str = str.replace(/\s/g, "-");
    str = str.replace(/,/g, "-");

    return str;
}