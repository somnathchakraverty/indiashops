<div class=" col-xs-12 col-md-12">
    <div class="row">
        <div class="col-md-3 PR0 PL0">
            <div class="sub-title"><span>{{$tab->heading}}</span></div>
            <ul class="product-list">
                @foreach($tab->brands_name as $content)
                    <li>
                        <div class="pull-left MT0">
                            <a href="{{$content->link}}" target="_blank">
                                <img class="logoname_mlc" alt="{{$content->alt}}"
                                     src="{{product_image($content->image_url)}}"/>
                            </a>
                        </div>
                        <aside class="PT15 logonametext"><a href="{{$content->link}}">{{$content->brand}}</a></aside>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="sns-snsbannertop col-md-9">
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-md-12 PL0 PR0">
                        <div class="sub-title"><span>{{$name->gadzet_type}}</span>
                            <ul class="customNavigation">
                                <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                                <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </div>
                        <div id="owl-demo{{$carousel}}" class="owl-carousel owl-theme">
                            @foreach($tab->topten as $topten)
                                <div class="item">
                                    <div class="thumbnail"><a href="{{product_url_home($topten)}}" target="_blank"> <img
                                                    class="productmobimlefttop"
                                                    src="{{product_image($topten->image_url,'XS')}}"
                                                    alt="{{$topten->name}}" title="{{$topten->name}}"> </a>
                                        <div class="caption">
                                            <a href="{{product_url_home($topten)}}" title="{{$topten->name}}"
                                               target="_blank"><h5>{{truncate($topten->name,20)}}</h5></a>
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
                                                <a href="{{product_url_home($topten)}}"
                                                   class="btn btn-default btn-product"
                                                   role="button">Rs. {{number_format($topten->saleprice)}}</a></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach </div>
                    </div>
                    <div class="col-xs-12 col-md-6 PL0 PR0">
                        <a class="banner2" target="_blank"
                           href="{{$tab->upcoming[0]->url}}" {{checkLink($tab->upcoming[0]->url)}}>
                            <img class="img-responsive" src="{{product_image($tab->upcoming[0]->image_src)}}"
                                 alt="{{$tab->upcoming[0]->alt}}"/>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xs-12 PR0">
                        <a class="banner2 cc_mrb15" target="_blank"
                           href="{{$tab->upcoming[1]->url}}" {{checkLink($tab->upcoming[1]->url)}}>
                            <img class="img-responsive" src="{{product_image($tab->upcoming[1]->image_src)}}"
                                 alt="{{$tab->upcoming[1]->alt}}"/>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xs-12 PR0">
                        <a class="banner2 cc_mrb15" target="_blank"
                           href="{{$tab->upcoming[2]->url}}" {{checkLink($tab->upcoming[2]->url)}}>
                            <img class="img-responsive" src="{{product_image($tab->upcoming[2]->image_src)}}"
                                 alt="{{$tab->upcoming[2]->alt}}"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
