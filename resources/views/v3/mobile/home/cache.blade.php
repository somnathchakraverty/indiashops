<!--THE-PART-1-->
<section>
    <div class="whitecolorbg">
        <div class="container">
            <h2>Find lowest price for anything</h2>
            <div class="css-carouseltab padding-btm0">
                <ul>
                    <li>
                        <a href="{{url('mobile/mobiles-price-list-in-india.html')}}" class="thumnail1">
                            <div class="topbrdmob"></div>
                            <span>Mobiles</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('mobile/tablets-price-list-in-india.html')}}" class="thumnail1">
                            <div class="topbrdtab"></div>
                            <span>Tablets</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/camera/cameras-dslrs-more-price-list-in-india.html')}}" class="thumnail1">
                            <div class="topbrdcam"></div>
                            <span>Cameras</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('electronics/led-tv-price-list-in-india.html')}}" class="thumnail1">
                            <div class="topbrdtv"></div>
                            <span>LED TV</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('computers/laptops-price-list-in-india.html')}}" class="thumnail1">
                            <div class="topbrdlap"></div>
                            <span>Laptops</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('appliances/heaters-fans-coolers/air-purifiers-price-list-in-india.html')}}" class="thumnail1">
                            <div class="topbrdcon"></div>
                            <span>Air Purifiers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{url('coupons')}}" class="thumnail1">
                            <div class="topbrdcou"></div>
                            <span>Coupons</span>
                        </a>
                    </li>
                </ul>
            </div>
            <a href="{{url('all-categories')}}" class="allcateglink">Explore all categories
                <span class="right-arrow"></span>
            </a>
        </div>
    </div>
</section>
<!--END-PART-1-->
<!--THE-PART-4-->
<section id="deals_on_phone">
    {!! $deals_on_phone !!}
</section>
<section id="deals_on_phone">
    {!! $upcoming_mobiles !!}
</section>
<!--END-PART-4-->

<!--THE-PART-5-->
<section id="trending_comp">
    {!! $trending_comp !!}
    {{--<a href="#" class="productbutton orangebutton">start new comparison</a>--}}
</section>
<!--END-PART-5-->

<!--THE-PART-8-->
<section id="group_deals">
    {!! $group_deals !!}
</section>
<!--END-PART-8-->
<!--THE-PART-9-->
<section id="gadget_tips">
    {!! $gadget_tips !!}
</section>
<!--END-PART-9-->