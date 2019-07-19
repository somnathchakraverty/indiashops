var container = $("#compare_wrapper");
var pre_top;
var r_container = $("#right_container");
var loading_img = "<div class='col-md-2 col-md-offset-5'><img id='loading_img' src='" + load_image + "' alt='Loading more products.....' style='display:none'/></div>";
var no_more_prod = "<div class='col-md-12'><label class='btn btn-danger form-control' id='no_more_prod'>Thats All Folks !!!</label></div>";

function ucfirst(str, force) {
    str = force ? str.toLowerCase() : str;
    return str.replace(/(\b)([a-zA-Z])/,
        function (firstLetter) {
            return firstLetter.toUpperCase();
        });
}

function ucwords(str) {
    str = str.replace("_", " ");
    str = str.replace("_", " ");
    str = str.replace(/\b[a-z]/g, function (letter) {
        return letter.toUpperCase();
    });

    return str;
}

function clean(str) {
    /*Cleans the string..*/
    str = String(str);
    str = str.replace(/\s/g, "-");
    str = str.replace("&", "");
    str = str.replace(".", "");
    str = str.replace(".", "");
    str = str.replace("_", "-");
    return str.replace("+", "");
}

var ListingPage = $.ListingPage =
{
    model: {

        vars: {max_price: 0, min_price: 0, current_page: 1, loading: false, auto_load: true},
        ajax_url: "",
        hash: window.location.hash.replace("#", ""),
        fields: {},
        manual_slide: false,
        paginate: false,
        extra: {}
    },
    view: {

        vars: {
            p_wrapper: $("#compare_wrapper"),

        },
        /*Renders the product after the filter is changed..*/
        renderProducts: function (products) {

            if (products.indexOf("compprolistboxli") > -1) {
                view_wrapper = $("#compare_wrapper");

                view_wrapper.html(products);

                view_wrapper.find('.cs_dkt_si').each(function (i, e) {
                    var items = $(e).attr('data-items');

                    items = ( typeof items !== 'undefined') ? items : 5;

                    $(e).cssCarousel({itemScroll: items});
                });
            }
            else {
                var height = $("#wrapper1").height();

                var no_product = "<div class='no-products col-md-12' style='min-height:" + height + "px'><h3>Sorry !!! No products found.. </h3></div>";
                this.vars.p_wrapper.html(no_product).hide().fadeIn('slow');
            }
        },
        /*Changes the left filter value and attributes based on the filter selected..*/
        renderFilter: function (facet) {

            ListingPage.model.manual_slide = true;

            ListingPage.view.resetCheckboxes();

            if (typeof facet.filters_all != "undefined") {
                /*This part is for when any filter is selected..*/
                $.each(facet.filters_all, function (attrib, value) {
                    try {
                        if (typeof value == "object") {
                            /*//When attribute is object and has many attributes.*/
                            if (typeof value.buckets != "undefined") {
                                if ($.inArray(attrib, facet.filter_applied) == -1) {
                                    /*//When filter is selected manually*/
                                    ListingPage.view.updateFilterCheckbox(attrib.toLowerCase(), value.buckets);
                                }
                                else {
                                    /*//This part renders the left side bar when the predefined filters.*/
                                    ListingPage.view.defaultFilterUpdate();
                                }
                            }
                            else {
                                /*//saleprice filters...*/
                                if (attrib == "saleprice_min" && $.inArray(attrib, facet.filter_applied) == -1) {
                                    $("#price-range").slider({
                                        values: [value.value, ListingPage.model.vars.max_price]
                                    });
                                }
                                else if (attrib == "saleprice_max" && $.inArray(attrib, facet.filter_applied) == -1) {
                                    $("#price-range").slider({
                                        values: [ListingPage.model.vars.min_price, value.value]
                                    });
                                }
                            }
                        }
                    }
                    catch (exp) {
                        console.log(exp);
                        console.log("filterApplied");
                    }
                });

                if (typeof facet.total != "undefined") {
                    $("#total_products_load").html(facet.total);
                }
            }
            /*// When no filter is selected..*/
            else {
                try {
                    $.each(facet, function (attrib, value) {
                        if (typeof value == "object") {
                            if (typeof value.buckets != "undefined") {
                                ListingPage.view.updateFilterCheckbox(attrib.toLowerCase(), value.buckets);
                            }
                            else {
                                /*//saleprice filters...*/
                                if (attrib == "saleprice_min") {
                                    $("#price-range").slider({
                                        values: [ListingPage.model.vars.min_price, ListingPage.model.vars.max_price]
                                    });
                                }
                                else if (attrib == "saleprice_max") {
                                    $("#price-range").slider({
                                        values: [ListingPage.model.vars.min_price, ListingPage.model.vars.max_price]
                                    });
                                }
                            }
                        }
                    });
                }
                catch (exp) {
                    console.log(exp);
                    console.log("Without Filter");
                }
            }

            ListingPage.model.manual_slide = false;
            /*// Variable is set to false, for stopping Price slider to stop*/
        },

        /* Function for Applied filter, which shows all the filter applied above the product list*/
        renderAppliedFilter: function () {
            var has_filter = false;
            var fltr_text = "";
            var price = [];
            fields = ListingPage.model.fields;

            $.each(fields, function (label, value) {
                has_filter = true;
            });

            if (has_filter) {
                fltr_text += "<div class='clear-all btn btn-danger' id='clear-all'>Clear All </div>";
                $("#appliedFilter").addClass("applied");
            }
            else {
                $("#appliedFilter").removeClass("applied");
            }

            $("#appliedFilter").html(fltr_text).hide().fadeIn('slow');
        },

        /*//Appends the next set of products to the product wrapper for INFINITE scroll..*/
        addProducts: function (products) {

            var html = $.parseHTML(products);
            var img_el = $("#loading_img");
            m = ListingPage.model.vars;

            if (products.indexOf("thumnailimgbox") > -1) {
                ListingPage.view.vars.p_wrapper.html(products).fadeIn();
            }
            else {
                $("#no_more_prod").remove();
                r_container.append(no_more_prod);
                $(".showingitems").hide();
                m.auto_load = false;
            }

            img_el.hide();
        },

        /*//Reset all the checkbox in the left sidebar*/
        resetCheckboxes: function () {

            $("input[type='checkbox']").each(function () {
                $(this).prop("disabled", false);
            });
        },
        /*//Update all the checkboxes in the LEFT SIDEBAR when the filter is applied..*/
        updateFilterCheckbox: function (attr, values) {
            $(".checkbox." + attr + " input[type='checkbox']").prop("disabled", true);
            $(".checkbox." + attr).find("doc.sec_count").html("0");
            values = values.reverse();
            $.each(values, function (key, v) {

                try {
                    element = $(".checkbox." + attr + " #chk" + attr + "-" + clean(v.key));
                    element.prop("disabled", false);

                    celment = $("label[for='chk" + attr + "-" + clean(v.key) + "']");
                    celment.find("doc.sec_count").html(v.doc_count);
                }
                catch (e) {
                    console.log(attr);
                }
            });
        },
        /*// Update the checkbox for the any PRE FILTER...*/
        defaultFilterUpdate: function () {

            fields = ListingPage.model.fields;

            $.each(fields, function (attrib, val) {

                values = val.split(",");

                $.each(values, function (k, value) {
                    element = $("#chk" + attrib + "-" + clean(value));
                    element.prop("checked", true);
                });
            });
        },
    },
    /*****PRODUCTLIST CONTROLLER****/
    controller: {

        /*// Initializing the PRODUCT LIST JS file..*/
        init: function () {

            this.registerEvents();
            /*Register all the events for product page, click, remove, change.*/
            this.setupFilterURL();
            /*Setup the Ajax URL if any prefilter is applied*/
            this.initializePreFilter();
            /*Prefilter...*/

            if (Object.keys(ListingPage.model.fields).length > 0)
                this.getProducts();
            else
                ListingPage.view.resetCheckboxes();

        },
        /*Prefilter check for the hash values from the URL to see whether any prefilter is applied.*/
        initializePreFilter: function () {

            var hash = ListingPage.model.hash;
            ctrl = this;
            self = ListingPage;

            if (hash.length > 0) {
                var fields = hash.split("&");

                $.each(fields, function (e, field) {
                    var f = field.split("=");
                    self.model.fields[f[0]] = ucfirst(decodeURIComponent(f[1]));
                });
            }
        },
        /*Fired once any event is occured for filter changes..*/
        filterChanged: function () {
            this.getFilterFields();
            this.getProducts();
        },
        /*Changes the Browser URL with the HASH values*/
        updateURLHash: function (fields) {

            var hash = "";

            $.each(fields, function (key, val) {

                if (hash == "") {
                    hash = key + "=" + val;
                }
                else {
                    hash += "&" + key + "=" + val;
                }
            });

            window.location.hash = hash;
        },
        /*returns the Hashed value for all the applied filter fields..*/
        getURLHash: function () {

            fields = ListingPage.model.fields;
            var hash = "";

            $.each(fields, function (key, val) {

                if (hash == "") {
                    hash = key + "=" + val;
                }
                else {
                    hash += "&" + key + "=" + val;
                }
            });

            return hash;
        },
        /*Get the list of fields based on the checkbox selected in the left SIDEBAR*/
        getFilterFields: function () {

            fields = ListingPage.model.fields;
            fields = {};

            $(".__fltr_detail__").each(function (i, el) {

                key = $(this).attr("data-field");
                val = "";
                vars = ListingPage.model.vars;

                if (key == 'price_range' && $(this).is(":checked")) {
                    var parts = $(el).val().split('-');

                    if (parts.length > 0) {
                        ListingPage.model.manual_slide = true;

                        if (parts[0] == "*") {
                            fields['saleprice_max'] = parseInt(parts[1]);
                            $("#price-range").slider({
                                values: [ListingPage.model.vars.min_price, parseInt(parts[1])]
                            });
                        }
                        else if (parts[1] == "*") {
                            fields['saleprice_min'] = parseInt(parts[0]);
                            $("#price-range").slider({
                                values: [parseInt(parts[0]), ListingPage.model.vars.max_price]
                            });
                        }
                        else {
                            fields['saleprice_min'] = parseInt(parts[0]);
                            fields['saleprice_max'] = parseInt(parts[1]);

                            $("#price-range").slider({
                                values: [ListingPage.model.vars.min_price, ListingPage.model.vars.max_price]
                            });
                        }
                    }
                }
                else if ($(this).is(":checkbox") && $(this).is(":checked")) {
                    val = $(el).val();
                }
                else if ($(this).is(":text") && $(this).val().length > 0) {
                    val = $(el).val();
                }
                else if ($(this).is("[type='number']")) {
                    val = $(el).val();
                }
                else if (key == 'sort') {
                    if ($(el).parent().hasClass('active')) {
                        val = $(el).attr('value');
                    }
                }

                if (val !== "") {
                    if (typeof fields[key] == "undefined") {
                        fields[key] = val;
                    }
                    else {
                        fields[key] += "," + val;
                    }
                }
            });

            /*If the price hasn't change remove it from the filter fields..*/
            if (fields.saleprice_max == vars.max_price && fields.saleprice_min == vars.min_price) {
                delete fields.saleprice_max;
                delete fields.saleprice_min;
            }

            ListingPage.model.fields = fields;
            return fields;
        },
        /*Get the next page products..*/
        getNextPage: function () {},
        updateLoadMoreContent: function (facet) {},
        /*Getting the list of products using ajax, using the filtered fields.*/
        getProducts: function (send, callback) {

            if (typeof callback == "undefined") callback = "";

            if (typeof send == "undefined") {
                send = false;
                this.functions.overlay.show();
            }

            that = this;

            filter_url = that.generateAjaxURL();

            if (that.localCache.exist(filter_url)) {
                /*Returns the CACHED products..for any filter.*/
                try {
                    data = that.localCache.get(filter_url);

                    if (send) {
                        if ($.isFunction(callback)) callback(data.products);
                    }
                    else {
                        that.functions.overlay.hide();
                        that.renderViews(data);
                    }
                }
                catch (err) {
                    return false;
                }

                that.functions.overlay.hide();
            }
            else {
                /*Ajax call to get product with the filter URL*/
                $.get(filter_url, function (data) {

                    try {
                        data = $.parseJSON(data);

                        if (send) {
                            if ($.isFunction(callback)) callback(data.products);
                        }
                        else {
                            that.functions.overlay.hide();
                            that.renderViews(data);
                            that.localCache.set(filter_url, data);
                        }
                    }
                    catch (err) {
                        console.log(err);
                    }
                });
            }
        },

        /*Generate Views the the AJAX responses.*/
        renderViews: function (data, callback) {

            this.updateSortOptions();
            ListingPage.view.renderProducts(data.products);
            ListingPage.view.renderAppliedFilter();

            if ($.isFunction(callback)) callback();
            check_products_compare();
        },
        /*Generate AJAX URL based on the Filter applied..*/
        generateAjaxURL: function () {

            self = ListingPage;
            var params = "";

            $.each(self.model.fields, function (key, value) {
                params += "&" + key + "=" + encodeURIComponent(value);
            });

            if (ListingPage.model.extra.hasOwnProperty('product')) {
                params += "&product=" + encodeURIComponent(ListingPage.model.extra.product);
            }

            params += "&ajax=true&filter=true";

            if (ListingPage.model.paginate) {
                params += "&page=" + ListingPage.model.vars.current_page;
            }

            if (self.model.ajax_url.indexOf("?") > -1) {
                return self.model.ajax_url + params;
            }
            else {
                params = params.replace("&", "?");
                return self.model.ajax_url + params;
            }
        },
        /*Filter URL*/
        setupFilterURL: function () {
            ListingPage.model.ajax_url = target;
        },
        /*Updating the SORT BY options once any filter is applied..*/
        updateSortOptions: function () {},
        /*Caching the applied filter for fast processing..*/
        localCache: {
            data: {},
            remove: function (url) {
                delete this.data[url];
            },
            exist: function (url) {
                return this.data.hasOwnProperty(url) && this.data[url] !== null;
            },
            get: function (url) {
                return this.data[url];
            },
            set: function (url, cachedData, callback) {
                this.remove(url);
                this.data[url] = cachedData;
                if ($.isFunction(callback)) callback(cachedData);
            }
        },
        /*List of all the Events on Product Listing Page.*/
        registerEvents: function () {

            m = ListingPage.model;

            /*Any Filter input field change.*/
            $(document).on("change", ".__fltr_detail__", function () {
                target = target.replace('-{page?}', '');
                target = target.replace('-{page}', '');
                target = target.replace('{page?}', '');
                target = target.replace('{page}', '');

                var id = $(this).attr('id');

                if (( id == 'maxPrice' && $(this).val() <= ListingPage.model.vars.max_price ) || ( id == 'minPrice' && $(this).val() >= ListingPage.model.vars.min_price ) || !$(this).is("[type='number']")) {
                    ListingPage.model.vars.current_page = 0;
                    ListingPage.controller.setupFilterURL();
                    ListingPage.controller.filterChanged();
                }
                else {
                    if (id == 'maxPrice') {
                    }
                    else {
                    }
                }
            });

            /*Removes the applied filter..*/
            $(document).on("click", ".single-prop", function () {

                hasPrice = false;
                if ($(this).attr("name") == "price") {
                    hasPrice = true;
                    var prices = $(this).attr("value").split("-");
                    var id = "#chk" + prices[0] + "-" + prices[1];
                    $(id).prop("checked", false);
                }
                else if ($(this).attr("name") == "sort") {
                    var val = $(this).attr("value");

                    el = $('a[value="' + val + '"]');
                    el.closest("li").removeClass('active');
                    $("#sorting_options ul li:eq(1)").addClass('active');
                }
                else {
                    var id = "#chk" + $(this).attr("name") + "-" + clean($(this).attr("value"));
                    $(id).prop("checked", false);
                }

                if ($(this).attr("name") == "query") {
                    $("#search").val("");
                }

                if (hasPrice) {
                    $("#minPrice").val(ListingPage.model.vars.min_price);
                    $("#maxPrice").val(ListingPage.model.vars.max_price);
                }

                ListingPage.model.vars.current_page = 0;
                ListingPage.controller.setupFilterURL();
                ListingPage.model.manual_slide = true;
                ListingPage.controller.filterChanged();
                ListingPage.model.manual_slide = false;
            });

            $(document).on('click', '.price_filter_go', function () {
                ListingPage.controller.filterChanged();
            });

            $(document).on("click", "#clear-all", function () {

                $(".__fltr_detail__").each(function () {

                    key = $(this).attr("data-field");

                    if ($(this).is(":checkbox") && $(this).is(":checked")) {
                        $(this).prop("checked", false);
                    }
                    else if ($(this).is(":text") && $(this).val().length > 0) {
                        $(this).val("");
                    }
                    else if ($(this).is(":radio") && $(this).is(":checked")) {
                        $(this).prop("checked", false);
                    }
                    else if ($(this).is("[type='number']")) {
                        if (key == "saleprice_min") {
                            $(this).val(ListingPage.model.vars.min_price);
                        }

                        if (key == "saleprice_max") {
                            $(this).val(ListingPage.model.vars.max_price);

                            ListingPage.model.manual_slide = true;

                            $("#price-range").slider({
                                values: [ListingPage.model.vars.min_price, ListingPage.model.vars.max_price]
                            });

                            ListingPage.model.manual_slide = false;
                        }
                    }
                    else if (key == 'sort') {
                        if ($(this).attr("value").length > 0) {
                            $(this).parent().removeClass('active');
                        }
                        else {
                            $(this).parent().addClass('active');
                        }
                    }
                });

                ListingPage.model.vars.current_page = 0;
                ListingPage.controller.filterChanged();
            });

            $(document).on('click', '.page-link-ajax', function (e) {

                if (parseInt($(this).attr('data-page')) > 0) {
                    var url = $(this).attr('href') + window.location.hash;
                    window.history.pushState('page' + $(this).attr('data-page'), 'Page ' + $(this).attr('data-page'), url);

                    m = ListingPage.model.vars;

                    m.current_page = parseInt($(this).attr('data-page'));

                    ListingPage.controller.getNextPage();
                }

                e.preventDefault();

            });

            /*INFINITE Scroll, and get the next page products..*/
            $(window).scroll(function () {

                m = ListingPage.model.vars;

                var scrolled = $(window).scrollTop() + $(window).height() / 2;
                var offset = container.offset();
                var c_height = container.height();
                var back_top = $(".back-top").height();

                if (scrolled > ( c_height - back_top ) && !m.loading && scrolled > pre_top && m.auto_load) {
                    m.loading = true;
                }

                pre_top = scrolled;
            });

            $('#sorting_options ul li a').on('shown.bs.tab', function (e) {
                ListingPage.controller.filterChanged();
            });
        },

        setMaxMinPrice: function () {
            ListingPage.model.vars.max_price = pro_max;
            ListingPage.model.vars.min_price = pro_min;
        },

        functions: {
            /*Adds overlay to the document once any filter is applied or removed..*/
            "addOverlay": function () {

                var overlay = '<div class="overlay_list" id="overlay_list" style="display:none"><div class="loader center"><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div></div></div>';
                $("#right_container").append(overlay);
            },
            /*Show and hide the Overlay for loading the filter.*/
            'overlay': {

                'show': function () {

                    if ($("#overlay_list").text() == '') {
                        ListingPage.controller.functions.addOverlay();
                    }

                    $('html, body').animate({
                        scrollTop: $("#right_container").offset().top - 100
                    }, 800);

                    $("#overlay_list").fadeIn();
                },
                'hide': function () { $("#overlay_list").fadeOut(); }
            },
        },
    },
};

$(document).ready(function () {
    /*Initializing the Product List JS filter functionality..*/
    ListingPage.controller.init();
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

function decode(s) {
    s.replace("&amp;", "&");
    return s;
}
