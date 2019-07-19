<div class="popupbgcolortow">
    <div class="col-md-3 popuptowleftpart">
        <div class="popupofferbox">
            <h3>Best <span>Offers</span></h3>
        </div>
        <div class="popupproductbox">
            <div class="noncom-popupprodimg"><img class="noncompopupproimpo" src="{{url('assets/v2/images/popup_noncom.jpg')}}" alt="product-Img"></div>
        </div>
    </div>
    <div class="col-md-9 popuprightpart">
        <h3>Wait! Checkout Best Offers for YOU..</h3>
        <div class="col-md-12">
            <form class="form_search" id="searchbox" action="http://www.indiashopps.com/search" method="get">
                <div class="input-group MT8">
                    <input type="text" required="" name="search_text" class="form-control search-input input-widthpopup auto_search" placeholder="Search Best Prices. Compare Before Your Buy ..." autocomplete="off" onfocus="ga('send', 'event', 'search_focus_popup_comp', 'click');">
                <span class="input-group-btn">
                <button class="btn btn-default search-btn buttonsearchpopupnew" type="submit" onclick="ga('send', 'event', 'search_click_comp_popup', 'click');"> <i class="fa fa-search" aria-hidden="true"></i> Search </button>
                </span> </div>
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
                                <a href="{{product_url($p)}}" target="_blank" onclick="ga('send', 'event', 'popup_product', 'click');">
                                    <img class="proimpolist" src="{{getImageNew($product->image_url,"S")}}" alt="product-Img" onerror="imgError(this)">
                                </a>
                            </div>
                            <a href="{{product_url($p)}}" target="_blank" onclick="ga('send', 'event', 'popup_product', 'click');"><h5>{{$product->name}}</h5></a>
                            <p><a href="{{product_url($p)}}" target="_blank" class="btn btn-default btn-product btn-productpopup" role="button" onclick="ga('send', 'event', 'popup_product', 'click');">Rs. {{number_format($product->saleprice)}}</a> </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-12">
            <div class="input-group MT9" id="subscribe_wrapper">
                <div id="errors" style="display: none" class="label label-danger"></div>
                <div id="success" style="display: none" class="label label-success"></div>
                <input type="text" id="subs_email" name="email" class="form-control search-input input-widthpopup" placeholder="Subscribe to get latest Deals & Promotions" autocomplete="off">
            <span class="input-group-btn">
                <a class="btn btn-default search-btn buttonsearchpopupnew"> <i class="fa fa-envelope" aria-hidden="true"></i> Subscribe </a>
            </span>
            </div>
        </div>
    </div>
</div>
<style>
    /*THE-POPUP-2*/
    .popupbgcolortow{width:100%;margin:0px;padding:0px;background:url({{url('assets/v2/images/exit_popupbg2.jpg')}}) no-repeat top right;overflow: overlay}
    .popuptowleftpart{background:#f5f6f8;overflow:hidden;margin:0px;padding:0px;}
    .popuptowleftpart h3{padding:70px 0px 38px 0px;font-size:24px;width:140px;color:#FFFFFF;overflow:hidden;text-align:center;margin:auto;text-transform:uppercase;
        transform:rotate3d(1, 2, -1, 192deg);
        transform:rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;
        -webkit-transform: rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;
        -moz-transform:rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;
        -o-transform:rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;
        -ms-transform:rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;}
    .popuptowleftpart span{font-size:35px;color:#FFFFFF;overflow:hidden;text-align:center;text-transform:uppercase;line-height:33px;}
    .noncom-popupprodimg{width:100%;}
    .noncompopupproimpo{width:250px;height:auto;margin:auto;text-align:center;display:block;}
    .popupprodimglist{width:110px;height:auto;}
    .noncompopupprodimglist{margin:10px auto;padding:0px;width:180px;text-align:center;min-height: 200px;}
    .martop, .btn-productpopup{margin:15px 0px;}
    .noncomplistnew{position:relative;background:rgba(0, 0, 0, 0.27);overflow:hidden;top:146px;}
    .noncomplistnew h3{font-size:22px;color:#FFF;text-align:center;font-style:normal;text-shadow: -3px 0px 19px rgb(8, 8, 8);}
    .left_arrow-popup{position:absolute;left:7px;top:56%;cursor:pointer;z-index: 9;}
    .right_arrow-popup{position:absolute;right:7px;top:56%;cursor:pointer;z-index: 9;}
    /*END-POPUP-2*/
</style>
<script>
    $(document).ready(function(){
        var owl1 = $("#popup_suggest");

        owl1.owlCarousel({
            items: 3,
            itemsDesktop: [1000, 3],
            itemsDesktopSmall: [900, 2],
            itemsTablet: [600, 2],
            itemsMobile: false,
            autoPlay:true,
            stopOnHover:true,
            scrollPerPage : true,
            paginationSpeed: 200,
        });
        $("#popup_suggest").parent().find(".next").click(function() {
            owl1.trigger('owl.next');
        });
        $("#popup_suggest").parent().find(".prev").click(function() {
            owl1.trigger('owl.prev');
        });
    });
</script>