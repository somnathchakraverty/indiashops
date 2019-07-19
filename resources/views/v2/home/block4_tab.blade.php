<div class=" col-xs-12 col-md-12">
    <div class="row">

        <div class="col-md-6">
            <div class="row">
                <div class="col-xs-12 PR0">
                    @foreach($tab->left_side_image as $image)
                    
                    <div class="col-sm-6 col-xs-12 PL0 PR0"><a class="banner2 cc_mrb15" target="_blank" href="{{product_image($image->url)}}" {{checkLink($image->url)}}>
                            <img class="img-responsive" src="{{product_image($image->image_url)}}" alt="{{$image->alt}}"/></a>
                    </div>
                    @endforeach                  
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="col-md-12 PR0 PL0">
                <a class="banner2 cc_mrb18" target="_blank" href="{{$tab->upcoming[0]->url}}" {{checkLink($tab->upcoming[0]->url)}}> <img class="img-responsive" src="{{product_image($tab->upcoming[0]->image_url)}}" alt="{{$tab->upcoming[0]->alt}}"/></a>
            </div>

            <div class="col-md-12 PL0 PR0">
                <div class="sub-title" style="margin-top:15px;">
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
                                    <img class="productmobimlefttopman" alt="{{$topten->name}}" title="{{$topten->name}}" src="{{product_image($topten->image_url,'XS')}}">
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