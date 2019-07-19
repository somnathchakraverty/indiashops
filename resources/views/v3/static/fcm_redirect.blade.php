<html>
<title>Redirecting to {!! $redirect_url !!} ...</title>
<body>
Redirecting to {!! $redirect_url !!}. Please <a href="{!! $redirect_url !!}">click here</a> if you are not redirected..
</body>
<script src="{{asset('assets/v2/')}}/js/fcm_app.js" defer onload="fcmLoaded()"></script>
<script>
    var token_fetched = false;
    function fcmLoaded() {
        var interval = setInterval(function () {
            if (token_fetched) {
                clearInterval(interval);
                window.location.href = '{!! $redirect_url !!}';
            }
        }, 500);
    }
</script>
</html>