<div class="user-dash-info linkbg p-3 rounded mb-5">
    <div class="border-bottom more_content_wrapper">
        <div class="more-less-product1">
            <p><strong>How to receive &amp; avail Cashback</strong></p>
            <p>You can avail <strong>Cashback</strong> in two different ways:</p>
            <p><strong>Option 1:</strong></p>
            <ul>
                <li>Step 1: Select your favorite portal from below list</li>
                <li>Step2: Click on the "Activate Cashback"</li>
                <li>Step 3: Buy the product & Get Cashback credited in your account.</li>
            </ul>
            <p><strong>Option 2:</strong></p>
            <ul>
                <li>Step 1: Browser our website and choose your product</li>
                <li>Step 2: Click on "Go to Store"</li>
                <li>Step 3: Buy the Product > Get Cashback credited in your account.</li>
            </ul>
        </div>
        <a href="javascript:void(0)" class="moreproduct cas_bak">Read More <span>&rsaquo;</span></a>
    </div>
    <div class="trendingdealsprobox">
        <div class="cs_dkt_si" data-items="5">
            <ul class="vendors">
                @foreach(getVendorSettings() as $vendor_id => $vendor)
                    <li>
                        <a class="thumbnail vendor" href="{{route('vendor_redirect_page',[$vendor_id])}}" target="_blank">

                            <div class="vimg">
                                <img class="cshcoupons" src="{{config('vendor.logo.'.$vendor_id)}}"/>
                            </div>
                            <div class="vcb cas_bak">
                                {{$vendor['cashback_rate']}}
                            </div>
                            <div class="call_to_action">
                                <button class="productbutton">Activate Cashback</button>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>