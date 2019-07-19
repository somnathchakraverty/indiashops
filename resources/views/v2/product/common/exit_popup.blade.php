<?php

?>
<div class="col-md-3 popupleftpart">
    <div class="popupofferbox">
        <h3>Best <span>Offers</span></h3>
    </div>
    <div class="popupproductbox">
        <div class="popupprodimg" id="pop_left_product"></div>
        <ul class="listproductpopup" id="pop_left_specs"></ul>
    </div>
</div>
<div class="col-md-9 popuprightpart">
    <h3>Wait! Checkout Best Offers for YOU..</h3>
    <p> Checkout matching products hand picked for you with best prices across all Sites. Try our award winning search
        to find products you want. Try Now ! </p>
    <div class="col-md-12">
        <form class="form_search" id="searchbox" action="http://www.indiashopps.com/search" method="get">
            <div class="input-group MT8">
                <input type="text" required="" name="search_text"
                       class="form-control search-input input-widthpopup auto_search"
                       placeholder="Search Best Prices. Compare Before Your Buy ..." autocomplete="off"
                       onfocus="ga('send', 'event', 'search_focus_popup_comp', 'click');">
                <span class="input-group-btn">
                <button class="btn btn-default search-btn buttonsearchpopupnew" type="submit"
                        onclick="ga('send', 'event', 'search_click_comp_popup', 'click');"> <i class="fa fa-search"
                                                                                               aria-hidden="true"></i> Search </button>
                </span></div>
        </form>
    </div>
    <a href="#" class="left_arrow-popup prev">
        <img src="{{url('assets/v2/images/left_arrow-popup.jpg')}}" alt="arrow">
    </a>
    <a href="#" class="right_arrow-popup next">
        <img src="{{url('assets/v2/images/right_arrow-popup.jpg')}}" alt="arrow">
    </a>
    <div class="col-md-11 popupcarousel" id="popup_suggest">
        @foreach($products as $p)
            <?php $product = $p->_source; ?>
            <div class="item">
                <div class="">
                    <div class="productboxlist">
                        <div class="popupprodimglist">
                            <a href="{{product_url($p)}}" target="_blank"
                               onclick="ga('send', 'event', 'popup_product', 'click');">
                                <img class="proimpolist" src="{{getImageNew($product->image_url,"S")}}"
                                     alt="product-Img" onerror="imgError(this)">
                            </a>
                        </div>
                        <a href="{{product_url($p)}}" target="_blank"
                           onclick="ga('send', 'event', 'popup_product', 'click');"><h5>{{$product->name}}</h5></a>
                        <p><a href="{{product_url($p)}}" target="_blank"
                              class="btn btn-default btn-product btn-productpopup" role="button"
                              onclick="ga('send', 'event', 'popup_product', 'click');">Rs. {{number_format($product->saleprice)}}</a>
                        </p>
                        @if(isset($product->mini_spec))
                            <ul class="alllistproductpopup">
                                {!! getMiniSpec($product->mini_spec,5,'fa fa-check-square readcolornew') !!}
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="col-md-12">
        <div class="input-group MT9" id="subscribe_wrapper">
            <div id="errors" style="display: none" class="label label-danger"></div>
            <div id="success" style="display: none" class="label label-success"></div>
            <input type="text" id="subs_email" name="email" class="form-control search-input input-widthpopup"
                   placeholder="Subscribe to get latest Deals & Promotions" autocomplete="off">
            <span class="input-group-btn">
                <a class="btn btn-default search-btn buttonsearchpopupnew"> <i class="fa fa-envelope"
                                                                               aria-hidden="true"></i> Subscribe </a>
            </span>
        </div>
    </div>
