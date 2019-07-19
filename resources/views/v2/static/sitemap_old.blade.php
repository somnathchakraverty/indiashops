@extends('v2.master')
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a href="{{route("home_v2")}}">Home</a> >>  <a href="#">Contact US</a> </li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="container">
        <div class="row PL0">
            <div class="col-md-9">
                <div class="sub-title MT10"> <span>Sitemap</span></div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> General Info</h2>
                    <ul>
                        <li><a href="{{url('blog')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Blog</a></li>
                        <li><a href="{{url('coupons')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Coupons</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Mobile Phones</h2>
                    <ul>
                        <li><a href="{{url('mobile')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Mobile Phones</a></li>
                        <li><a href="{{url('mobile/mobiles-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Mobile Price List</a></li>
                        <li><a href="{{url('upcoming-mobiles-in-india')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Upcoming Mobiles</a></li>
                        <li><a href="{{url('mobile/mobiles-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Best Mobiles</a></li>
                        <li><a href="{{url('most-compared-mobiles.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Compare Mobiles</a></li>
                        <li><a href="{{url('mobile/tablets-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Tablets Price List</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Popular Mobile Brands</h2>
                    <ul>
                        <li><a href="{{url('motorola-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Motorola Mobiles</a></li>
                        <li><a href="{{url('apple-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Apple Mobiles</a></li>
                        <li><a href="{{url('samsung-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Samsung Mobiles</a></li>
                        <li><a href="{{url('htc-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> HTC Mobiles</a></li>
                        <li><a href="{{url('lenovo-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Lenovo Mobiles</a></li>
                        <li><a href="{{url('xiaomi-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Xiaomi Mobiles</a></li>
                        <li><a href="{{url('huawei-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Huawei Mobiles</a></li>
                        <li><a href="{{url('micromax-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Micromax Mobiles</a></li>
                        <li><a href="{{url('asus-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Asus Mobiles</a></li>
                        <li><a href="{{url('oppo-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Oppo Mobiles</a></li>
                        <li><a href="{{url('intex-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Intex Mobiles</a></li>
                        <li><a href="{{url('nokia-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Nokia Mobiles</a></li>
                        <li><a href="{{url('lg-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> LG Mobiles</a></li>
                        <li><a href="{{url('sony-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sony Mobiles</a></li>
                        <li><a href="{{url('blackberry-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Blackberry Mobiles</a></li>
                        <li><a href="{{url('coolpad-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Coolpad Mobiles</a></li>
                        <li><a href="{{url('panasonic-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Panasonic Mobiles</a></li>
                        <li><a href="{{url('zte-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> ZTE Mobiles</a></li>
                        <li><a href="{{url('spice-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Spice Mobiles</a></li>
                        <li><a href="{{url('infocus-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> InFocus Mobiles</a></li>
                        <li><a href="{{url('gionee-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Gionee Mobiles</a></li>
                        <li><a href="{{url('karbonn-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Karbonn Mobiles</a></li>
                        <li><a href="{{url('lyf-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Lyf Mobiles</a></li>
                        <li><a href="{{url('leeco-mobiles-price-list-in-india-351')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> LeEco Mobiles</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Popular Tablet Brands</h2>
                    <ul>
                        <li><a href="{{url('samsung-tablets-price-list-in-india-352')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Samsung Tablets</a></li>
                        <li><a href="{{url('iball-tablets-price-list-in-india-352')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> iBall Tablets</a></li>
                        <li><a href="{{url('micromax-tablets-price-list-in-india-352')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Micromax Tablets</a></li>
                        <li><a href="{{url('asus-tablets-price-list-in-india-352')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Asus Tablets</a></li>
                        <li><a href="{{url('apple-tablets-price-list-in-india-352')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Apple Tablets</a></li>
                        <li><a href="{{url('lenovo-tablets-price-list-in-india-352')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Lenovo tablets </a></li>
                        <li><a href="{{url('swipe-tablets-price-list-in-india-352')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Swipe Tablets</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Laptops</h2>
                    <ul>
                        <li><a href="{{url('computers')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Computers</a></li>
                        <li><a href="{{url('computers/laptops-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Laptop price List</a></li>
                        <li><a href="{{url('computers/laptops-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Best Laptops</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Popular Laptop Brands</h2>
                    <ul>
                        <li><a href="{{url('asus-laptops-price-list-in-india-379')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Asus Laptops</a></li>
                        <li><a href="{{url('acer-laptops-price-list-in-india-379')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Acer Laptops</a></li>
                        <li><a href="{{url('apple-laptops-price-list-in-india-379')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Apple Laptops</a></li>
                        <li><a href="{{url('dell-laptops-price-list-in-india-379')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Dell Laptops</a></li>
                        <li><a href="{{url('hp-laptops-price-list-in-india-379')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> HP Laptops</a></li>
                        <li><a href="{{url('lenovo-laptops-price-list-in-india-379')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Lenovo Laptops</a></li>
                        <li><a href="{{url('sony-laptops-price-list-in-india-379')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sony Laptops</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Televisions</h2>
                    <ul>
                        <li><a href="{{url('electronics/lcd-led-tvs-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Television Price List</a></li>
                    </ul>
                </div>
                {{--<div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Popular Television Brands</h2>
                    <ul>
                        <li><a href="{{url('sansui-led-tv-price-list-in-india-446')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sansui Television</a></li>
                        <li><a href="{{url('lg-led-tv-price-list-in-india-446')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> LG Television</a></li>
                        <li><a href="{{url('sony-led-tv-price-list-in-india-446')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sony Television</a></li>
                        <li><a href="{{url('haier-led-tv-price-list-in-india-446')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Haier Televison</a></li>
                        <li><a href="{{url('samsung-led-tv-price-list-in-india-446')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Samsung Television</a></li>
                        <li><a href="{{url('panasonic-led-tv-price-list-in-india-446')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Panasonic Television</a></li>
                        <li><a href="{{url('onida-led-tv-price-list-in-india-446')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Onida Television</a></li>
                        <li><a href="{{url('micromax-led-tv-price-list-in-india-446')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Micromax Television</a></li>
                        <li><a href="{{url('videocon-led-tv-price-list-in-india-446')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Videocon Television</a></li>
                    </ul>
                </div>--}}
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Cameras</h2>
                    <ul>
                        <li><a href="{{url('camera')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Cameras</a></li>
                        <li><a href="{{url('camera/cameras-dslrs-more-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Camera Price List</a></li>
                    </ul>
                </div>
                {{--<div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Popular Camera Brands</h2>
                    <ul>
                        <li><a href="{{url('canon-digital-slr-cameras-price-list-in-india-472')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Canon Camera</a></li>
                        <li><a href="{{url('nikon-digital-slr-cameras-price-list-in-india-472')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Nikon Camera</a></li>
                        <li><a href="{{url('panasonic-digital-slr-cameras-price-list-in-india-472')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Panasonic Camera</a></li>
                        <li><a href="{{url('sony-digital-slr-cameras-price-list-in-india-472')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sony Camera</a></li>
                    </ul>
                </div>--}}
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Air Conditioners</h2>
                    <ul>
                        <li><a href="{{url('appliances/home-appliances/air-conditioners-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Air Conditioner Price List</a></li>
                    </ul>
                </div>
                {{--<div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Popular Air Conditioner Brands</h2>
                    <ul>
                        <li><a href="{{url('haier-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Haier Air Conditioner</a></li>
                        <li><a href="{{url('voltas-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Voltas Air Conditioner</a></li>
                        <li><a href="{{url('daikin-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Daikin Air Conditioner</a></li>
                        <li><a href="{{url('samsung-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Samsung Air Conditioner</a></li>
                        <li><a href="{{url('hitachi-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Hitachi Air Conditioner</a></li>
                        <li><a href="{{url('bluestar-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Blue Star Air Conditioner</a></li>
                        <li><a href="{{url('lg-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> LG Air Conditioner</a></li>
                        <li><a href="{{url('mitsubishi-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Mitsubishi Air Conditioner</a></li>
                        <li><a href="{{url('panasonic-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Panasonic Air Conditioner</a></li>
                        <li><a href="{{url('carrier-air-conditioners-price-list-in-india-336')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Carrier Air Conditioner</a></li>
                    </ul>
                </div>--}}
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Men Wears</h2>
                    <ul>
                        <li><a href="{{url('men')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Wears</a></li>
                        <li><a href="{{url('men/clothing-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Clothes</a></li>
                        <li><a href="{{url('men/shoes-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Shoes</a></li>
                        <li><a href="{{url('men/accessories-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Accessories</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Women Wears</h2>
                    <ul>
                        <li><a href="{{url('women')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Women Wears</a></li>
                        <li><a href="{{url('women/clothing-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Women Clothes</a></li>
                        <li><a href="{{url('women/ethnic-clothing-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Ethnic Clothes</a></li>
                        <li><a href="{{url('women/shoes-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Women Shoes</a></li>
                        <li><a href="{{url('women/accessories-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Women Accessories</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Appliances</h2>
                    <ul>
                        <li><a href="{{url('appliances')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Appliances</a></li>
                        <li><a href="{{url('appliances/home-appliances-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Home Appliances</a></li>
                        <li><a href="{{url('appliances/kitchen-appliances-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Kitchen Appliances</a></li>
                        <li><a href="{{url('appliances/kitchen-appliances/microwave-ovens-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Microwave Ovens</a></li>
                        <li><a href="{{url('appliances/home-appliances/washing-machines-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Washing Machines</a></li>
                        <li><a href="{{url('appliances/home-appliances/refrigerators-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Refrigerators</a></li>
                        <li><a href="{{url('appliances/kitchen-appliances/water-purifiers-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Water Purifiers</a></li>
                        <li><a href="{{url('appliances/heaters-fans-coolers/geysers-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Geysers</a></li>
                        <li><a href="{{url('appliances/heaters-fans-coolers/fans-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Fans</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Beauty  & Health</h2>
                    <ul>
                        <li><a href="{{url('beauty-health')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Beauty & Health </a></li>
                        <li><a href="{{url('beauty-health/health-care-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Healthcares</a></li>
                        <li><a href="{{url('beauty-health/skin-care-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Skincares</a></li>
                        <li><a href="{{url('care/personal-care-products-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Personalcares</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Home & Decors</h2>
                    <ul>
                        <li><a href="{{url('home-decor')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Home & Decors</a></li>
                        <li><a href="{{url('home-decor/furniture-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Furnitures</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Sports & Fitness</h2>
                    <ul>
                        <li><a href="{{url('sports-fitness')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sports & Fitness</a></li>
                        <li><a href="{{url('sports-fitness/fitness-equipments-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Fitness Equipments</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Kids Wears</h2>
                    <ul>
                        <li><a href="{{url('kids')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Kids Wears</a></li>
                        <li><a href="{{url('kids/boy-clothing-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Boy Clothes</a></li>
                        <li><a href="{{url('kids/girl-clothing-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Girl Clothes</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Lifestyles</h2>
                    <ul>
                        <li><a href="{{url('lifestyle')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Lifestyles</a></li>
                        <li><a href="{{url('lifestyle/luggage-suitcase')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Luggage & Suitcase</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Automative</h2>
                    <ul>
                        <li><a href="{{url('automotive')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Automative</a></li>
                        <li><a href="{{url('automotive/bike-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Bike Accessories</a></li>
                        <li><a href="{{url('automotive/car-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Car Accessories</a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Books</h2>
                    <ul>
                        <li><a href="{{url('books')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Books </a></li>
                    </ul>
                </div>
                <div class="allcategorieslist-ver2 bgcolorallcate">
                    <h2><span><i class="fa fa-mobile" aria-hidden="true"></i></span> Miscellaneous</h2>
                    <ul>
                        <li><a href="{{url('mobile/mobile-accessories/power-banks-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Power Banks</a></li>
                        <li><a href="{{url('mobile/mobile-accessories/microsd-memory-cards-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Memory Cards</a></li>
                        <li><a href="{{url('mobile/headphones-headsets/headphones-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Headphones</a></li>
                        <li><a href="{{url('mobile/car-mobile-accessories/car-chargers-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Car Chargers</a></li>
                        <li><a href="{{url('computers/storage-and-memory/pen-drives-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Pen Drives</a></li>
                        <li><a href="{{url('computers/accessories-and-peripherals/mouse-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Mouse</a></li>
                        <li><a href="{{url('computers/networking-devices/wifi-routers-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> WiFi Routers</a></li>
                        <li><a href="{{url('computers/printers-and-inks/multifunction-printers-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Printers</a></li>
                        <li><a href="{{url('appliances/home-appliances/irons-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Irons</a></li>
                        <li><a href="{{url('appliances/kitchen-appliances/pressure-cooker-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Pressure Cookers</a></li>
                        <li><a href="{{url('appliances/kitchen-appliances/mixer-grinder-juicers-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Mixer Grinders</a></li>
                        <li><a href="{{url('electronics/ipods-home-theaters-dvd-players/home-theaters-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Home Theaters</a></li>
                        <li><a href="{{url('electronics/ipods-home-theaters-dvd-players/mp3-players-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> MP3 Players</a></li>
                        <li><a href="{{url('camera/cameras-dslrs-more/digital-cameras-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Digital Cameras</a></li>
                        <li><a href="{{url('camera/cameras-dslrs-more/surveillance-camers-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> CCTV Cameras</a></li>
                        <li><a href="{{url('men/shoes/casual-shoes-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Casual Shoes</a></li>
                        <li><a href="{{url('men/shoes/sports-shoes-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Sports Shoes</a></li>
                        <li><a href="{{url('men/shoes/formal-shoes-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Formal Shoes</a></li>
                        <li><a href="{{url('men/shoes/loafers-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Loafers</a></li>
                        <li><a href="{{url('men/shoes/sandals-floaters-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Sandals</a></li>
                        <li><a href="{{url('men/clothing/tshirt-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Tshirts</a></li>
                        <li><a href="{{url('men/clothing/jeans-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Men Jeans</a></li>
                        <li><a href="{{url('women/ethnic-clothing/salwar-suits-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Salwar Suits</a></li>
                        <li><a href="{{url('women/ethnic-clothing/anarkali-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Anarkali Suits</a></li>
                        <li><a href="{{url('women/ethnic-clothing/sarees-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Sarees</a></li>
                        <li><a href="{{url('women/clothing/tops-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Tops</a></li>
                        <li><a href="{{url('women/shoes/sandals-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Women Sandals</a></li>
                        <li><a href="{{url('women/shoes/heels-price-list-in-india.html')}}"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Heels</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 PL0 MT10">
                <div class="sub-title"><span>Latest Mobile Phones in India</span></div>
                <ul class="product-listtopmobile">
                    <li class="P15">
                        <div class="pull-left">
                            <div class="mobileimleftnew"><a target="_blank" href="{{url('vivo-v5-price-in-india-121673')}}"> <img class="productmobimleft" alt="100%x200" src="http://images.indiashopps.com/v2/homepage/topten/vivo-v5.jpg" onerror="imgError(this)"> </a> </div>
                        </div>
                        <aside> <a href="{{url('vivo-v5-price-in-india-121673')}}" target="_blank" title="Vivo V5">Vivo V5</a>
                            <div class="phonerattinghome">
                                <div class="star-rating">
                                    <span class="fa fa-star" data-rating="1"></span>
                                    <span class="fa fa-star" data-rating="2"></span>
                                    <span class="fa fa-star" data-rating="3"></span>
                                    <span class="fa fa-star" data-rating="4"></span>
                                    <span class="fa fa-star-o" data-rating="5"></span>
                                </div>
                            </div>
                            <span class="price">Rs. 15,747</span> </aside>
                    </li>
                    <li class="P15">
                        <div class="pull-left">
                            <div class="mobileimleftnew"><a target="_blank" href="{{url('oneplus-3t-128-gb-price-in-india-121523')}}"> <img class="productmobimleft" alt="100%x200" src="http://ecx.images-amazon.com/images/I/51nTYG54myL.jpg" onerror="imgError(this)"> </a> </div>
                        </div>
                        <aside> <a href="{{url('oneplus-3t-128-gb-price-in-india-121523')}}" target="_blank" title="OnePlus 3T 128 GB">OnePlus 3T 128 GB</a>
                            <div class="phonerattinghome">
                                <div class="star-rating">
                                    <span class="fa fa-star" data-rating="1"></span>
                                    <span class="fa fa-star" data-rating="2"></span>
                                    <span class="fa fa-star" data-rating="3"></span>
                                    <span class="fa fa-star" data-rating="4"></span>
                                    <span class="fa fa-star-o" data-rating="5"></span>
                                </div>
                            </div>
                            <span class="price">Rs. 30,000</span> </aside>
                    </li>
                    <li class="P15">
                        <div class="pull-left">
                            <div class="mobileimleftnew"><a target="_blank" href="{{url('coolpad-note-5-32-gb-price-in-india-121598')}}"> <img class="productmobimleft" alt="100%x200" src="http://images.indiashopps.com/v2/homepage/topten/coolpad-note-5-32-gb.jpg" onerror="imgError(this)"> </a> </div>

                        </div>
                        <aside> <a href="{{url('coolpad-note-5-32-gb-price-in-india-121598')}}" target="_blank" title="Coolpad Note 5 32 GB">Coolpad Note 5 32 GB</a>
                            <div class="phonerattinghome">
                                <div class="star-rating">
                                    <span class="fa fa-star" data-rating="1"></span>
                                    <span class="fa fa-star" data-rating="2"></span>
                                    <span class="fa fa-star" data-rating="3"></span>
                                    <span class="fa fa-star" data-rating="4"></span>
                                    <span class="fa fa-star-o" data-rating="5"></span>
                                </div>
                            </div>
                            <span class="price">Rs. 11,249</span> </aside>
                    </li>
                    <li class="P15">
                        <div class="pull-left">
                            <div class="mobileimleftnew"><a target="_blank" href="{{url('vivo-v5-plus-price-in-india-121672')}}"> <img class="productmobimleft" alt="100%x200" src="https://rukminim1.flixcart.com/image/100/100/mobile/p/y/q/vivo-v5-plus-na-100x100-imaeqvhfpfgtah2h.jpeg" onerror="imgError(this)"> </a> </div>
                        </div>
                        <aside> <a href="{{url('vivo-v5-plus-price-in-india-121672')}}" target="_blank" title="Vivo V5 Plus">Vivo V5 Plus</a>
                            <div class="phonerattinghome">
                                <div class="star-rating">
                                    <span class="fa fa-star" data-rating="1"></span>
                                    <span class="fa fa-star" data-rating="2"></span>
                                    <span class="fa fa-star" data-rating="3"></span>
                                    <span class="fa fa-star" data-rating="4"></span>
                                    <span class="fa fa-star-o" data-rating="5"></span>
                                </div>
                            </div>
                            <span class="price">Rs. 24,340</span>
                        </aside>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection