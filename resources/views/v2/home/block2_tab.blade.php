<div class=" col-xs-12 col-md-12">
  <div class="row">
    <div class="sns-snsbannertop col-md-8">
      <div class="row">
        <div class="col-xs-12 PL0">
          <div class="col-md-6 col-xs-12 PL0 PR0"> <a class="banner2 cc_mrb15" target="_blank" href="{{$tab->upcoming[0]->url}}" {{checkLink($tab->upcoming[0]->url)}}> <img class="img-responsive" src="{{product_image($tab->upcoming[0]->image_src)}}" alt="{{$tab->upcoming[0]->alt}}"/> </a> </div>
          <div class="col-md-6 col-xs-12 PR0"> <a class="banner2 cc_mrb15" target="_blank" href="{{$tab->upcoming[1]->url}}" {{checkLink($tab->upcoming[1]->url)}}> <img class="img-responsive" src="{{product_image($tab->upcoming[1]->image_src)}}" alt="{{$tab->upcoming[1]->alt}}"/> </a> </div>
          
            <div class="sub-title"> <span>{{$name->gadzet_type}}</span>
              <ul class="customNavigation">
                <li><a class="prev prevtab"><i class="fa fa-angle-left"></i></a></li>
                <li><a class="next"><i class="fa fa-angle-right"></i></a></li>
              </ul>
            </div>
            <div id="owl-demo{{$carousel}}" class="owl-carousel owl-theme"> @foreach($tab->topten as $topten)        
              <div class="item">
                <div class="thumbnail"> <a href="{{product_url_home($topten)}}" target="_blank"> <img class="productmobimleft2" alt="{{$topten->name}}" title="{{$topten->name}}" src="{{product_image($topten->image_url,'XS')}}"> </a>
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
                    <a href="{{product_url_home($topten)}}"  target="_blank" class="btn btn-default btn-product" role="button">Rs. {{number_format($topten->saleprice)}}</a> </p>
                  </div>
                </div>
              </div>
              @endforeach </div>
         
        </div>
      </div>
    </div>
    <div class="col-md-4 PL0">
      <div class="sub-title"><span>{{$tab->right_side[1]->heading}}</span></div>
      <ul class="product-listtopmobile">
        @foreach($tab->right_side[0] as $best)  
        <li class="P15">
        
          <div class="pull-left"> 
          <div class="mobileimleftnew"><a target="_blank" href="{{product_url_home($best)}}"> <img class="productmobimleft" alt="100%x200" src="{{product_image($best->image_url,'XS')}}"> </a> </div>
          
          </div>
          
          <aside> <a href="{{product_url_home($best)}}" target="_blank" title="{{$best->name}}">{{truncate($best->name,40)}}</a> 
          <div class="phonerattinghome">
                      <div class="star-rating"> 
                         <span class="fa fa-star" data-rating="1"></span> 
                         <span class="fa fa-star" data-rating="2"></span> 
                         <span class="fa fa-star" data-rating="3"></span> 
                         <span class="fa fa-star" data-rating="4"></span> 
                         <span class="fa fa-star-o" data-rating="5"></span> 
                     </div>
                       </div>
                       <span class="pricehome">Rs. {{number_format($best->saleprice)}}</span> </aside>
          
        </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
