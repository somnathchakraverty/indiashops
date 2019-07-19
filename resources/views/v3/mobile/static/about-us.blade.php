@extends('v3.mobile.master')
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    <section>
        <div class="whitecolorbg">
            <div class="container">
            <h1 style="margin:0px 0px 15px 0px;">About IndiaShopps</h1>
                <p><strong>IndiaShopps.com</strong> is one of the leading E-commerce companies across India. We are a
                    comparative shopping and coupons portal that provides users amazing discounts, deals, offers &
                    coupons. The aim is to provide users a portal to compare all websites before they buy and not to
                    waste time searching for best deals on 80+ sites , they can just search on IndiaShopps.com!! An
                    Average online shopper has to undergo searching multiple steps before he finally lands up with a
                    product of his choice. We aim to eliminate all these steps and reduce it into one simple search. The
                    website dynamically in real time get results from various online shopping portals and provides the
                    best price comparison to the customer who can then visit the respective shopping portal offering the
                    best deal and completes the purchase. The website has a constantly evolving portfolio of very high
                    quality sites. We have currently 80+ very credible and exhaustive portals like Flipkart, Amazon,
                    Ebay, Infibeam, Homeshop18, Jabong, Myntra, Yebhi ,ShopClues etc that provide the deals and products
                    online. We have over 30 million products and 1500+ brands.</p>
                    <p>Apart from India, our services are also available for individuals in many other countries that include <a href="https://www.mybestprice.my" target="_blank" rel="nofollow">Malaysia</a>, <a href="https://www.mybestprice.hk" target="_blank" rel="nofollow">Hong Kong</a>, <a href="https://www.mybestprice.ph" target="_blank" rel="nofollow">Philippines</a>, <a href="https://www.mybestprice.sg" target="_blank" rel="nofollow">Singapore</a>, <a href="https://www.mybestprice.id" target="_blank" rel="nofollow">Indonesia</a>, <a href="https://www.mybestprice.vn" target="_blank" rel="nofollow">Vietnam</a>, and Thailand.</p>
                <p>IndiaShopps is a one stop solution to finding your dream product / deals / coupons / offers online at
                    best prices.</p>
                <p>We are committed to stand by our moto as :</p>
                <h4 style="margin-top:15px;">Save Time Save Money!!!</h4>

            </div>
            <div class="container"><img class="img-responsive" src="{{asset('assets/v2/')}}/images/about_img.jpg"></div>
        </div>
    </section>
@endsection
@section('scripts')
	<script src="{{get_file_url('mobile/js/front.js')}}" defer></script>
    <script>
        function loadCarousels(){}
        function uiLoaded(){}
    </script>
@endsection