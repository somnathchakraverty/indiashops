<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html prefix="og: http://ogp.me/ns#" lang="en" itemscope itemtype="http://schema.org/WebPage">
<head>
    <?php setUpGlobals(get_defined_vars()['__data']); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <link type="text/css" rel="icon" href="{{asset('assets/v3')}}/images/favicon.png">
    @if( app('seo') instanceof \indiashopps\Support\SEO\SeoData )
        <title>{!! app('seo')->getTitle() !!}</title>
    @else
        <title>Indiashopps - Redirecting</title>
    @endif
    <style>
        {!! file_get_contents(base_path('resources/views').'/v3/common/header.css')  !!}
         a.btn{background:#ff7149!important;color:#fff!important;padding:10px}
		.ret_box{width:650px;background:#fff;margin:30px auto;padding:15px;overflow:hidden;border-radius:5px;border:1px solid #f2f2f2}
		.ret_box h2{width:100%;font-size:20px;color:#545454;margin:0;padding:15px 0;font-weight:600;text-align:center;border-bottom:1px solid #e5e5e5}
		.ret_box p{font-size:17px;color:#000;margin:0;padding:30px 0;text-align:center}
		.ret_box span{width:162px;background:#f1f1f1;margin:10px auto;height:6px;font-size:20px;color:#000;padding:0;display:block}
		.ret_box h3{font-size:18px;color:#ff7149;margin:0;padding:20px 0;text-align:center}
		.ret_box li{font-size:16px;list-style:disc;margin-left:20px;padding-bottom:10px;}
		.retlog{max-width:460px;margin:auto}
		.retindlo{width:150px;float:left;text-align:center;margin:auto;padding-bottom:25px}
		
    </style>
    {!! getHeadTagContent() !!}
</head>
<body>
{!! getBodyTagContent() !!}
<div class="ret_box">
    <h2>
        {!! $coupon->title !!}
    </h2>
    <p>
        Install IndiaShopps extension and get Coupons and Deals instantly.
        <br/><br/>
        <a class="btn" href="https://goo.gl/hzEQ6B" target="_blank">Get Now</a>
    </p>
    <span></span>
    <h3>Please Wait While We Are Redirecting You to {{unslug($coupon->vendor_name)}}</h3>
    <div class="retlog">
        <div class="retindlo">
            <img src="{{asset('assets/v3/images/coupon_logo.png')}}" alt="Indiashopps Logo">
        </div>
        <div class="retindlo">
            <img style="margin-top:3px;" src="{{asset('assets/v3/images/loading.gif')}}" alt="Coupon Redirect icon">
        </div>
        <div class="retindlo">
            <img src="{{getCouponImage($coupon->image_url)}}" alt="{{$coupon->vendor_name}} coupon image">
        </div>
    </div>
</div>
<link type="text/css" rel="stylesheet" href="{{mix('build/css/app.css')}}">
<script type="application/javascript">
    @if($coupon->type == 'coupon' )
        var wait_time = 1500;
    @else
        var wait_time = 3000;
    @endif

    setTimeout(function(){
        window.location.href = '{!! $redirect_url !!}';
    },wait_time);
</script>
</body>
</html>
