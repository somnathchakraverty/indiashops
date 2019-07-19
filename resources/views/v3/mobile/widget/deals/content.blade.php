<div class="whitecolorbg">
    <div class="container">
    	<h2>Deals from partners website</h2>
        <div class="tab-content">
            <div class="css-carousel">               
                    <ul>
                        @foreach( $deals as $deal )
                            <li>                              
                                    <a class="thumnail" href="{{route('vendor_page_v2',[create_slug($deal->key)])}}" target="_blank">
                                        <div class="loansthumnailimgbox">
                                            <img class="productimg" data-src="{{get_file_url("images/coupons/logos/".create_slug($deal->key).".jpg")}}" alt="{{ucwords($deal->key)}}"/>
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
            <a href="{{url('coupons')}}" class="allcateglink" target="_blank">
                View all offers
                <span class="right-arrow"></span>
            </a>        
    </div>
</div>