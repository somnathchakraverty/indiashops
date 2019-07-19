<section>
    @if( isset($slider[$key]) )
    <div class="container">
        <div class="catbannertop">
            @if( isset($slider[$key]->refer_url) && !empty($slider[$key]->refer_url) )
                <a href="{{$slider[$key]->refer_url}}" target="_blank">
                    <img class="img-responsive" src="{{$slider[$key]->image_url}}" alt="{{$slider[$key]->alt}}">
                </a>
            @else
                <img class="img-responsive" src="{{$slider[$key]->image_url}}">
            @endif
        </div>
    </div>
    @endif
    <div class="fullbgnewtop">
        <h4>{{$category->group_name}}'s {{$category->name}}</h4>
        <div class="container">
            <!-- Elastislide Carousel -->
            <ul id="carousel-{{create_slug($category->name)}}" class="elastislide-list">
                @foreach( $category->children as $child )
                <?php
                    if( !empty($cat_name) ) $category->group_name = $cat_name;
                    $cat_image = str_replace("100x100","160x180",$child->image);
                ?>
                <?php $url = newUrl( create_slug($category->group_name)."/".create_slug( $category->name )."/".seoUrl( create_slug($child->name) ) ); ?>
                    <li>
                        <div class="noncomproductnew">
                            <div class="noncomimgfixed">
                                <a href="{{$url}}">
                                    <img alt="{{$child->name}} image" title="{{$child->name}}" src="{{$cat_image}}" class="catcomproductsizenew" />
                                </a></div>
                            <div class="catpagehadding">
                                <h5>{{$child->name}}</h5>
                                <div class="uptodiscount">Up to <span>40%-70%</span> OFF</div>
                                <a href="{{$url}}" title="Explore More {{$child->name}}" target="_blank" class="catpricebtn-product" role="button">Explore More</a> </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <!-- End Elastislide Carousel -->
        </div>
    </div>
    @if( count(config("brands.$category->name") ) > 0 )
        <div class="fullbgnewtop">
            <h4>TOP {{$category->name}} BRANDS</h4>
            <div class="container">
                <div class="topbrandscat">
                    <ul>
                        @foreach(config("brands.$category->name") as $brand => $image )
                            <?php $brand_url = route('brand_category_list', [
                                    create_slug($brand),
                                    create_slug($category->group_name),
                                    create_slug($category->name)
                            ]); ?>
                            <li>
                                <a href="{{$brand_url}}">
                                    <img src="{{asset('assets/v2/')}}/images/cat/brands/{{$image}}" alt="brand logo" title="{{$brand}} {{$category->name}}" data-toggle="tooltip"/>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
</section>