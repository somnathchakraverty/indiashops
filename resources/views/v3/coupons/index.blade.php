@extends("v3.master")
@section('page_content')
    <!--THE-BANNER-->
    @include('v3.coupons.sliders')
    <!--END-BANNER-->
    <div class="container">
        {{Breadcrumbs::render()}}
    </div>
    <section>
        <div class="container trendingdeals">
            <h2>Find Coupons for Everything</h2>
            <div class="trendingdealsprobox">
                <div class="categorilistcoupons cs_dkt_si">
                    @include('v3.coupons.everything')
                </div>
            </div>
        </div>
    </section>
    <section id="partner_deals_wrapper">
        <div class="container trendingdeals">
            <h2>Deals from partners website</h2>
            <div class="trendingdealsprobox cs_dkt_si" id="partner_deals">
                <ul>
                    @foreach( $partner_deals as $deal )
                        <li>
                            <a class="thumnail" href="{{route('vendor_page_v2',[create_slug($deal->key)])}}" target="_blank">
                                <div class="loansthumnailimgbox">
                                    <img class="productimg" src="{{getImageNew('')}}" data-src="{{get_file_url("images/coupons/logos/".create_slug($deal->key).".jpg")}}" alt="{{ucwords($deal->key)}}"/>
                                </div>
                                <div class="loans-container">
                                    <div class="product_name textcenter" onclick="window.open('{{route('vendor_page_v2',[create_slug($deal->key)])}}')">{{$deal->doc_count}}
                                        Offers
                                    </div>
                                    <div class="rate-starts" onclick="window.open('{{route('vendor_page_v2',[create_slug($deal->key)])}}')">
                                        Cashback upto 60%
                                    </div>
                                </div>
                                <span class="productbutton">Explore Offers</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <section id="coupons_wrapper">
        <div class="container trendingdeals">
            <h2>Coupons from your favourite stores</h2>
            <div class="explore-all-categori mtop"></div>
            <div id="coupons" class="couponsdealsbox cs_dkt_si">
                <ul>
                    @foreach( $coupons as $coupon )
                        <li>
                            <div class="thumnail coupon_thum" data-in-page="{{route('category_page_v2',[create_slug($coupon->category)])}}" data-type="{{isset($coupon->code) && !empty($coupon->code) ? "coupon" : "promotion"}}" data-out-page="{{route('coupon_out_page',[$coupon->offerid])}}" data-code="{{base64_encode($coupon->code)}}">
                                <div class="couponsthumnailimgbox">
                                    <img class="couponsproductimg" src="{{getImageNew('')}}" data-src="{{getCouponImage($coupon->image,'L')}}" alt="{{$coupon->vendor_name}} Image">
                                </div>
                                <div class="couponsdiscount_name">{{$coupon->title}}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <section>
        <div class="container trendingdeals">
            <h2>Best Coupons Today</h2>
            <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <?php $i = 0; ?>
                    @foreach($categories as $category => $coupons)
                        <li role="presentation" class="{{ ($i++==0) ? 'active' : '' }}">
                            <a href="#{{create_slug($category)}}" aria-controls="{{create_slug($category)}}" role="tab" data-toggle="tab">
                                {{unslug($category)}}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach($categories as $category => $coupons)
                        <div role="tabpanel" class="tab-pane {{ ($i++==0) ? 'active' : '' }}" id="{{create_slug($category)}}">
                            @include('v3.coupons.card2')
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>
    <section id="recent_offers_wrapper">
        <div class="container trendingdeals">
            <h2>Recently used offers</h2>
            <div class="trendingdealsprobox" id="recent_offers"></div>
        </div>
    </section>
    <!--THE-PART-14-->
@endsection
@section('scripts')
    <script src="{{get_file_url('js')}}/front.js" defer onload="frontJsLoaded()"></script>
    <script type="text/javascript">
        function loadCarousel() {}
    </script>
    <script>
        function frontJsLoaded() {
            CONTENT.uri = '{{route('coupon-ajax')}}';
            CONTENT.load('recent_offers', true);
        }
    </script>
@endsection