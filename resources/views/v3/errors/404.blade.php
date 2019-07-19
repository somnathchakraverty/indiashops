<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow"/>
    <title>Page not found - 404 page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" media="all" href="{{asset('assets/v3')}}/404/style.css">
</head>
<body id="errorpage" class="error404">
<div id="pagewrap">
    <!--Header Start-->
    <div id="header" class="header">
        <div class="container">
            <a href="{{route('home_v2')}}?utm_source=inbound&utm_medium=404" title="logo" class="link">
                <img class="logo" src="{{asset('assets/v3')}}/images/logo.png" alt="">
            </a>
        </div>
    </div><!--Header End-->
    <!--page content-->
    <div id="wrapper" class="clearfix">
        <div id="parallax_wrapper" style="height: 626px; left: 50%;">
            <div id="content">
                <h1>Lost in Desert<br>Nothing Found<br/>(404)</h1>

                <p>The page you're looking for is not here.</p>
                <a href="{{route('home_v2')}}?utm_source=inbound&utm_medium=404" title="" class="button">Go Home</a>
            </div>
            <!--parallax-->
            <span class="scene scene_1" style="left: 0px; top: 45%;"></span>
            <span class="scene scene_2" style="left: 30.2469px; top: 64%;"></span>
            <span class="scene scene_3" style="left: -12.963px; top: 65%;"></span>
        </div>
    </div>

</div><!-- end pagewrap -->

<!--page footer-->
<div id="footer">
    <div class="container">
        <ul class="copyright_info">

        </ul>
    </div>
</div><!--end page footer-->
<!-- Javascripts -->
<script src="{{asset('assets/v3')}}/404/jquery-1.8.3.js"></script>
<script defer src="{{asset('assets/v3')}}/404/plax.js"></script>
<script defer src="{{asset('assets/v3')}}/404/404.js"></script>
<script>
    if($(window).width()>1300 && $(window).width()<1700)
    {
        $('.scene.scene_1').css('top','52%');
        $('.scene.scene_2').css('top','69%');
        $('.scene.scene_3').css('top','69%');
    }
    else if($(window).width()>1700)
    {
        $('.scene.scene_1').css('top','55%');
        $('.scene.scene_2').css('top','74%');
        $('.scene.scene_3').css('top','74%');
    }
</script>
</body>
</html>