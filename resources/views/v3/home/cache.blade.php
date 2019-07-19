<section>
    <div class="container trendingdeals">
        <h2>Find lowest price for anything </h2>
        <a class="expcat" href="{{url('all-categories')}}">Explore all categories
            <span class="arrow">&rsaquo;</span></a>
        <div class="categorilistbox">
            {!! getAjaxWidget('find_lowest') !!}
        </div>
    </div>
</section>
<section id="deals_on_phone_wrapper">
    <div class="container trendingdeals">
        <h2>Top deals on phones</h2>
        <div id="deals_on_phone">
            {!! $deals_on_phone !!}
        </div>
    </div>
</section>
<section id="upcoming_mobiles_wrapper">
    <div class="container trendingdeals">
        <h2>Upcoming Mobiles</h2>
        <a class="expcat" href="{{route('upcoming_mobiles')}}">VIEW ALL UPCOMING MOBILES
            <span class="arrow">&rsaquo;</span>
        </a>
        <div id="upcoming_mobiles">
            {!! $upcoming_mobiles !!}
        </div>
    </div>
</section>
<section id="trending_comp_wrapper">
    <div class="container trendingdeals">
        <h2>Trending Comparison</h2>
        <div id="trending_comp">
            {!! $trending_comp !!}
        </div>
    </div>
</section>
<section id="upcoming_mobiles_wrapper">
    <div class="container trendingdeals">
        <h2>Recently Launched</h2>
        <div id="upcoming_mobiles">
            {!! $recently_lanched !!}
        </div>
    </div>
</section>
<section id="group_deals_wrapper">
    <div class="container trendingdeals">
        <h2>Top deals to sizzle up your presence</h2>
        <div id="group_deals">
            {!! $group_deals !!}
        </div>
    </div>
</section>
<section id="gadget_tips_wrapper">
    <div class="container trendingdeals">
        <h2>Tips on gadgets, fashion and much more</h2>
        <a class="expcat" href="http://www.indiashopps.com/blog" target="_blank">
            VIEW ALL <span class="arrow">&rsaquo;</span>
        </a>
        <div class="trendingdealsprobox" id="gadget_tips">
            {!! $gadget_tips !!}
        </div>
    </div>
</section>

<!-- Add new link section -->