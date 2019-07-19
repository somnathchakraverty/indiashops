@extends('v2.master')
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a href="{{route("home_v2")}}">Home</a> >>  <a href="#">About US</a> </li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="shadow-boxaboutus">
        <div class="container">
            <div class="row">
                <div class="col-md-12 PL0">
                    <h1>About IndiaShopps</h1>
                    <div class="col-md-7">
                        <p><strong>IndiaShopps.com</strong> is one of the leading E-commerce companies across India. We are a comparative shopping and coupons portal that provides users amazing discounts, deals, offers & coupons. The aim is to provide users a portal to compare all websites before they buy and not to waste time searching for best deals on 80+ sites , they can just search on IndiaShopps.com!! An Average online shopper has to undergo searching multiple steps before he finally lands up with a product of his choice. We aim to eliminate all these steps and reduce it into one simple search. The website dynamically in real time get results from various online shopping portals and provides the best price comparison to the customer who can then visit the respective shopping portal offering the best deal and completes the purchase. The website has a constantly evolving portfolio of very high quality sites. We have currently 80+ very credible and exhaustive portals like Flipkart, Amazon, Ebay, Infibeam, Homeshop18, Jabong, Myntra, Yebhi ,ShopClues etc that provide the deals and products online. We have over 30 million products and 1500+ brands.</p>
                        <p>IndiaShopps is a one stop solution to finding your dream product / deals / coupons / offers online at best prices.</p>
                        <p>We are committed to stand by our moto as :</p>
                        <h4>Save Time Save Money!!!</h4>
                    </div>
                    <div class="col-md-5"><img class="img-responsive" src="{{asset('assets/v2/')}}/images/about_img.jpg"></div>
                </div>
            </div>
        </div>
    </div>
@endsection