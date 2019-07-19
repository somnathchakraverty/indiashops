/**VARIABLES FOR PRODUCT LISTING**/
var container = $("#product_wrapper");
var pre_top;
var r_container = $("#right_container");
var loading_img = "<div style='text-align: center'><img id='loading_img' src='" + load_image + "' alt='Loading more products.....' style='display:none'/></div>";
var no_more_prod = "<div class='col-md-12'><label class='btn btn-danger form-control' id='no_more_prod'>Thats All Folks !!!</label></div>";

$(document).ready(function () {

    $("#load-more-wrapper").append(loading_img);

    /* Remove the ATTRIBUTEs which are not matching the search criteria*/
    $(".search_attr").keyup(function () {

        var brand = $(this).val();
        brand = ucfirst(brand, true);
        var parent_ul = $(this).parent().parent();
        var not_matched = parent_ul.find(".checkbox .attr_group_val:not(:contains('" + brand + "'))");
        var matched = parent_ul.find(".checkbox .attr_group_val:contains('" + brand + "')");
        var total = parent_ul.find(".checkbox .fix-slide-checkbox");

        not_matched.each(function () {
            $(this).parent().hide();
        });

        matched.each(function () {
            $(this).parent().show();
        });
    });

    /*** This function has click event for search page, and change URL once category is selected. ***/
    $(document).on("click", ".search-category", function () {
        var cat_id = $(this).attr("id");
        var url = window.location.href;

        url = url.split("#")[0]
        url = url.split("?cat_id")[0];

        url = url + "?cat_id=" + cat_id + window.location.hash;

        window.location.href = url;
    });
});

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
    //Cleans the string..
    str = String(str)
    str = str.replace(/\s/g, "-");
    str = str.replace("&", "");
    str = str.replace(".", "");
    str = str.replace(".", "");
    str = str.replace("_", "-");
    return str.replace("+", "");
}

/***********************Product List Filter**************************/

