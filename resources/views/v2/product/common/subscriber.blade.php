<div class="popupbgcolortow">
<div class="popupbgcolortow">
    <div class="col-md-3 popuptowleftpart3">
        <div class="popupofferbox">
            <h3>Best <span>Offers</span></h3>
        </div>
        <div class="popupproductbox">
            <div class="noncom-popupprodimg">
                <img class="noncompopupproimpo" src="{{url('assets/v2')}}/images/proleft.jpg" alt="product-Img">
            </div>
        </div>
    </div>
    <div class="col-md-9 popuprightpart">
        <div class="noncomplistnew3">
            <h4>Checkout the Best Price. Save Time Save Money !</h4>
            <p>Use our award winning search to get best deals. Subscribe & get Coupon / Deals.</p>
            <div class="col-md-12">
                <form class="form_search" id="searchbox" action="http://www.indiashopps.com/search" method="get">
                    <div class="input-group MT8">
                        <input type="text" required="" name="search_text" class="form-control search-input input-widthpopup auto_search ui-autocomplete-input" placeholder="Search Best Prices. Compare Before Your Buy ..." autocomplete="off" onfocus="ga('send', 'event', 'search_focus_popup_home', 'click');">
                <span class="input-group-btn">
                <button class="btn btn-default search-btn buttonsubscribenew" type="submit"> <i class="fa fa-search" aria-hidden="true"></i> Search </button>
                </span> </div>
                </form>
            </div>

            <div class="col-md-12">
                <form class="form_search" id="searchbox" action="" method="get">
                    <div class="input-group MT8" id="subscribe_wrapper">
                        <div id="errors" style="display: none" class="label label-danger"></div>
                        <div id="success" style="display: none" class="label label-success"></div>
                        <input type="text" name="search_text" class="form-control search-input input-subscribe" placeholder="Subscribe to get latest Deals & Promotions" autocomplete="off" id="subs_email">
                        <span class="input-group-btn">
                            <a class="btn btn-default search-btn buttonsubscribenew" type="submit"> Subscribe </a>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<style>
    /*THE-POPUP-3*/
    .popupbgcolortow{width:100%;margin:0px;padding:0px;background:url({{url('assets/v2/images/exit_popupbg2.jpg')}}) no-repeat top right;overflow: overlay}
    .popuptowleftpart3{background:#fefdfb;overflow:hidden;margin:0px;padding:0px;}
    .popuptowleftpart3 h3{padding:70px 0px 38px 0px;font-size:24px;width:140px;color:#FFFFFF;overflow:hidden;text-align:center;margin:auto;text-transform:uppercase;
        transform:rotate3d(1, 2, -1, 192deg);
        transform:rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;
        -webkit-transform: rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;
        -moz-transform:rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;
        -o-transform:rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;
        -ms-transform:rotate(-11deg) scale(1.199) skew(-5deg) translate(2px)!important;}
    .popuptowleftpar3 span{font-size:45px;color:#FFFFFF;overflow:hidden;text-align:center;text-transform:uppercase;line-height:33px;}
    .noncomplistnew3{width:70%;margin:auto;position:relative;background:rgba(229, 39, 98, 0.88);overflow:hidden;top:120px;padding:20px 10px 30px 10px;}
    .noncomplistnew3 h4{text-align:center;font-size:18px;font-weight:bold;color:#fff;text-transform:uppercase;}
    .noncomplistnew3 p{text-align:center;font-size:14px;color:#fff;}
    .buttonsubscribenew{background:#000!important;border-radius:0px;font-size:16px;outline:none!important;margin-top:10px;height:42px;}
    .input-subscribe{width:100%!Important;height:42px;margin-top:10px;border-radius:0px;background:#fff;outline:none!important;color:#000; border:none;}
    .buttonsearchpopupnew3{background:#fff!important;color:#000!important;border-radius:0px;font-size:16px;outline:none!important;margin-top:10px;height:42px;}
    .ui-menu.ui-widget.ui-widget-content.ui-autocomplete.ui-front { z-index: 1051 !important; }
    .input-widthpopup, .input-subscribe{width:100%!Important;height:44px;margin-top:10px;border-radius:0px;background:#fff;outline:none!important;color:#e40046; border: #000 thin solid;}
    .input-widthpopup::placeholder, .input-subscribe::placeholder{color: #e40046}
    /*END-POPUP-3*/
</style>
<script>
    search_box = $("#searchbox .auto_search");

    $( "form .auto_search" ).autocomplete({
        minLength: 2,
        source: completion,
        select: function( event, ui ) {
            $( "form .auto_search" ).val( ui.item.label );
            search_box.closest('form').submit();
            return false;
        }
    });
    $(document).ready(function(){
        $(document).on('click',"#subscribe_wrapper .search-btn",function(){
            if( $('#subs_email').val() == '' )
            {
                $('#errors').html('Please enter Your Email to subscribe..').fadeIn().delay(2000).fadeOut();
            }
            else if( ValidateEmail($('#subs_email').val()))
            {
                $.get(ajax_url+"/ajax-content/subscribe?email="+$('#subs_email').val());
                $('#subs_email').val('');
                $('#success').html('Email Successfully Subscribed..!').fadeIn().delay(2000).fadeOut();
                ga('send', 'event', 'popup_subscribed', 'click');
            }
            else
            {
                $('#errors').html('Please enter correct Email to subscribe..').fadeIn().delay(2000).fadeOut();
            }
        })
    });

    function ValidateEmail(mail)
    {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
        {
            return (true);
        }
        return (false);
    }
</script>