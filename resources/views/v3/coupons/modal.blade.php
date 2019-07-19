<div id="couponModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="coupon-title">Your Coupon</h4>
            </div>
            <div class="modal-body">
                <div id="coupon-code"><span>Coupon Code :</span></div>
            </div>
            <div class="normaltextpopup"><span>Congratulations!</span> This is your Coupon Code. Enjoy your shopping and do come back to us again.</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    window.onload = function(e){

        if( typeof getCookie != 'undefined' )
        {
            code = getCookie('coupon_code');

            if( typeof code != "undefined" && code.length > 0 )
            {
                $('#coupon-code').html("<span>Coupon Code: "+code+"</span>");
                $('#couponModal').modal('show');
                setCookie('coupon_code', '', -1);
            }
        }
        else{
            console.log(typeof getCookie)
        }
    };
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
</script>