var ListingPage =
{
    model: {

        vars: {max_price: 0, min_price: 0, current_page: 1, loading: false, auto_load: true},
        ajax_url: "",
        hash: window.location.hash.replace("#", ""),
        fields: {},
        manual_slide: false,
        paginate: false,
    },
    view: {

        vars: {
            p_wrapper: $("#product_wrapper"),

        },
        //Renders the product after the filter is changed..
        renderProducts: function (products) {
            if (products.indexOf("mobilecard2") > -1) {
                this.vars.p_wrapper.html(products).hide().fadeIn('slow');

                if ($(products).find('.mobilecard2').length < 32) {

                }
            }
            else {
                var height = $("#wrapper1").height();

                var no_product = "<div class='no-products col-md-12' style='min-height:" + height + "px'><h3>Sorry !!! No products found.. </h3></div>";
                this.vars.p_wrapper.html(no_product).hide().fadeIn('slow');
            }
        },
        //Changes the left filter value and attributes based on the filter selected..
        renderFilter: function (facet) {

            ListingPage.model.manual_slide = true;

            ListingPage.view.resetCheckboxes();

            if (typeof facet.filters_all != "undefined") {
                /// This part is for when any filter is selected..
                $.each(facet.filters_all, function (attrib, value) {
                    try {
                        if (typeof value == "object") {
                            //When attribute is object and has many attributes.
                            if (typeof value.buckets != "undefined") {
                                if ($.inArray(attrib, facet.filter_applied) == -1) {
                                    //When filter is selected manually
                                    ListingPage.view.updateFilterCheckbox(attrib.toLowerCase(), value.buckets);
                                }
                                else {
                                    //This part renders the left side bar when the predefined filters.
                                    ListingPage.view.defaultFilterUpdate();
                                }
                            }
                            else {
                                //saleprice filters...
                                if (attrib == "saleprice_min" && $.inArray(attrib, facet.filter_applied) == -1) {
                                    /*$("#price-range").slider({
                                        values: [value.value, ListingPage.model.vars.max_price]
                                    });*/
                                }
                                else if (attrib == "saleprice_max" && $.inArray(attrib, facet.filter_applied) == -1) {
                                    /*$("#price-range").slider({
                                        values: [ListingPage.model.vars.min_price, value.value]
                                    });*/
                                }
                            }
                        }
                    }
                    catch (exp) {
                        //Exception
                        console.log(exp);
                        console.log("filterApplied")
                    }
                });

                if (typeof facet.total != "undefined") {
                    $("#total_products_load").html(facet.total);
                }
            }
            // When no filter is selected..
            else {
                try {
                    $.each(facet, function (attrib, value) {
                        if (typeof value == "object") {
                            if (typeof value.buckets != "undefined") {
                                ListingPage.view.updateFilterCheckbox(attrib.toLowerCase(), value.buckets);
                            }
                            else {
                                //saleprice filters...
                                if (attrib == "saleprice_min") {
                                    // $("#minPrice").val( value.value )
                                    /*$("#price-range").slider({
                                        values: [ListingPage.model.vars.min_price, ListingPage.model.vars.max_price]
                                    });*/
                                }
                                else if (attrib == "saleprice_max") {
                                    /*$("#price-range").slider({
                                        values: [ListingPage.model.vars.min_price, ListingPage.model.vars.max_price]
                                    });*/
                                }
                            }
                        }
                    });
                }
                catch (exp) {
                    console.log(exp);
                    console.log("Without Filter")
                }
            }

            ListingPage.model.manual_slide = false; // Variable is set to false, for stopping Price slider to stop
            //$(".nano").nanoScroller({alwaysVisible: true});
            //$(".nano1").nanoScroller({alwaysVisible: true, paneClass: 'scrollPane'});
        },

        /* Function for Applied filter, which shows all the filter applied above the product list*/
        renderAppliedFilter: function () {

            fields = ListingPage.model.fields;

            var fltr_label = {};
            var fltr_text = "";
            var price = [];

            $.each(fields, function (label, value) {

                switch (label) {

                    case "query":

                        if (value.length > 0) {
                            fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Search: </span>";
                            fltr_label[label] += "<div value='" + value + "' class='single-prop' name='query'><span class='fltr-name'>" + ucfirst(value, true) + "</span><span class='fltr-remove'>X</span></div>";
                            fltr_label[label] += "</div>";
                        }

                        break;

                    case "saleprice_max":

                        price['saleprice_max'] = value;
                        break;

                    case "saleprice_min":

                        price['saleprice_min'] = value;
                        break;

                    case "sort":

                        if (value == 'p-d' || value == 'P-d') {
                            fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Sort: </span>";
                            fltr_label[label] += "<div value='" + value + "' name='sort' class='single-prop'><span class='fltr-name'>Price High to Low</span><span class='fltr-remove'>X</span></div>";
                        }
                        else if (value == 'p-a' || value == 'P-a') {
                            fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Sort: </span>";
                            fltr_label[label] += "<div value='" + value + "' name='sort' class='single-prop'><span class='fltr-name'>Price Low to High</span><span class='fltr-remove'>X</span></div>";
                        }

                        break;

                    case "vendor":

                        vendors = value.split(",");
                        fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>Vendor: </span>";

                        $.each(vendors, function (i, vendor) {
                            fltr_label[label] += "<div value='" + vendor + "' name='vendor' class='single-prop'><span class='fltr-name'>" + ucfirst(alvendors.name[vendor], true) + "</span><span class='fltr-remove'>X</span></div>";
                        });

                        fltr_label[label] += "</div>";
                        break;

                    default:

                        values = value.split(",");
                        fltr_label[label] = "<div class='single-fltr'><span class='fltr-label'>" + ucwords(label) + ": </span>";

                        $.each(values, function (i, val) {
                            fltr_label[label] += "<div value='" + val + "' class='single-prop' name='" + label + "'><span class='fltr-name'>" + val + "</span><span class='fltr-remove'>X</span></div>";
                        });
                        fltr_label[label] += "</div>";

                        break;
                }

            });

            if (price['saleprice_min'] && price['saleprice_max']) {
                fltr_label['price'] = "<div class='single-fltr'><span class='fltr-label'>Price: </span><div name='price' value='" + price['saleprice_min'] + "-" + price['saleprice_max'] + "' class='single-prop'><span class='fltr-name'>" + price['saleprice_min'] + "-" + price['saleprice_max'] + "</span><span class='fltr-remove'>X</span></div></div>";
            }

            $.each(fltr_label, function (i, txt) {
                fltr_text += txt;
            })

            if (fltr_text.length > 0) {
                fltr_text += "<div class='clear-all btn btn-danger' id='clear-all'>Clear All </div>";
                $("#appliedFilter").addClass("applied");
            }
            else {
                $("#appliedFilter").removeClass("applied");
            }

            $("#appliedFilter").html(fltr_text).hide().fadeIn('slow');
        },

        //Appends the next set of products to the product wrapper for INFINITE scroll..
        addProducts: function (products) {

            var html = $.parseHTML(products);
            var img_el = $("#loading_img");
            m = ListingPage.model.vars;

            if (products.indexOf("mobilecard2") > -1) {
                $("#product_wrapper").append(products).fadeIn();

                m.loading = false;

                //$(window).scroll();

                if (ListingPage.model.vars.current_page >= 4) {
                    m.auto_load = false;
                    $("#load-more").show();
                } else {
                    m.auto_load = true;
                    //$("#load-more").hide();
                }
            }
            else {
                $("#no_more_prod").remove();
                r_container.append(no_more_prod);
                $(".showingitems").hide();
                m.auto_load = false;
            }

            img_el.hide();
        },

        //Reset all the checkbox in the left sidebar
        resetCheckboxes: function () {

            $("input[type='checkbox']").each(function () {

                $(this).prop("disabled", false);
                // $(this).prop("checked",false);
            });
        },
        //Update all the checkboxes in the LEFT SIDEBAR when the filter is applied..
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
                    //celment.detach().prependTo($(".checkbox."+attr));
                }
                catch (e) {
                    console.log(attr)
                }
            });
        },
        // Update the checkbox for the any PRE FILTER...
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

        // Initializing the PRODUCT LIST JS file..
        init: function () {

            this.setMaxMinPrice(); // Sets Min, Max price in the product list
            this.registerEvents(); // Register all the events for product page, click, remove, change.
            this.setupFilterURL(); // Setup the Ajax URL if any prefilter is applied
            this.initializePreFilter(); // Prefilter...
            this.functions.addOverlay(); // Loading Overlay

            if (Object.keys(ListingPage.model.fields).length > 0) {
                this.getProducts();
                console.log("init done.");
            }
            else
                ListingPage.view.resetCheckboxes();

        },
        // Prefilter check for the hash values from the URL to see whether any prefilter is applied.
        initializePreFilter: function () {

            var hash = ListingPage.model.hash;
            ctrl = this;
            self = ListingPage;

            if (hash.length > 0) {
                var fields = hash.split("&");

                $.each(fields, function (e, field) {
                    var f = field.split("=");
                    self.model.fields[f[0]] = decodeURIComponent(f[1]);
                });
            }
        },
        //Fired once any event is occured for filter changes..
        filterChanged: function () {

            ListingPage.model.vars.current_page = 1;
            //ListingPage.model.vars.auto_load 	= true;

            fields = this.getFilterFields();

            this.updateURLHash(fields);
            this.getProducts();

        },
        //Changes the Browser URL with the HASH values
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
        //returns the Hashed value for all the applied filter fields..
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
        // Get the list of fields based on the checkbox selected in the left SIDEBAR
        getFilterFields: function () {

            fields = ListingPage.model.fields;
            fields = {};

            $(".fltr__src").each(function (i, el) {

                key = $(this).attr("field");
                val = "";
                vars = ListingPage.model.vars;

                if (key == 'price_range' && $(this).is(":checked")) {
                    var parts = $(el).val().split('-');

                    if (parts.length > 0) {
                        ListingPage.model.manual_slide = true;

                        if (parts[0] == "*") {
                            fields['saleprice_max'] = parseInt(parts[1]);
                            /*$("#price-range").slider({
                                values: [ListingPage.model.vars.min_price, parseInt(parts[1])]
                            });*/
                        }
                        else if (parts[1] == "*") {
                            fields['saleprice_min'] = parseInt(parts[0]);
                            /*$("#price-range").slider({
                                values: [parseInt(parts[0]), ListingPage.model.vars.max_price]
                            });*/
                        }
                        else {
                            fields['saleprice_min'] = parseInt(parts[0]);
                            fields['saleprice_max'] = parseInt(parts[1]);

                            /*$("#price-range").slider({
                                values: [ListingPage.model.vars.min_price, ListingPage.model.vars.max_price]
                            });*/
                        }
                    }
                }
                else if ($(this).is(":checkbox") && $(this).is(":checked")) {
                    val = $(el).val();
                }
                else if ($(this).is(":radio") && $(this).is(":checked")) {
                    val = $(el).val();
                }
                else if ($(this).is(":text") && $(this).val().length > 0) {
                    val = $(el).val();
                }
                else if ($(this).is("[type='number']")) {
                    val = $(el).val();
                }

                if (val !== "") {
                    if (typeof fields[key] == "undefined") {
                        fields[key] = val
                    }
                    else {
                        fields[key] += "," + val;
                    }
                }
            });

            // If the price hasn't change remove it from the filter fields..
            if (fields.saleprice_max == vars.max_price && fields.saleprice_min == vars.min_price) {
                delete fields.saleprice_max;
                delete fields.saleprice_min;
            }

            ListingPage.model.fields = fields;
            return fields;
        },
        // Get the next page products..
        getNextPage: function () {


            m.loading = true;

            ListingPage.model.vars.current_page++;

            $("#loading_img").show();
            $("#load-more").hide();

            ListingPage.model.paginate = true;
            this.setupFilterURL();

            this.getProducts(true, function (products) {

                ListingPage.model.paginate = false;

                //Callback function once the product are fetched from Solr
                ListingPage.view.addProducts(products);

                m.loading = false;

                ListingPage.controller.updateLoadMoreContent();

                $("#loading_img").hide();
                $("#load-more").show();
            });
        },
        updateLoadMoreContent: function (facet) {

            var total = 32;

            if (typeof facet != "undefined" && typeof facet.total != "undefined") {
                if (facet.total < total) {
                    total = facet.total
                }
            }

            var from = ( (ListingPage.model.vars.current_page - 1 ) * total);
            var range = String(from + 1) + " - " + String(from + total);
            l
            $("#product_range_count").html(range);
        },
        //Getting the list of products using ajax, using the filtered fields.
        getProducts: function (send, callback) {

            if (typeof callback == "undefined") callback = "";

            if (typeof send == "undefined") {
                send = false;
                this.functions.overlay.show()
            }

            that = this;

            filter_url = that.generateAjaxURL();

            if (that.localCache.exist(filter_url)) {
                //Returns the CACHED products..for any filter.
                try {
                    data = that.localCache.get(filter_url);

                    if (send) {
                        if ($.isFunction(callback)) callback(data.products);
                    }
                    else {
                        that.functions.overlay.hide();
                        that.renderViews(data, function(){ processLazyLoad() });
                    }
                }
                catch (err) {
                    return false;
                }

                that.functions.overlay.hide()
            }
            else {
                //Ajax call to get product with the filter URL
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
                        console.log(err)
                    }
                });
            }
        },

        //Generate Views the the AJAX responses.
        renderViews: function (data, callback) {
            this.updateSortOptions();
            ListingPage.view.renderProducts(data.products);
            ListingPage.view.renderAppliedFilter();
            ListingPage.view.renderFilter(data.facet);

            ListingPage.controller.updateLoadMoreContent(data.facet);

            if ($.isFunction(callback)) callback();
        },
        //Generate AJAX URL based on the Filter applied..
        generateAjaxURL: function () {

            self = ListingPage;
            var params = "";

            $.each(self.model.fields, function (key, value) {
                params += "&" + key + "=" + encodeURIComponent(value);
            });

            params += "&ajax=true&filter=true&mobile_ajax=true";

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
        //Filter URL
        setupFilterURL: function () {
            w = window.location;
            page = ListingPage.model.vars.current_page;
            l = w.origin + w.pathname + w.search;

            ListingPage.model.ajax_url = l;
        },
        // Updating the SORT BY options once any filter is applied..
        updateSortOptions: function () {

            var hash = ListingPage.controller.getURLHash();

            $("#sorting_options ul li a").each(function (i, v) {
                var href = $(this).attr('href').split("#")[0];
                $(this).attr('filters', "#" + hash);
            });
        },
        // Caching the applied filter for fast processing..
        localCache: {
            data: {},
            remove: function (url) {
                delete this.data[url];
            },
            exist: function (url) {
                return this.data.hasOwnProperty(url) && this.data[url] !== null;
            },
            get: function (url) {
                // console.log('Getting in cache for url' + url);
                return this.data[url];
            },
            set: function (url, cachedData, callback) {
                this.remove(url);
                this.data[url] = cachedData;
                if ($.isFunction(callback)) callback(cachedData);
            }
        },
        // List of all the Events on Product Listing Page.
        registerEvents: function () {

            m = ListingPage.model;

            $(document).on("click", "#apply_filter", function () {

                if (Object.keys(ListingPage.model.fields).length > 0 || Object.keys(ListingPage.controller.getFilterFields()).length > 0) {
                    ListingPage.model.vars.current_page = 0;
                    ListingPage.controller.setupFilterURL();
                    ListingPage.controller.filterChanged();
                }

                $("#applyfilter").toggleClass('active');
            });

            //Any Filter input field change.
            $(document).on("change", ".changed_filter", function () {
                target = target.replace('-{page?}', '');
                target = target.replace('-{page}', '');
                target = target.replace('{page?}', '');
                target = target.replace('{page}', '');


                var id = $(this).attr('id');

                if (( id == 'maxPrice' && $(this).val() <= pro_max ) || ( id == 'minPrice' && $(this).val() >= pro_min ) || !$(this).is("[type='number']")) {
                    ListingPage.model.vars.current_page = 0;
                    ListingPage.controller.setupFilterURL();
                    ListingPage.controller.filterChanged();
                }
                else {
                    if (id == 'maxPrice') {
                        $(this).val(pro_max);
                    }
                    else {
                        $(this).val(pro_min);
                    }
                }
            });

            //Price slider changes..
            /*$("#price-range").slider({
                range: true,
                min: m.vars.min_price,
                max: m.vars.max_price,
                animate: "slow",
                values: [m.vars.min_price, m.vars.max_price],
                change: function (event, ui) {
                    var sMinPrice = ui.values[0];
                    var sMaxPrice = ui.values[1];

                    if (!ListingPage.model.manual_slide) {
                        $("#minPrice").val(sMinPrice);
                        $("#maxPrice").val(sMaxPrice);
                        $("#minPrice").change();
                    }
                },
                slide: function (event, ui) {

                    var sMinPrice = ui.values[0];
                    var sMaxPrice = ui.values[1];
                    $("#minPrice").val(sMinPrice);
                    $("#maxPrice").val(sMaxPrice);
                },
                start: function (event, ui) {
                    ListingPage.model.manual_slide = false;
                }
            });*/
            // Removes the applied filter..
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

                    el = $('input[value="' + val + '"]');
                    el.prop("checked", false);
                    $('#c5r').prop("checked", true);
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

            $(document).on('click', '#load-more', function () {
                ListingPage.controller.getNextPage();
                return false;
            });

            //Clear all the filters..
            $(document).on("click", "#clear-all", function () {

                $(".fltr__src").each(function () {

                    key = $(this).attr("field");

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

                            /*$("#price-range").slider({
                                values: [ListingPage.model.vars.min_price, ListingPage.model.vars.max_price]
                            });*/

                            ListingPage.model.manual_slide = false;
                        }
                    }
                    else if (key == 'sort') {
                        if ($(this).val() == "") {
                            $(this).prop("checked", true);
                        }
                        else {
                            $(this).prop("checked", false);
                        }
                    }
                });

                ListingPage.model.vars.current_page = 0;
                ListingPage.controller.filterChanged()
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

            $('#sorting_options .fltr__src').on('change', function (e) {
                ListingPage.controller.filterChanged();
            });
        },

        setMaxMinPrice: function () {
            ListingPage.model.vars.max_price = pro_max;
            ListingPage.model.vars.min_price = pro_min;
        },

        functions: {
            // Adds overlay to the document once any filter is applied or removed..
            "addOverlay": function () {

                var overlay = '<div class="overlay_list" id="overlay_list" style="display:none"><div class="loader center"><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div><div class="loader--dot"></div></div></div>';
                $('body').append(overlay);
            },
            //Show and hide the Overlay for loading the filter.
            'overlay': {

                'show': function () {

                    $('html, body').animate({
                        scrollTop: $("#product_wrapper").offset().top
                    }, 800);

                    $("#overlay_list").fadeIn();
                },
                'hide': function () { $("#overlay_list").fadeOut() },
            },
        },
    },
}

