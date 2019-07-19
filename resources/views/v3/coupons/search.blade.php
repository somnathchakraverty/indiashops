@extends("v3.master")
@section('page_content')
    <div class="container">            
                {{Breadcrumbs::render()}}           
        </div>    
    <section>
        <div class="container haddingsize">           
                <?php $coupon = collect($coupons)->first();?>               
                    <h1>{{$product_count}} {{ucwords($vendor_name)}} Coupons, Offers and Deals available today</h1>
        </div>
    </section>
    <section>
        <div class="container trendingdeals">
                    <div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#Coupons" aria-controls="Coupons" role="tab" data-toggle="tab">
                                        Coupons & Promotions ({{$product_count}})
                                    </a>
                                </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="Coupons">
                                <div class="catgprofullbox">
                                    @include('v3.coupons.card')
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="Deals">
                                <div class="catgprofullbox" id="vendor_coupons"></div>
                            </div>
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
    <section id="coupons_wrapper">
        <div class="container trendingdeals">            
                <h2>Coupons from your favourite stores</h2>               
                    <a class="explore-all-categori mtop" href="{{route('coupons_v2')}}">VIEW ALL Coupons
                        <span class="arrow">&#155;</span>
                    </a>
               
            
            <div id="coupons"></div>
        </div>
    </section>
    <section>
        <div class="container trendingdeals">           
                <h1>Find Coupons for Everything</h1>
               <a class="explore-all-categori" href="#">Explore all categories
                        <span class="arrow">&#155;</span></a>           
            <div class="categorilistbox">
                <div class="categorilist">
                    @include('v3.coupons.everything')
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{get_file_url('js')}}/front.js" defer onload="frontJsLoaded()"></script>
    <script src="{{get_file_url('js')}}/jquery.flexisel.js" defer onload="loadCarousel()"></script>
    <script type="text/javascript">
        function loadCarousel() {
            var interval = setInterval(function(){
                if( typeof $ != "undefined" )
                {
                    $("#flexiselDemo13").flexisel({
                        infinite: false
                    });
                    $("#flexiselDemo15").flexisel({
                        infinite: false
                    });
                    $("#kids3").flexisel({
                        infinite: false
                    });
                    $("#home4").flexisel({
                        infinite: false
                    });
                    $("#flexiselcoupons").flexisel({
                        infinite: false,
                        visibleItems: 7,
                        itemsToScroll: 7,
                    });

                    clearInterval(interval);
                }
            },500);
        }
    </script>
    <script>
        function frontJsLoaded(){
            var home_ajax_url = '{{route('v3_ajax_home')}}';
            CONTENT.uri = home_ajax_url;
            CONTENT.load('coupons', true);
            CONTENT.uri = '{{route('coupon-ajax')}}';
            CONTENT.load('recent_offers', true);
        }
    </script>
@endsection