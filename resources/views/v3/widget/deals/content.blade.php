<div style="clear:both"></div>
<div class="cs_dkt_si">
    <ul>
        @foreach( $deals as $deal )
            <li class="thumnail">             
                    <a href="{{route('vendor_page_v2',[create_slug($deal->key)])}}" target="_blank">
                        <div class="loansthumnailimgbox">
                            <img class="productimg" src="{{getImageNew("","M")}}" data-src="{{get_file_url("images/coupons/logos/".create_slug($deal->key).".jpg")}}" alt="{{ucwords($deal->key)}}"/>
                        </div>
                        <div class="loans-container">
                            <span class="product_name textcenter" onclick="window.open('{{route('vendor_page_v2',[create_slug($deal->key)])}}')">{{$deal->doc_count}}
                                Offers
                            </span>
                            <span class="rate-starts" onclick="window.open('{{route('vendor_page_v2',[create_slug($deal->key)])}}')">
                                Cashback upto 60%
                            </span>
                        </div>
                        <span class="productbutton">Explore Offers</span>
                    </a>               
            </li>
        @endforeach
    </ul>
</div>