<div class="modal-content popup2width">
    <button type="button" class="close popupright2" data-dismiss="modal" aria-label="Close" id="close_modal">
        <span aria-hidden="true">×</span></button>
    <div class="productdetailspopup mtop0">
        <div class="newsletter-icon"></div>
        <h2>Join our Newsletter</h2>
        <p>Where should we send you best coupons and deals</p>
        <div class="searchpopup2" id="subscribe_wrapper">
            <div id="errorss" style="display: none" class="label label-danger"></div>
            <div id="successs" style="display: none" class="label label-success"></div>
            <div class="input-group">
            <input type="text" class="form-control Search-anything searchboxpopup" name="x" placeholder="Your Email Id" id="s_email">
          <span class="input-group-btn">
          <button class="btn btn-default orange-button height42" type="button" onclick="subscribe()">SUBSCRIBE</button>
          </span></div>
        </div>
    </div>
</div>
<script>
    function subscribe() {
        if ($('#s_email').val() == '') {
            $('#errorss').html('Please enter Your Email to subscribe..').fadeIn().delay(2000).fadeOut();
        }
        else if (ValidateEmail($('#s_email').val())) {
            $.get(ajax_url + "/ajax-content/subscribe?email=" + $('#s_email').val());
            $('#s_email').val('');
            $('#successs').html('Email Successfully Subscribed..!').fadeIn().delay(1000).fadeOut(function(){
                $("#close_modal").trigger("click");
            });
        }
        else {
            $('#errorss').html('Please enter correct Email to subscribe..').fadeIn().delay(2000).fadeOut();
        }
    };

    function ValidateEmail(mail) {
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
            return (true);
        }
        return (false);
    }
</script>