</div>
<style>
    /*THE-POPUP*/
    .MT9 {
        margin: 10px 0px;
    }

    .popupbgcolor {
        margin: 0px;
        padding: 0px;
        overflow: hidden;
        background: url({{url('assets/v2/images/popupbgnew.jpg')}}) top center;
    }

    .popupleftpart {
        background: #fff;
        overflow: hidden;
        margin: 0px;
        padding: 0px;
    }

    .popupleftpart h3 {
        padding: 70px 0px 38px 0px;
        font-size: 24px;
        width: 140px;
        color: #FFFFFF;
        overflow: hidden;
        text-align: center;
        margin: auto;
        text-transform: uppercase;
        transform: rotate3d(1, 2, -1, 192deg);
        transform: rotate(-11deg) scale(1.199) skew(-5deg) translate(2px) !important;
        -webkit-transform: rotate(-11deg) scale(1.199) skew(-5deg) translate(2px) !important;
        -moz-transform: rotate(-11deg) scale(1.199) skew(-5deg) translate(2px) !important;
        -o-transform: rotate(-11deg) scale(1.199) skew(-5deg) translate(2px) !important;
        -ms-transform: rotate(-11deg) scale(1.199) skew(-5deg) translate(2px) !important;
    }

    .popupleftpart span {
        font-size: 35px;
        color: #FFFFFF;
        overflow: hidden;
        text-align: center;
        text-transform: uppercase;
        line-height: 33px;
    }

    .popupproductbox {
        margin-top: 20px;
        padding: 20px 10px;
    }

    .popupprodimg {
        margin: 20px auto;
        padding: 0px;
        width: 100px;
        text-align: center;
    }

    .listproductpopup {
        margin: 0px;
        padding: 0px;
    }

    .listproductpopup li {
        margin: 0px;
        padding: 0px;
        font-size: 12px;
        color: #000000;
        text-decoration: none;
        display: block;
        line-height: 20px;
    }

    .readcolornew {
        color: #e40046;
        margin-right: 6px;
        font-size: 14px;
    }

    .popuprightpart h3 {
        font-size: 25px;
        color: #e40046;
        font-style: italic;
        margin: 20px 0px 10px 0px;
        padding: 0px;
        text-align: center;
        text-transform: uppercase;
        font-weight: bold;
    }

    .popuprightpart p {
        font-size: 14px;
        color: #151515;
        margin: 0px;
        padding: 0px;
        text-align: center;
    }

    .input-widthpopup {
        width: 100% !Important;
        height: 44px;
        margin-top: 10px;
        border-radius: 0px;
        background: #fff;
        outline: none !important;
        color: #e40046;
        border: #000 thin solid;
    }

    .buttonsearchpopupnew {
        background: #e40046 !important;
        border-radius: 0px;
        font-size: 16px;
        outline: none !important;
        margin-top: 10px;
        height: 42px;
    }

    .popupcarousel {
        margin-top: 20px;
    }

    .productboxlist {
        background: #fff;
        border: 3px solid #f6f5f5;
        margin: 10px 0px;
        padding: 10px;
    }

    .proimpolist {
        width: 62px;
        height: auto;
    }

    .popupprodimglist {
        margin: 10px auto;
        padding: 0px;
        width: 100px;
        text-align: center;
        min-height: 130px;
    }

    .productboxlist h5 {
        font-size: 15px;
        color: #2a82d0;
        margin: 0px;
        padding: 0px;
        text-align: center;
    }

    .alllistproductpopup {
        margin-top: 10px;
        padding: 0px;
        min-height: 120px;
    }

    .alllistproductpopup li {
        margin: 0px;
        padding: 0px;
        font-size: 11px;
        color: #000000;
        text-decoration: none;
        display: block;
        line-height: 20px;
    }

    .btn-productpopup {
        margin: 10px 0px;
    }

    .left_arrow-popup {
        position: absolute;
        left: 7px;
        top: 64%;
        cursor: pointer;
        z-index: 9;
    }

    .right_arrow-popup {
        position: absolute;
        right: 7px;
        top: 64%;
        cursor: pointer;
        z-index: 9;
    }

    .popupofferbox {
        background: #e40046;
        margin-top: -40px;
        transform: rotate3d(1, 2, -1, 192deg);
        transform: rotate(11deg) scale(1.199) skew(5deg) translate(2px);
        -webkit-transform: rotate(11deg) scale(1.199) skew(5deg) translate(2px);
        -moz-transform: rotate(11deg) scale(1.199) skew(5deg) translate(2px);
        -o-transform: rotate(11deg) scale(1.199) skew(5deg) translate(2px);
        -ms-transform: rotate(11deg) scale(1.199) skew(5deg) translate(2px);
    }

    .modal-dialog {
        width: auto !important;
        margin: 30px auto;
    }

    .modal-lg {
        width: auto !important;
    }

    .ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front {
        z-index: 1051 !important;
    }

    .input-widthpopup::placeholder {
        color: #e40046
    }
</style>
<script>
    search_box = $("#searchbox .auto_search");

    $("form .auto_search").autocomplete({
        minLength: 2,
        source: completion,
        select: function (event, ui) {
            $("form .auto_search").val(ui.item.label);
            search_box.closest('form').submit();
            return false;
        }
    });
    $(document).ready(function () {
        var owl1 = $("#popup_suggest");

        owl1.owlCarousel({
            items: 3,
            itemsDesktop: [1000, 3],
            itemsDesktopSmall: [900, 2],
            itemsTablet: [600, 2],
            itemsMobile: false,
            autoPlay: true,
            stopOnHover: true,
            scrollPerPage: true,
            paginationSpeed: 200,
        });
        $("#popup_suggest").parent().find(".next").click(function () {
            owl1.trigger('owl.next');
        });
        $("#popup_suggest").parent().find(".prev").click(function () {
            owl1.trigger('owl.prev');
        });

        $(document).on('click', "#subscribe_wrapper .search-btn", function () {
            if ($('#subs_email').val() == '') {
                $('#errors').html('Please enter Your Email to subscribe..').fadeIn().delay(2000).fadeOut();
            }
            else if (ValidateEmail($('#subs_email').val())) {
                $.get(ajax_url + "/ajax-content/subscribe?email=" + $('#subs_email').val());
                $('#subs_email').val('');
                $('#success').html('Email Successfully Subscribed..!').fadeIn().delay(2000).fadeOut();
            }
            else {
                $('#errors').html('Please enter correct Email to subscribe..').fadeIn().delay(2000).fadeOut();
            }
        })
    });

    function ValidateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
            return (true);
        }
        return (false);
    }
</script>