<div class=" col-xs-12 col-md-12">
    <div class="row">

        <div class="col-md-5 PR0 PL0">
            <a class="banner2 cc_mrb18" href="{{product_image($tab->single_image[0]->url)}}" {{checkLink($tab->single_image[0]->url)}} target="_blank">
                <img class="img-responsive" src="{{product_image($tab->single_image[0]->image_url)}}" alt="{{$tab->single_image[0]->alt}}"/>
            </a>
        </div>

        <div class="col-md-7">
            <div class="row">
                <div class="col-xs-12">
                    @foreach($tab->upcoming as $item )
                        <div class="col-md-6 PL0 PR0">
                            <a class="banner2 cc_mrb15" href="{{$item->url}}" target="_blank" {{checkLink($item->url)}}>
                                <img class="img-responsive" src="{{product_image($item->image_src)}}" alt="{{$item->alt}}"/>
                            </a>
                        </div>
                    @endforeach

                    <div class="col-md-12 PL0 PR0">


                        <div class="sub-title">
                            <span>{{$name->gadzet_type}}</span>
                            <ul class="customNavigation">
                                <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                                <li><a class="next"><i class="fa fa-angle-right"></i></a></li>

                            </ul>
                        </div>

                        <div id="owl-demo{{$carousel}}" class="owl-carousel owl-theme">
                            @foreach($tab->topten as $topten)
                                <div class="item">
                                    <div class="thumbnail">
                                        <a href="{{product_url_home($topten)}}" target="_blank">
                                            <img class="productmobimleft2" alt="{{$topten->name}}" title="{{$topten->name}}" src="{{product_image($topten->image_url,'XS')}}">
                                        </a>
                                        <div class="caption">
                                             <a href="{{product_url_home($topten)}}" title="{{$topten->name}}" target="_blank"> <h5>{{truncate($topten->name,20)}}</h5></a>
                                             <div class="phoneratting">
                      <div class="star-rating">
                         <span class="fa fa-star" data-rating="1"></span>
                         <span class="fa fa-star" data-rating="2"></span>
                         <span class="fa fa-star" data-rating="3"></span>
                         <span class="fa fa-star" data-rating="4"></span>
                         <span class="fa fa-star-o" data-rating="5"></span>
                     </div>
                       </div>
                                            <p>
                                                <a href="{{product_url_home($topten)}}" class="btn btn-default btn-product" role="button">Rs. {{number_format($topten->saleprice)}}</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>