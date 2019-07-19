<ul id="goto_section">
    <li class="tab">
        <span class="goto" data-href="demo-1">Overview</span>
    </li>
    @if(isset($vendors) && !empty($vendors))
        <li class="tab price_nav">
            <span class="goto" data-href="product_vendor_wrapper">Prices</span>
        </li>
    @endif
    @if(isset($main_product->description) && !empty($main_product->description))
        <li class="tab detail_tab">
            <span class="goto" data-href="details">Details</span>
        </li>
    @endif
    @if(isset($main_product->specification) && !empty($main_product->specification))
        <li class="tab specs">
            <span class="goto" data-href="specs">Specs</span>
        </li>
    @endif
    @if(isset($expert_data) && !empty($expert_data))
        <li class="tab specs">
            <span class="goto" data-href="expert_review">Reviews</span>
        </li>
    @endif
    @if(isset($compare_predecessor) && !empty($compare_predecessor))
        <li class="tab specs">
            <span class="goto" data-href="compare_pred_wrapper">Comparison</span>
        </li>
    @endif
    @if(isset($youtube_url) && !empty($youtube_url))
        <li class="tab specs">
            <span class="goto" data-href="youtube_player">Video</span>
        </li>
    @endif
    @if(isset($compare_products) && count($compare_products) > 0)
        @if(isset($main_product->grp) and ($main_product->grp != "women") and ($main_product->grp != "men") and ($main_product->grp != "kids") )
            <li class="tab compare_sec">
                <span class="goto" data-href="compare_sec">Competitors</span>
            </li>
        @endif
    @endif
    @if(isset($faqs) && is_array($faqs))
        <li class="tab faq">
            <span class="goto" data-href="faqs">FAQs</span>
        </li>
    @endif
</ul>