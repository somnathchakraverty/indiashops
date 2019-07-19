@if(isset($products) && !empty($products))
    @include("v3.mobile.product.carousel")
    @if(isset($brand_widget) && $brand_widget)
        <?php
        $p = $products[0]->_source;

        if (in_array($p->grp, config('listing.brand.groups'))) {
            $brand_url = route('brands.listing', [cs($p->grp), cs($p->brand), cs($p->category)]);
        } else {
            $brand_url = route('brand_category_list', [cs($p->brand), cs($p->grp), cs($p->category)]);
        }
        ?>
        <a href="{{$brand_url}}" class="allcateglink">VIEW ALL {{$p->brand}} {{$p->category}}
            <span class="right-arrow"></span>
        </a>
    @endif
@endif