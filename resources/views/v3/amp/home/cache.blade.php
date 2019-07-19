<!--THE-SECTION-1-->
<section>
    <div class="whitecolorbg">
        <div class="container">
        <h2>Find lowest price for anything</h2>
            <amp-carousel class="full-bottom" height="150" layout="fixed-height" type="carousel">
                {!! getAjaxWidget('find_lowest') !!}
            </amp-carousel>
            <div class="allcateglink">
                <a href="{{route('all-cat')}}"> Explore all categories
                    <i class="fa fa-angle-right right-arrow"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!--END-SECTION-1-->
<!--THE-SECTION-4-->
<section>
    <div class="whitecolorbg">
        <div class="container">
        <h2>Top Deals on phones</h2>
            {!! $deals_on_phone !!}
        </div>
    </div>
</section>
<section>
    <div class="whitecolorbg">
        <div class="container">
        <h2>Upcoming Mobiles</h2>
            {!! $upcoming_mobiles !!}
            <div class="allcateglinkphone">
                <a href="{{route('upcoming_mobiles')}}">
                    VIEW ALL UPCOMING PHONES <i class="fa fa-angle-right right-arrow"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<!--END-SECTION-4-->

<!--THE-SECTION-5-->
<section>
    <div class="whitecolorbg">
        <div class="container bder_bott">
         <h2>Trending Comparison</h2>
            {!! $trending_comp !!}
        </div>
    </div>
</section>
<!--END-SECTION-5-->
<!--THE-SECTION-8-->
<section>
    <div class="whitecolorbg">
        <div class="container bder_bott">
        <h2>Top deals to sizzle up your presence</h2>
            {!! $group_deals !!}
        </div>
    </div>
</section>
<!--END-SECTION-8-->
<!--THE-SECTION-9-->
<section>
    <div class="whitecolorbg">
        <div class="container">
        <h2>Tips on gadgets, fashion & much more</h2>
            {!! $gadget_tips !!}
            <div class="allcateglink">
                <a href="https://www.indiashopps.com/blog">View all <i class="fa fa-angle-right right-arrow"></i></a>
            </div>
        </div>
    </div>
</section>
<!--END-SECTION-9-->