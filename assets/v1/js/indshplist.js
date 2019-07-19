var $ = jQuery,
    timerInterval;
var ListPage = {
    "settings" : {
        "filterLength" : 8
    },
    "controller" : {
        "init" : function () {
            var lp_changes = ListPage.model.params.changes,
                lp_defaults = ListPage.model.params.defaults,
                lp_current = ListPage.model.params.current,
                lp_page = ListPage.model.params.page,
                lp_clipboard = ListPage.model.clipboard;

            // get page params and default values to get default filters to be applied.
            ListPage.controller.getDefaults();
            
            ListPage.controller.updatePage();

            // Add listeners to all inputs for applying or removing filters
            ;(function addActionListeners() { //alert(21);
                var filterGroupQueue = [],
                    listenerTypes = [
                        ".fltr:not([data-groupname='price']) .js-fltr-val--mltpl input:not([disabled])",
                        ".fltr:not([data-groupname='price']) .js-fltr-val--sngl input:not([disabled])",
                        ".fltr[data-groupname='price'] .js-fltr-val--sngl input:not([disabled])"
                    ];

            
                // globalSearch is comes from from hash so no listener.

                // localSearch within the loaded product list
                $('.list-hdr-srch').on('submit', function () {
                    var localSearch = $.trim($(this).find('.list-hdr-srch__fld').val());
                    if (localSearch !== "") {
                        lp_changes.add.ss = localSearch;
                    } else if (lp_clipboard.prevLocalSearch) {
                        lp_changes.remove.ss = lp_clipboard.prevLocalSearch;
                    } else {
                        return false;
                    }

                    lp_changes.inFilterBox = false;
                    ListPage.controller.updatePage();
                    return false;
                });

                $('.concent_search').on("click", function () {
					//alert(49);
				});
                $('.list-hdr-srch__btn').on("click", function () {
					//alert(1);
                    $('.list-hdr-srch').submit();
                });

                // onclick a non-price multi value filter.
                $doc.on("click", ".fltr:not([data-groupname='price']) .js-fltr-val--mltpl input:not([disabled])", function () {
                    var groupName = $(this).closest(".fltr").data("groupname");

                    if (filterGroupQueue.length === 0) {
                        $.merge(filterGroupQueue, $(this));
                    }
                    $(filterGroupQueue).each(function (i, item) {
                        var context = (!lp_current.property || lp_current.property.indexOf($(item).attr("value")) === -1) ? "add" : "remove",
                            changes = lp_changes[context];
                        
                        changes.property = changes.property || [];
                        changes.property.push($(item).attr("value"));
                    });
                    filterGroupQueue = [];

                    lp_changes.inFilterBox = true;
                    ListPage.controller.updatePage();
                });
                
                // onclick a non-price single value filter.
                $doc.on("click", ".fltr:not([data-groupname='price']) .js-fltr-val--sngl input:not([disabled])", function () {
                    var groupName = $(this).closest(".fltr").data("groupname");
                    if (filterGroupQueue.length === 0) {
                        $.merge(filterGroupQueue, $(this).closest(".fltr").find(".fltr-val__inpt:checked"));
                    }
                    $(filterGroupQueue).each(function (i, item) {
                        var context = lp_current[groupName] !== $(item).attr("value") ? "add" : "remove",
                            changes = lp_changes[context];
                        
                        changes.property = changes.property || [];
                        changes.property.push($(item).attr("value"));
                    });
                    filterGroupQueue = [];

                    lp_changes.inFilterBox = true;
                    ListPage.controller.updatePage();
                });
                
                // onclick a price single value filter.
                $doc.on("click", ".fltr[data-groupname='price'] .js-fltr-val--sngl input:not([disabled])", function () {
                    var filterVal = $(this).attr("value"),
                        values = filterVal.split(";"),
                        minPrice = parseInt(values[0], 10),
                        maxPrice = parseInt(values[1], 10),
                        context = (lp_current.price !== $(this).attr("value")) ? "add" : "remove",
                        displayPrices = {};
                    
                    $.extend(lp_changes[context], {
                        "price" : minPrice + ";" + maxPrice
                    });

                    lp_changes.inFilterBox = true;
                    ListPage.controller.updatePage();
                });
                
                // clear all applied filters in a filter group
                $doc.on("click", ".fltr__cler", function () {
                    var $currentGroup = $(this).closest(".fltr"),
                        groupname = $currentGroup.data("groupname"),
                        $activeFilters = $currentGroup.find(".fltr-val__inpt:checked");
                    if (groupname === "price") {
                        $.extend(lp_changes.remove, {
                            "price" : lp_clipboard.prevMinPrice + ";" + lp_clipboard.prevMaxPrice
                        });

                        lp_changes.inFilterBox = true;
                        ListPage.controller.updatePage();
                    } else {
                        $.merge(filterGroupQueue, $currentGroup.find("input:checked"));
                        $activeFilters.eq(0).click();
                    }
                });
                
                // edit min and max price numbers in input field
                $doc.on("change", ".js-fltr-prc__inpt-min, .js-fltr-prc__inpt-max", function () { //alert(66); 
                    var numRegEx = /^[0-9]+$/,
                        $minPriceInpt = $(".js-fltr-prc__inpt-min"),
                        $maxPriceInpt = $(".js-fltr-prc__inpt-max"),
                        minPrice = $minPriceInpt.val(),
                        maxPrice = $maxPriceInpt.val(),
                        lp_clipboard = ListPage.model.clipboard;

                    if (numRegEx.test(minPrice) && numRegEx.test(maxPrice)) {
                        minPrice = parseInt(minPrice, 10);
                        maxPrice = parseInt(maxPrice, 10);
                        if (minPrice < maxPrice) {
                            if (minPrice < lp_defaults.priceMin) {
                                minPrice = lp_defaults.priceMin;
                                $minPriceInpt.val(minPrice);
                            }
                            if (maxPrice > lp_defaults.priceMax) {
                                maxPrice = lp_defaults.priceMax;
                                $maxPriceInpt.val(maxPrice);
                            }
                            if (minPrice !== lp_defaults.priceMin || maxPrice !== lp_defaults.priceMax) {
                                // if new price range is subset of total range then apply filter
                                $.extend(lp_changes.add, {
                                    "price" : minPrice + ";" + maxPrice
                                });
                            } else {
                                // if new price range is total range then remove existing price filter.
                                $.extend(lp_changes.remove, {
                                    "price" : lp_clipboard.prevMinPrice + ";" + lp_clipboard.prevMaxPrice
                                });
                            }

                            lp_changes.inFilterBox = true;
                            ListPage.controller.updatePage();
                            return;
                        }
                    }
                    $minPriceInpt.val(lp_clipboard.prevMinPrice);
                    $maxPriceInpt.val(lp_clipboard.prevMaxPrice);
                });
                
                ;(function AppliedFilterHandler() { //alert(107);
                    var remfilterQueue = [];
                    function removeAppliedFilters() {
                        var filterVal, $filterItem, minPrice, maxPrice;
                        
                        // batch changes(DOM write operatations ie. to uncheck filters/remove tags) to trigger only one render operation.
                        $.each(remfilterQueue, function (i, filter) {
                            if ($(filter).closest(".js-fltrs-apld").data("groupname") === "searchTerm") {
                                lp_changes.remove.s = $(filter).data("value");
                            } else if ($(filter).closest(".js-fltrs-apld").data("groupname") === "localSearch") {
                                lp_changes.remove.ss = $(filter).data("value");
                            } else if ($(filter).closest(".js-fltrs-apld").data("groupname") === "price") {
                                lp_changes.remove.price = $(filter).data("value");
                            } else {
                                filterVal = $(filter).data("value");
                                $filterItem = $('.fltr-val__inpt[value="' + filterVal + '"]').closest(".fltr-val");
                                
                                if ($filterItem.find(".fltr-val__inpt").is(":not([disabled])")) {
                                    lp_changes.remove.property = lp_changes.remove.property || [];
                                    lp_changes.remove.property.push($filterItem.find("input").attr("value"));
                                }
                            }
                        });
                        remfilterQueue = [];

                        lp_changes.inFilterBox = false;
                        ListPage.controller.updatePage();
                    }

                    // remove applied filter by clicking tags shown above product list.
                    $(".js-fltrs-apld-wrpr1").on("click", ".js-fltrs-apld__item", function removeTag() {
                        $.merge(remfilterQueue, $(this));
                        removeAppliedFilters();
                    });

                    // remove applied filter by clicking tags shown above product list.
                    $(".js-fltrs-apld-wrpr1").on("click", ".js-fltrs-apld__lbl", function removeGroup() {
                        $.merge(remfilterQueue, $(this).closest(".js-fltrs-apld").find(".js-fltrs-apld__item"));
                        removeAppliedFilters();
                    });

                    $(".js-fltrs-apld-wrpr1").on("mouseover", ".js-fltrs-apld__lbl", function () {
                        $(this).closest(".js-fltrs-apld").addClass("js-fltrs-apld--strk");
                    }).on("mouseout", ".js-fltrs-apld__lbl", function () {
                        $(this).closest(".js-fltrs-apld").removeClass("js-fltrs-apld--strk");
                    });

                    $(".js-fltrs-apld-wrpr1").on("click", ".js-fltrs-apld-cler", function removeAll() {
                        $(".js-fltrs-apld__item").each(function () {
                            $.merge(remfilterQueue, $(this));
                        });
                        removeAppliedFilters();
                    });
                }());
               
                // sorting options.
                $doc.on("change", ".change-sort", function () {
                    var sortVal = $(this).val();
                    lp_changes.add.sort = sortVal;

                    lp_changes.inFilterBox = false;
                    ListPage.controller.updatePage();
                });

                $doc.on("change", ".search-field", function () {
                    var fieldVal = $(this).val();
                    lp_changes.add.ss = fieldVal;

                    lp_changes.inFilterBox = false;
                    ListPage.controller.updatePage();
                });
                
                // pagination.
                $doc.on("click",".js-pgntn__item", function () {
                    if (!$(this).hasClass("pgntn__item--crnt")) {
                        var pgno = $(this).data("pgno");
                        lp_changes.add.page = pgno;

                        lp_changes.inFilterBox = false;
                        ListPage.controller.updatePage();
                    }
                    return false;
                });
            }());
        },
        "getDefaults" : function () { 
            var lp_defaults = ListPage.model.params.defaults,
                lp_clipboard = ListPage.model.clipboard,
                pageParams = (function () {
                    var $bodyWrapper = $(".list-main"),
                        params = {},
                        startInr, endInr;
//alert($bodyWrapper.data("brand"));
                    if ($bodyWrapper.data("category")) {
                        params.subcategory = $bodyWrapper.data("category");
                    }
                    if ($bodyWrapper.data("start_price") || $bodyWrapper.data("end_price")){ //alert(256);
                        startInr = parseInt($bodyWrapper.data("start_price") || $(".js-fltr-prc__inpt-min").attr("val"), 10);
                        endInr = parseInt($bodyWrapper.data("end_price") || $(".js-fltr-prc__inpt-max").attr("val"), 10);
                        params.price = startInr + ";" + endInr;
						//alert(params.price);
                    }
                    if ($bodyWrapper.data("brand")) {
                        params.property = params.property || "";
                        params.property += $(".fltr-val__inpt[dispname='" + $bodyWrapper.data("brand") + "']").attr("value") + "|";
						//alert(params.property);
                    }
                    if ($bodyWrapper.data("property")) {
                        params.property = params.property || "";
                        params.property += $bodyWrapper.data("property") + "|";
                    }
                    if ($bodyWrapper.data("properties")) {
                        params.property = params.property || "";
                        params.property += $bodyWrapper.data("properties");
                    }

                    if (params.property) {
                        params.property = $.grep(params.property.split("|").sort(), function (e, i) { return (e !== ""); });
                    }
                    
                    return params;
                }());

            $.extend(ListPage.model.params.page, pageParams);

            // get supported values of min and max price values by the slider.
            $.extend(lp_defaults, {
                "priceMin" : parseInt($(".fltr-prc__sldr").attr("value").split(";")[0], 10),
                "priceMax" : parseInt($(".fltr-prc__sldr").attr("value").split(";")[1], 10)
            });

            // store inital values as previous values when values change.
            $.extend(lp_clipboard, {
                "prevMinPrice" : lp_defaults.priceMin,
                "prevMaxPrice" : lp_defaults.priceMax
            });
        },
        // once changes are update the page state before rendering the view.
        "updatePage" : function () {
            var lp_current = ListPage.model.params.current,
                lp_changes = ListPage.model.params.changes,
                lp_defaults = ListPage.model.params.defaults,
                lp_page = ListPage.model.params.page,
                lp_clipboard = ListPage.model.clipboard,
                lp_services = ListPage.services,
                initHash, prop_strings;

            lp_clipboard.isOnLoad = $.isEmptyObject(lp_current);
                
            // Clear list page deals countdown timer
            clearInterval(timerInterval); 

            if (!lp_clipboard.isOnLoad) {
                //apply additions in current state params
                $.each(lp_changes.add, function (key) { //alert(key);
                    if (key === "property") {
                        if ($.isArray(lp_changes.add.property)) {
                            lp_current.property = $.isArray(lp_current.property) ? lp_current.property : [];
                            $.merge(lp_current.property, lp_changes.add.property);
                        }
                    } else {
                        lp_current[key] = lp_changes.add[key];
                    }
                });
                //apply deletions in current state params
                $.each(lp_changes.remove, function(key) { //alert(key);
                    var index;
                    if (key === "property") {
                        $.each(lp_changes.remove.property, function(i, removedProperty) {
                            index = lp_current.property.indexOf(removedProperty);
                            lp_current.property.splice(index, 1);
                        });
                        if (lp_current.property.length === 0) {
                            delete lp_current.property;
                        }
                    } else {
                        delete lp_current[key];
                    }
                });
            } else {
                // if isOnLoad get current params from url hash.
                $.extend(lp_current, lp_services.filterHash.toParams(window.location.hash));

                ;(function () {
                    var currentLength = 0;
                    $.each(lp_current, function () { currentLength++; });

                    // if no hash or if its a quicklink page inherit page params.
                    if (currentLength === 0 || lp_current.ql === "1") {
                        $.each(lp_page, function (param, pageParamValue) {
                            if ($.isArray(pageParamValue)) {
                                
                                lp_current[param] = $.isArray(lp_current[param]) ? lp_current[param] : [];
                                
                                $.each(pageParamValue, function(i, prop) {
                                    if (lp_current[param].indexOf(prop) === -1) {
                                        lp_current[param].push(prop);
                                    }
                                });
                            } else {
                                lp_current[param] = pageParamValue;
                            }
                        });
                        delete lp_current.ql;
                    }

                    // since every registered params on current is new add them to changes also.
                    $.each(lp_current, function (key) {
                        lp_changes.add[key] = lp_current[key];
                    });
                }());
                
                lp_current.subcategory = lp_current.subcategory || lp_page.subcategory;
                lp_clipboard.isLoadParamsEqualtoPageParams = (ListPage.services.filterHash.fromParams(lp_current) === ListPage.services.filterHash.fromParams(lp_page));

                ListPage.view.init();
            }
            
            //generate new hash, and start view rendering.
            ListPage.model.hash = ListPage.services.filterHash.fromParams(lp_current);
            ListPage.view.render();
        }
    },
    "model" : {
        "hash" : "",
        "params" : {
            "current" : {},
            /* {
                "s" : "", //globalSearch
                "ss" : "", //localSearch
                "subcategory" : "",
                "price" : startInr + ";" + endInr,
                "property" : [],
                "sort" : "",
                "page" : "" //pagination no
            } */
            "changes" : {
                "add" : {},
                "remove" : {},
            },
            "page" : {},
            "defaults" : {}
        },
        // mode of tranferring valued from one component(M, V, C) to another.
        "clipboard" : {
            "prevMinPrice" : "",
            "prevMaxPrice" : "",
            "slider" : {},
            "prevLocalSearch" : ""
        }
    },
    "view" : {
        "init" : function () {
            var lp_current = ListPage.model.params.current,
                lp_defaults = ListPage.model.params.defaults;

            ListPage.view.filterPlugins.init({
                "priceSlider" : {
                    "min" : lp_current.price ? lp_current.price.split(";")[0] : lp_defaults.priceMin,
                    "max" : lp_current.price ? lp_current.price.split(";")[1] : lp_defaults.priceMax
                }
            });
        },
        "render" : function () { 
            var lp_current = ListPage.model.params.current,
                lp_changes = ListPage.model.params.changes,
                lp_defaults = ListPage.model.params.defaults,
                lp_page = ListPage.model.params.page,
                lp_clipboard = ListPage.model.clipboard,
                lp_filterPlugins = ListPage.view.filterPlugins,
                filterControls;
            
            window.location.hash = ListPage.model.hash;
            
          /*  if (lp_clipboard.isOnLoad) {
                $(".list-main__ttl, .list-info__dscrptn, .list-info__link-wrpr").show();
            }
            if (ListPage.services.filterHash.fromParams(lp_current) !== ListPage.services.filterHash.fromParams(lp_page)) {
                $(".list-main__ttl, .list-info__dscrptn, .list-info__link-wrpr").hide();
                $(".js-list-ttl").html($(".list-info__ttl").html());
            }*/

            ;(function updateProductListAndOtherWidgets() {
                var lp_changes = $.extend({}, ListPage.model.params.changes),
                    lp_current = $.extend({}, ListPage.model.params.current),
                    loadingMaskHtml = ListPage.view.components.loadingMask(),
                    loadingStart = +new Date();
//alert(447);
                // get new product list and filters based on updated current params
                if ($(".container").length !== 0) {

                    if (!(lp_clipboard.isOnLoad && lp_clipboard.isLoadParamsEqualtoPageParams)) {
                    //    if($(".js-fltr-ldng-mask").length !== 0)						
                           // $(".js-prdct-grid-wrpr").append(loadingMaskHtml);
                            $(".list-product-panel").append(loadingMaskHtml);
                    }
//alert(455);
                    ListPage.services.fetch.productList(lp_current).done(function (response) {
						//alert("458");
						//console.log(response);
                        var freshData = response.split("//&//#"),
                            lp_filterPlugins = ListPage.view.filterPlugins;

                        ListPage.model.params.current.page = undefined;

                        if (lp_changes.inFilterBox) {
                            // manipulate loaded filter html
                            var $newFilterBox = $(freshData[0]),
                                $groupsToReplace, 
                                replacedGroups = [];

                            $groupsToReplace = (function () {
                                var affectedGroups = (function () {
                                    var result = [];
                                    $.each(["add", "remove"], function (i, context) {
                                        if ("price" in lp_changes[context]) {
                                            result.push("price");
                                        }
                                        if ("property" in lp_changes[context]) {
                                            $.each(lp_changes[context].property, function(i, propValue) {
                                                var groupname = $(".fltr-val[value='" + propValue + "']").closest(".fltr").data("groupname");
                                                result.push(groupname);
                                            });
                                        }
                                    });
                                    return result;
                                }());
                                
                                return $newFilterBox.find(".fltr").filter(function () {
                                    return affectedGroups.indexOf($(this).data("groupname")) === -1;
                                });
                            }());

                            $groupsToReplace.each(function () {
                                var $newFilterBlock = $(this),
                                    groupname = $newFilterBlock.data("groupname"),
                                    $exisingFilterBlock = $(".fltr[data-groupname='" + groupname + "']");
                                replacedGroups.push(groupname);
                                $exisingFilterBlock.replaceWith($newFilterBlock);
                            });

                            lp_filterPlugins.init({
                                "priceSlider" : {
                                    "min" : lp_clipboard.slider.priceMin,
                                    "max" : lp_clipboard.slider.priceMax
                                }
                            }, replacedGroups);
                        } else {
                            // load new filters
							//alert(507);
                            $(".fltr-wrpr1").html(freshData[0]);
                            lp_filterPlugins.init({
                                "priceSlider" : {
                                    "min" : lp_clipboard.slider.priceMin,
                                    "max" : lp_clipboard.slider.priceMax
                                }
                            });
                        }

                        if (!lp_clipboard.isLoadParamsEqualtoPageParams) {
                            // load new products
                            $(".list-product-panel").html(freshData[1]);
                            $("#pagination").html(freshData[2]);
                            $(".pageto").text($(".productStat").data('count'));
                            $(".prodtotal").text($(".productStat").data('total'));
                        } else {
                            lp_clipboard.isLoadParamsEqualtoPageParams = false;
                        }
                    }).always(function () {
                          var loadingTime = +new Date() - loadingStart,
                            loadingMaskDelay = (loadingTime < 250) ? (250 - loadingTime) : 0;
                            ProductList.initGrid();                        
                      setTimeout(function () {
                            $(".loadwaiting").remove();
                        }, loadingMaskDelay);
                    });
                }

        
            }());

            // operations to be done to add/remove filters.
            filterControls = {
                "add" : function () {  //alert(543);
                    var $filterGroupOptions,
                        appliedFilterComponents = ListPage.view.components.appliedFilter;
                    
                    // initialize all filtergroups, cleargroups as inactive and activate based on current params
                    $(".fltr__cler").removeClass("fltr__cler--show");
                    //$('.fltr__val').removeClass('active');
                    
                    // apply all filters registered on filterControls.add.queue
                    $.each(filterControls.add.queue, function (i, filterItem) { //alert(filterItem.unitValue);
                        // batch html of all the filters to append all filter tags in one go.
                        if ("unitValue" in filterItem) { 
                            $filterGroupOptions = $(".fltr[data-groupname='" + filterItem.groupName + "'] .fltr-val__inpt");
                            if ($filterGroupOptions.closest(".fltr-val").hasClass("js-fltr-val--sngl") || filterItem.groupName == "localSearch"  || filterItem.groupName == "price") {
                                $(".js-fltrs-apld[data-groupname='" + filterItem.groupName + "']").remove();
                            }
                            $filterGroupOptions.filter("[value='" + filterItem.unitValue + "']").prop("checked", true);
                            setTimeout(function () {
                                $(".fltr[data-groupname='" + filterItem.groupName + "']").find(".fltr__cler").addClass("fltr__cler--show");
                            }, 0);
                        }
                        if (filterItem.groupName == "price") { 
                            // update priceSlider range points
                            $(".fltr-prc__sldr").slider("values", [
                                lp_filterPlugins.priceSlider.priceToRange(filterItem.unitValue.split(";")[0]),
                                lp_filterPlugins.priceSlider.priceToRange(filterItem.unitValue.split(";")[1])
                            ]);
                            $(".js-fltr-prc__inpt-min").val(filterItem.unitValue.split(";")[0]);
                            $(".js-fltr-prc__inpt-max").val(filterItem.unitValue.split(";")[1]);
                        }
						//alert(547);
                        // batch html of all the filters to append all filter tags in one go.
                        if ($(".js-fltrs-apld[data-groupname='" + filterItem.groupName + "']").length !== 0) {
                            $(".js-fltrs-apld[data-groupname='" + filterItem.groupName + "']").append(appliedFilterComponents.unit(filterItem));
                        } else {
                            $(".js-fltrs-apld-wrpr").append(appliedFilterComponents.group(filterItem));
                        }
                    });
                    
                    if (filterControls.add.queue.length !== 0) {
                        $(".js-fltrs-apld-wrpr1").show();

                        ;(function showFollowThisSearchButton() { //alert(556);
                            var subcatName = $('.body-wrpr').data('listname'),
                                subcatCode = $('.body-wrpr').data('listcode'),
                                filterHash = encodeURIComponent(location.hash),
                                hrefVal = "../../promotions/savesearchpopup.php?subcatname="+encodeURIComponent(subcatName)+"&subcatcode="+encodeURIComponent(subcatCode)+"&filterhash="+filterHash;
                            $(".list-hdr__save").data("href", hrefVal).show();
                        }());
                    }
                },
                "remove" : function () {
                    // remove all filters registered on filterControls.remove.queue
                    $.each(filterControls.remove.queue, function (i, filterItem) {
                        var $remfilterGrp = $(".js-fltrs-apld[data-groupname='" + filterItem.groupName + "']"),
                            $remfilterUnit = $remfilterGrp.find(".js-fltrs-apld__item[data-value='" + filterItem.unitValue + "']"),
                            $filterOption = $(".fltr-val__inpt[value='" + filterItem.unitValue + "']");

                        if ($remfilterGrp.find(".js-fltrs-apld__item").length === 1) {
                            $remfilterGrp.remove();
                        } else {
                            $remfilterUnit.remove();
                        }

                        // FIXME:: on clearing --multi filter block first item remains selected
                        // -> setTimeout is a temporary fix to do unchecking after handler is executed.
                        setTimeout(function () {
                            $filterOption.prop("checked", false);

                            if ($filterOption.closest(".fltr").find(".fltr-val__inpt:checked").length === 0) {
                                $filterOption.closest(".fltr").find(".fltr__cler").removeClass("fltr__cler--show");
                            }
                        }, 0);
                        
                        if (filterItem.groupName === "price") {
                            // update priceSlider range points
                            $(".fltr-prc__sldr").slider("values", [ 0, 200 ]);
                            $(".js-fltr-prc__inpt-min").val(lp_defaults.priceMin);
                            $(".js-fltr-prc__inpt-max").val(lp_defaults.priceMax);
                        }
                    });

                    // if all filter tags removed remove "clear all" filter tag also
                    if ($(".js-fltrs-apld").length === 0) {
                        $(".js-fltrs-apld-wrpr1").hide();
                        $(".list-hdr__save").hide();
                    }
                }
            };
            
            // after all filters added/removed reinitialize queue to empty.
            filterControls.add.queue = [];
            filterControls.remove.queue = [];
            
            // register all filter changes to filterControls queue to batch applying and removing operations.
            $.each(["add", "remove"], function (i, action) { //alert(i+","+action);
                if ("s" in lp_changes[action]) {
                    $(".js-hdr-srch").val(lp_changes[action].s);
                    filterControls[action].queue.push({
                        "unitValue" : lp_changes[action].s,
                        "unitLabel" : lp_changes[action].s,
                        "groupName" : "searchTerm",
                        "groupLabel" : "Search"
                    });
                }
                if ("s" in lp_changes[action]) {
                    $(".search-field").val(lp_changes[action].s);
                    filterControls[action].queue.push({
                        "unitValue" : lp_changes[action].s,
                        "unitLabel" : lp_changes[action].s,
                        "groupName" : "searchTerm",
                        "groupLabel" : "Search"
                    });
                }
                if ("sort" in lp_changes[action]) {
                    $('.change-sort option[value="' + lp_changes[action].sort + '"]').attr("selected", "selected");
                }
                if ("ss" in lp_changes[action]) {
                    $(".list-hdr-srch__fld").val(lp_current.ss);
                    filterControls[action].queue.push({
                        "unitValue" : lp_changes[action].ss,
                        "unitLabel" : lp_changes[action].ss,
                        "groupName" : "localSearch",
                        "groupLabel" : "List Search"
                    });
                }
                if ("price" in lp_changes[action]) { //alert(lp_changes[action].price);
                    ;(function () {
                        var startInr = lp_changes[action].price.split(";")[0],
                            endInr = lp_changes[action].price.split(";")[1],
                            unitValue = lp_changes[action].price,
                            unitLabel = startInr.toLocaleString() + "-" + endInr.toLocaleString(),
                            minSlider, maxSlider;
                        
                        filterControls[action].queue.push({
                            "unitValue" : unitValue,
                            "unitLabel" : unitLabel,
                            "groupName" : 'price',
                            "groupLabel" : 'price'
                        });

                        // if price filter is to be added update slider values to new values
                        if (action === "add") {
                            lp_clipboard.slider.priceMin = startInr;
                            lp_clipboard.slider.priceMax = endInr;
                        // if price filter is to be removed update slider values to min and max values.
                        } else {
                            lp_clipboard.slider.priceMin = lp_defaults.priceMin;
                            lp_clipboard.slider.priceMax = lp_defaults.priceMax;
                        }
                    }());
                }
                if ("property" in lp_changes[action]) {
                    $.each(lp_changes[action].property, function (i, value) {
                        var $filterItem = $('.fltr-val__inpt[value="'+ value +'"]'),
                            unitValue = value,
                            unitLabel = $filterItem.attr("dispname"),
                            groupName = $filterItem.closest(".fltr").data("groupname"),
                            groupLabel = $.trim($filterItem.closest(".fltr").find(".fltr__ttl").text());

                        filterControls[action].queue.push({
                            "unitValue" : unitValue,
                            "unitLabel" : unitLabel,
                            "groupName" : groupName,
                            "groupLabel" : groupLabel
                        });
                    });
                }
            });
            
            $.each(["add", "remove"], function (i, action) {
                if (filterControls[action].queue.length) {
                    filterControls[action]();
                }
            });
            
            $.extend(lp_clipboard, {
                "prevMinPrice" : lp_current.price ? lp_current.price.split(";")[0] : lp_defaults.minPrice,
                "prevMaxPrice" : lp_current.price ? lp_current.price.split(";")[1] : lp_defaults.maxPrice,
                "prevLocalSearch" : lp_current.ss || ""
            });

            // after all changes reflected in the view re-initialize changes to empty.
            $.extend(lp_changes, {
                "add" : {},
                "remove" : {}
            });
        },
        "filterPlugins" : {
            "init" : function (settings, replacedGroups) {
				ListPage.view.filterPlugins.nanoScrollbarInit(replacedGroups);
				ListPage.view.filterPlugins.priceSlider.init(settings.priceSlider, replacedGroups);
            },
            "priceSlider" : {
                "init" : function(settings, replacedGroups) { 
                    var minPrice = settings.min,
                        maxPrice = settings.max,
                        minSlider = minPrice ? this.priceToRange(minPrice) : 0,
                        maxSlider = maxPrice ? this.priceToRange(maxPrice) : 200,
                        lp_changes = ListPage.model.params.changes,
                        lp_filterPlugins = ListPage.view.filterPlugins;

                    if ($.isArray(replacedGroups) && replacedGroups.indexOf("price") === -1) {
                        return;
                    }

                    $(".fltr-prc__sldr").slider({
                        "range" : true,
                        "min" : 0,
                        "max" : 200,
                        "values" : [minSlider || 0, maxSlider || 200],
                        "step" : 1,
                        "animate" : true,
                        "slide" : lp_filterPlugins.priceSlider.callback,
                        "stop" : function (a, b) {
                            var startInr, endInr;

                            if (b.values[0] === 0 && b.values[1] === 200) {
                                startInr = ListPage.model.clipboard.prevMinPrice;
                                endInr = ListPage.model.clipboard.prevMaxPrice;
                                
                                // if range is equal to total range then remove price filter
                                lp_changes.remove.price = startInr + ";" + endInr;
                            } else {
                                startInr = lp_filterPlugins.priceSlider.rangeToPrice(b.values[0]);
                                endInr = lp_filterPlugins.priceSlider.rangeToPrice(b.values[1]);
                                
                                // if range is not equal to total range then add new price filter
                                lp_changes.add.price = startInr + ";" + endInr;
                            }

                            lp_changes.inFilterBox = true;
                            ListPage.controller.updatePage();							
                            $(".fltr-prc__sldr").slider("values", [b.values[0], b.values[1]]);
                        }
                    });

                    if (minPrice || maxPrice) {
                        $(".js-fltr-prc__inpt-min").val(minPrice || ListPage.model.params.defaults.price.split(";")[0]);
                        $(".js-fltr-prc__inpt-max").val(maxPrice || ListPage.model.params.defaults.price.split(";")[1]);
                    }
                },
                // get price value from slider range value
                "rangeToPrice" : function (a) {	//alert(749);
                    var priceMin = ListPage.model.params.defaults.priceMin,
                        priceMax = ListPage.model.params.defaults.priceMax,
                        b = Math.exp(Math.log(priceMax / priceMin) / 200),
                        priceValue = priceMin * Math.pow(b, a),
                        roundOff = Math.pow(10, Math.floor(Math.log(priceValue - (priceValue / b)) / Math.log(10)));
                    
                    priceValue = Math.ceil(priceValue / roundOff) * roundOff;
                    if (a === 0 || priceValue < priceMin) return priceMin;
                    else if (a == 200 || priceValue > priceMax) return priceMax;
                    else return priceValue;
                },
                // get slider range from price value
                "priceToRange" : function (price) { //alert(762);
                    var result = (function binarySearch(a, fn, min, max) {
                        binarySearch.old = binarySearch.current;
                        binarySearch.current = Math.floor((min + max)/2);
                        if (binarySearch.old === binarySearch.current) {
                            return binarySearch.current;
                        }
                        if (a > fn(binarySearch.current)) {
                            min = binarySearch.current;
                        } else if (a < fn(binarySearch.current)) {
                            max = binarySearch.current;
                        } else {
                            return binarySearch.current;
                        }
                        return binarySearch (a, fn, min, max);
                    }(price, ListPage.view.filterPlugins.priceSlider.rangeToPrice, 0, 200));
                    return result;
                },
                // run this function while sliding the price slider.
                "callback" : function (a, b) {
                    var minPrice, maxPrice;
                    if ((b.values[0] + 1) >= b.values[1]) {
                        return false;
                    }
                    minPrice = ListPage.view.filterPlugins.priceSlider.rangeToPrice(b.values[0]);
                    maxPrice = ListPage.view.filterPlugins.priceSlider.rangeToPrice(b.values[1]);
                    $(".js-fltr-prc__inpt-min").val(minPrice);
                    $(".js-fltr-prc__inpt-max").val(maxPrice);
                },
            },
            // init nanoscrollbar plugin to get overflow scroll to filterGroups
           "nanoScrollbarInit" : function(filterGroups) {
			   
                var $nanoElements;

                if (filterGroups) {
                    $nanoElements = $(".fltr-val-wrpr.nano").filter(function () {
                        return filterGroups.indexOf($(this).closest(".fltr").data("groupname")) !== -1;
                    });
                } else {
                    $nanoElements = $(".fltr-val-wrpr.nano");
                }
//console.log($nanoElements);
                $nanoElements.each(function () { //alert(834);
                    var totalHeight;
                    $filteritem = $(".fltr-val", $(this));
					//alert($filteritem.length);
					//alert(ListPage.settings.filterLength);
                    if ($filteritem.length <= ListPage.settings.filterLength) {
                        totalHeight = 0;
                        $filteritem.each(function () {
                            totalHeight += $(this).outerHeight(true);
                        });
						
                        if (totalHeight < 224) $(this).css("height", totalHeight + 'px');
                    }
					
                });
                $nanoElements.nanoScroller({"alwaysVisible" : true});
            },
        },
        "components" : {
            "appliedFilter" : {
                "group" : function (filterItem) {
                    return [
                        '<div class="js-fltrs-apld" data-groupname="' + filterItem.groupName + '">',
                            '<div class="js-fltrs-apld__lbl">' + filterItem.groupLabel + ':</div>',
                            this.unit(filterItem),
                        '</div>'
                    ].join("");
                },
                "unit" : function (filterItem) {
                    return [
                        '<div class="js-fltrs-apld__item" data-value="' + filterItem.unitValue + '">',
                            '<span class="js-fltrs-apld__item-label">' + filterItem.unitLabel + '</span>',
                            '<img class="js-fltrs-apld__item-cler" src="http://doypaxk1e2349.cloudfront.net/icons/cross-grey-small.png"/>',
                        '</div>'
                    ].join("");
                }
            },
            "loadingMask" : function () {
                return [
                    '<div class="loadwaiting">',                        
							'<div class="loader">',
								'<div class="loader--dot"></div>',                           
								'<div class="loader--dot"></div>',                           
								'<div class="loader--dot"></div>',                           
								'<div class="loader--dot"></div>',                           
								'<div class="loader--dot"></div>',                           
								'<div class="loader--dot"></div>',                           
                        '	</div>',                       
                    '</div>'
                ].join("");
            }
        }
    },
    "services" : {
        "filterHash" : {
            "toParams" : function (filterHash) {	//alert(883);
                var params = {},
                    prop_strings = decodeURIComponent(filterHash).replace("#", "").split("&");

                if (prop_strings[0] !== "") {
                    $.each(prop_strings, function (i, prop_string) {
                        params[prop_string.split("=")[0]] = prop_string.split("=")[1];
                    });
                    
                    if ("property" in params) {
                        params.property = $.grep(params.property.split("|").sort(), function (e, i) {
                            return (e !== "");
                        });
                    }
                    
                    if (params.minprice !== params.priceMin || params.maxprice !== params.priceMax) {
                        params.price = parseInt(params.minprice, 10) + ";" + parseInt(params.maxprice, 10);
                    }

                    delete params.minprice;
                    delete params.maxprice;
                }

                return params;
            },
            "fromParams" : function (params) {	//Pushing to URL
                var filterHash, hashParams = [];
                
                $.each(params, function (key) {
                    var value;
                    if (params[key]) {
                        if (key === "price") {
                            hashParams.push("minprice=" + params[key].split(";")[0]);
                            hashParams.push("maxprice=" + params[key].split(";")[1]);
                        } else if (key === "property") {
                            hashParams.push(key + "=" + params[key].join("|"));
                        } else {
                            hashParams.push(key + "=" + params[key]);
                        }
                    }
                });

                filterHash = "#" + hashParams.join("&");

                return filterHash;
            }
        },
        "fetch" : {
            // generate query from all the new page state params
            "apiQuery" : function (params) {
                return [
                    "subcategory=" + params.subcategory,
                    params.s ? ("&s=" + params.s) : "",
                    params.property ? ("&property=" + params.property.join("|")) : "",
                    params.price ? ("&saleprice_min=" + params.price.split(";")[0]) : "",
                    params.price ? ("&saleprice_max=" + params.price.split(";")[1]) : "",
                    params.sort ? ("&sort=" + params.sort) : "",
                    params.ss ? ("&ss=" + params.ss) : "",
                   // params.smax ? ("&smax=" + params.smax) : "",
                   // params.smin ? ("&smin=" + params.smin) : "",
                    params.page ? ("&page=" + params.page) : ""
                ].join("");
            },
            "productList" : INDSHP.utils.memoize(function (currentParams) { //alert(944);
                var dfd = $.Deferred(),
                    query = this.apiQuery(currentParams),
                    _productList = ListPage.services.fetch.productList;
				if(jQuery('input[name="smin"]').size)
					query += "&smin="+jQuery('input[name="smin"]').val();
				if(jQuery('input[name="smax"]').size)
					query += "&smax="+jQuery('input[name="smax"]').val();
				if(jQuery('input[name="grp"]').size)
					query += "&grp="+jQuery('input[name="grp"]').val();
                if(jQuery('input[name="sfield"]').size)
                    query += "&query="+jQuery('input[name="sfield"]').val();
				
				
                if (_productList.XHR) _productList.XHR.abort();
				console.log(query);
                _productList.XHR = $.ajax({ 
			         url: ($('.list-main').length ? '/indiashopps_new/productfilter?' : '/search/search_new.php?') + query       
                }).done(function (response) {
                    dfd.resolve(response);
                }).fail(function (error) {
                    dfd.reject(error);
                });

                return dfd.promise();
            }, {
                "cacheLimit" : 15
            }),
            // hourly deals ajax loading
            "hourlyDeals" : INDSHP.utils.memoize(function (currentParams) {
                var dfd = $.Deferred(),
                    query = this.apiQuery(currentParams),
                    _hourlyDeals = ListPage.services.fetch.hourlyDeals;

                if (_hourlyDeals.XHR) _hourlyDeals.XHR.abort();

                _hourlyDeals.XHR = $.ajax({
                    "url": "/msp/autodeals/hourly_deals.php?" + query
                }).done(function (response) {
                    dfd.resolve(response);
                }).fail(function (error) {
                    dfd.reject(error);
                });

                return dfd.promise();
            }, {
                "cacheLimit" : 15
            })
        }
    }
};

