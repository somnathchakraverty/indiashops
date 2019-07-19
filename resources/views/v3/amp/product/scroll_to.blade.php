<div class="product-tabs">
    <ul class="tabsproduct" id="goto_section">
        <amp-carousel class="full-bottom" height="35" layout="fixed-height" type="carousel">
            <li class="tab">
                <a class="activetoptab" href="#Overview" on="tap:overview.scrollTo(duration=400)">Overview</a>
            </li>
            @if(isset($page_type) && $page_type == "comparative" )
                @if(isset($vendors) && !empty($vendors))
                    <li class="tab price_nav">
                        <a href="#pricepart" on="tap:pricepart.scrollTo(duration=400)">Prices</a>
                    </li>
                @endif
            @endif
            @if(isset($main_product->description) && !empty($main_product->description))
                <li class="tab detail_tab">
                    <a href="#details" on="tap:detail_section.scrollTo(duration=400)">Details</a>
                </li>
            @endif
            @if(isset($main_product->specification) && !empty($main_product->specification))
                <li class="tab specs">
                    <a href="#Specs" on="tap:specs.scrollTo(duration=400)">Specs</a>
                </li>
            @endif
            @if(isset($expert_data) && !empty($expert_data))
                <li class="tab reviews">
                    <a href="#reviews" on="tap:review_sec.scrollTo(duration=400)">Reviews</a>
                </li>
            @endif
            @if(isset($compare_predecessor) && !empty($compare_predecessor))
                <li class="tab compare">
                    <a href="#comparison" on="tap:compare_pred_wrapper.scrollTo(duration=400)">Comparison</a>
                </li>
            @endif
            @if(isset($youtube_url) && !empty($youtube_url))
                <li class="tab video">
                    <a href="#videos" on="tap:videos_sec.scrollTo(duration=400)">Video</a>
                </li>
            @endif
            @if(isset($compare_products) && !empty($compare_products))
                @if(isset($main_product->grp) and ($main_product->grp != "women") and ($main_product->grp != "men") and ($main_product->grp != "kids") )
                <li class="tab comp_sec">
                    <a href="#compare_sec" on="tap:compare_sec.scrollTo(duration=400)">Competitors</a>
                </li>
                @endif
            @endif
            @if(isset($faqs) && is_array($faqs))
                <li class="tab faq">
                    <a href="#faqs" on="tap:faq_section.scrollTo(duration=400)">FAQs</a>
                </li>
            @endif
       </amp-carousel>
    </ul>
</div>