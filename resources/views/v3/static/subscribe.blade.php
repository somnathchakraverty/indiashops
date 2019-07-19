<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0074)http://successagency.com/di/coming-soon-demo/drinkalike-the-iphone-app-15/ -->
<html xmlns="http://www.w3.org/1999/xhtml" class="cufon-active cufon-ready">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Subscribe for Best Deals | Indiashopps </title>
    <link href="{{asset('assets/v2/',true)}}/css/subscribe.css" rel="stylesheet" type="text/css">
    <link rel="icon" href="{{secure_asset('assets/v2/images/favicon.png')}}" type="image/png" sizes="16x16">
    <link rel="chrome-webstore-item" href="https://chrome.google.com/webstore/detail/pgoackgjjkpbkjoomkklkofbhpkbeboc">
</head>
<body>
<div class="content_wrapper">
    <div class="top_content">
        <div class="header">
            <div class="iphone"> <img src="{{asset('assets/v2/',true)}}/images/image.jpg" alt=""> </div>
            <div class="logo_content">
                <div class="before_content">
                    <h3><strong>Receive updates, stay informed!</strong></h3>
                    <h3>We promise you will get best Deals !!</h3>
                    <p>The EASIEST way to save money on your shopping. Stay Informed !!!</p>
                    <p>We promise not to let you spend extra and waste your money. Will keep you informed on best prices across all ecommerce sites - Flipkart, Amazon, Snapdeal, Paytm etc Just click "Allow" on the notification message that you see on top left corner.</p>
                </div>
                <div class="allowbutton" id="message_box">
                    <img src="" alt="Allow" id="message_image"/>
                </div>
                <div class="success_msg" style="display: none;">
                    <p>Install Browser Extension & Android App.It will let you know which site is selling the product u want to buy at best price. Save Money and Save Time !!! </p>
                    <p>Try once. 100% Free to use forever. We gaurantee it will change the way you shop and save money !!!</p>
                    <p>Just click Extenstion Install and App Install buttons below.Enjoy Shopping !!!</p>
                    <div class="chrome_extension" style="display: none">
                        <a href="javascript:;" onclick="chrome.webstore.install('https://chrome.google.com/webstore/detail/pgoackgjjkpbkjoomkklkofbhpkbeboc',callb, callb );" >
                            <img src="{{secure_asset('assets/v2/images/chrome_extension.jpg')}}" alt=""/>
                        </a><br/>
                        <div id="install_app_android">
                            <a href="https://play.google.com/store/apps/details?id=com.indiashopps.android&hl=en" target="_blank" >
                                <img src="{{secure_asset('assets/v2/images/android_play_store.png')}}" alt=""/>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="block_msg" style="display: none;">
                    <p>Install Browser Extension & Android App.It will let you know which site is selling the product u want to buy at best price. Save Money and Save Time !!! </p>
                    <p>Try once. 100% Free to use forever. We gaurantee it will change the way you shop and save money !!!</p>
                    <p>Just click Extenstion Install and App Install buttons below.Enjoy Shopping !!!</p><br/>
                    <div class="chrome_extension" style="display: none">
                        <a href="javascript:;" onclick="chrome.webstore.install('https://chrome.google.com/webstore/detail/pgoackgjjkpbkjoomkklkofbhpkbeboc',callb, callb );" >
                            <img src="{{secure_asset('assets/v2/images/chrome_extension.jpg')}}" alt=""/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('assets/v2/',true)}}/js/jquery.js"></script>
<script type="application/javascript">

    var save_token_url = '{{secureUrl(route('fcm_token_save'),true)}}';
    var firefox_img = '{{asset('assets/v2/',true)}}/images/allow_firefox.png';
    var chrome_img = '{{asset('assets/v2/',true)}}/images/allow2.png';

    var isFirefox = typeof InstallTrigger !== 'undefined';
    var isChrome = !!window.chrome && !!window.chrome.webstore;

    if( isFirefox )
    {
        document.getElementById('message_image').src = firefox_img;
    }
    else if( isChrome )
    {
        document.getElementById('message_image').src = chrome_img;
    }

    var callback = function( status )
    {
        $(".before_content").hide();

        if( status )
        {
            document.getElementById('message_box').innerHTML = "<h1>Thanks for subscribing.</h1>";
            $(".success_msg").slideDown('fast');
        }
        else{
            $(".block_msg").slideDown('fast');
            document.getElementById('message_box').insertAdjacentHTML('beforeend', "<h1>We promise not to send many notifications. Just 1 per day. Stay Informed !!! Save Money !!!</h1>");
        }

        if( isChrome )
        {
            $(".chrome_extension").show();
        }
    };

    function callb(){};
</script>
<script type="text/javascript" src="{{asset('assets/v2/',true)}}/js/cufon-yui.js"></script>
<script type="text/javascript" src="{{asset('assets/v2/',true)}}/js/Comfortaa_250-Comfortaa_700.font.js"></script>
<script type="text/javascript">
    //Cufon.replace('h1', {fontFamily: 'Comfortaa'});
    //Cufon.replace('p.c_soon strong', {fontFamily: 'Comfortaa'});
</script>
<script src="{{asset('assets/v2/',true)}}/js/fcm_app.js"></script>
</body>
</html>