var ProductList = {
    "initGrid" : function () {
        if (localStorage.getItem("gridType") === "large") {
            this.setGridType("large");
        } else if (localStorage.getItem("gridType") === "small") {
            this.setGridType("small");
        }
        $doc.on("click", ".js-list-hdr-view", function () {
            if ($(this).hasClass("list-hdr-view__prdct-l")) {
                ProductList.setGridType("large");
            } else {
                ProductList.setGridType("small");
            }
        });
    },
    "setGridType" : function (type) {
        $(".list-hdr-view__prdct-l").removeClass("list-hdr-view__prdct-l--slctd");
        $(".list-hdr-view__prdct-s").removeClass("list-hdr-view__prdct-s--slctd");

        if (type === "large") {
            $(".prdct-grid").addClass("prdct-grid--prdct-l");
            $(".list-hdr-view__prdct-l").addClass("list-hdr-view__prdct-l--slctd");
            localStorage.setItem("gridType", "large");
        } else {
            $(".prdct-grid").removeClass("prdct-grid--prdct-l");
            $(".list-hdr-view__prdct-s").addClass("list-hdr-view__prdct-s--slctd"); 
            localStorage.setItem("gridType", "small");
        }
    }
};

// if category is mobile then first show mobile list and then show applied filters list.
if ($("#mobilefilterwrapper").length) { alert(1013);
   /* $.ajax({
        url: "/msp/prop_filters/mobile-new.html"
    }).done(function (response) {
        var data = response.split("//&//#");
        $("#mobilefilterwrapper").html(data[0]);
        ListPage.controller.init();
    });*/
} else {
    ListPage.controller.init();
}
ProductList.initGrid();