$(document).ready(function () {

    //Initializing the Product List JS filter functionality..
    ListingPage.controller.init();
});

function filterHtml(section, arr) {
    var tpl = '<div class="checkbox ' + section + '">';
    tpl += '<label class="fix-slide-checkbox">';
    tpl += '<input type="checkbox" value="{KEY}" id="chk{CLEAN_KEY}" class="fltr__src" field="' + section + '">'
    tpl += '<span class="value">{UCKEY}&nbsp;</span>'
    tpl += '<span class="count">[{DOC_COUNT}]</span>'
    tpl += '</label></div>';

    var html = "";

    $.each(arr, function (i, ar) {

        sec_html = tpl;
        sec_html = sec_html.replace("{KEY}", ar.key);
        sec_html = sec_html.replace("{CLEAN_KEY}", clean(ar.key));
        sec_html = sec_html.replace("{UCKEY}", ucfirst(ar.key));
        sec_html = sec_html.replace("{DOC_COUNT}", ar.doc_count);

        html += sec_html;
    });

    $("#" + section + "-wrapper .nano-content").html(html).hide().fadeIn();
    // $(".nano").nanoScroller({ alwaysVisible: true });
}

function sortNMerge(arr1, arr2, brand_arr) {
    var keys = [];
    var result = [];
    j = 0;

    $.each(brand_arr, function (i, val) {

        result[j] = val;
        keys[j++] = val.key;
    });

    $.each(arr1, function (i, val) {

        if ($.inArray(val.key, keys) == -1) {
            result[j] = val;
            keys[j++] = val.key;
        }
        else {
            key = $.inArray(val.key, keys)
            result[key].doc_count = val.doc_count;
        }
    });

    $.each(arr2, function (i, val) {

        if ($.inArray(val.key, keys) == -1) {
            val.doc_count = 0;
            result[j++] = val;
        }
    })

    // result.sort(function(a, b) {
    //     return b.doc_count - a.doc_count;
    // })

    return result;
}
function decode(s) {
    s.replace("&amp;", "&");
    return s;
}