// binding other links to filters.
// $(".js-prdct-list").on("click", "#viewallbestsellers", function () {
//  $("#showonlybestsellers").click();
// });

// search in filter groups.
$(".fltr-wrpr1").on("keyup", ".fltr-srch__fld", function () {
    var filterSearchQuery = $.trim($(this).val()),
        $filterGroup = $(this).closest(".fltr");
    if (filterSearchQuery === "") {
        $filterGroup.find(".fltr-val").show();
        $filterGroup.find(".fltr-srch__icon--srch").removeClass("fltr-srch__icon--hide");
        $filterGroup.find(".fltr-srch__icon--cler").addClass("fltr-srch__icon--hide");
        $filterGroup.find(".nano").nanoScroller();
    } else {
        $filterGroup.find(".fltr-val").hide();
        $filterGroup.find(".fltr-srch__icon--srch").addClass("fltr-srch__icon--hide");
        $filterGroup.find(".fltr-srch__icon--cler").removeClass("fltr-srch__icon--hide");
        $filterGroup.find(".fltr-val").filter(function () {
            var itemText = $.trim($(this).text()).toLowerCase(),
                index = itemText.indexOf(filterSearchQuery),
                result = false;
            if (index === 0) {
                result = true;
            } else if (index > 0) {
                if (itemText.toLowerCase().charAt(index - 1) === " ") {
                    result = true;
                }
            }
            return result;
        }).show();
        $filterGroup.find(".nano").nanoScroller();
    }
});

// clear search in filterGroups
$(".fltr-wrpr1").on("click", ".js-fltr-srch__cler", function () {
    var $filterGroup = $(this).closest(".fltr");
    $filterGroup.find(".fltr-srch__fld").val("");
    $filterGroup.find(".fltr-srch__icon").toggleClass("fltr-srch__icon--hide");
    $filterGroup.find(".fltr-val").show();
    $filterGroup.find(".nano").nanoScroller();
});

;(function () {
    $.QueryString = (function (a) {
        if (a === "") return {};
        var b = {};
        for (var i = 0; i < a.length; ++i) {
            var p = a[i].split("=");
            if (p.length != 2) continue;
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
        }
        return b;
    })(window.location.search.substr(1).split("&"));    
}());
