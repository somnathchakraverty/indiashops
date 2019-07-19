<div class="modal-content popupwidth">
    <button type="button" class="close popupright10" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <h3><span>Wait!</span> Best Offers, Just for you!</h3>
    <div class="productdetailspopup">
        <div class="col-md-3">
            <a class="thumnailimgbox widthimgbox">
                <img class="productimg widthimgpro" src="{{getImageNew($product->image,'M')}}" alt="productimg">
                @if( isset($product->old_price) && $product->old_price > $product->price )
                    <div class="offproduct">
                        {{percent($product->old_price,$product->price)}}% OFF
                    </div>
                @endif
            </a>
        </div>
        <div class="col-md-9">
            <div class="highlightspopup">
                <h4>{{$product->name}}</h4>
                <ul>
                    {!! miniSpecDetail($product->mini_spec) !!}
                </ul>
            </div>
            <div class="popupbuttonbox">
                <div class="col-md-6">
                    <div class="flpricepopup">Rs {{number_format($product->price)}}
                        @if( isset($product->old_price) && $product->old_price > $product->price )
                            <span>Rs {{number_format($product->old_price)}}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6" id="store_info">
                    <a href="#" id="store_url" class="productgoto"><span id="store_name"></span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="popupproductlistbg">
        <div class="col-md-7">
            <h3>Related Products</h3>
        </div>
        <div class="col-md-5">
            <div class="input-group mtop20">
                <form id="product_search" class="form_search" action="/search" method="get">
                    <input type="text" class="form-control Search-anything auto_search searchboxpopup" name="x" placeholder="Search Product">
                <span class="input-group-btn">
                    <button class="btn btn-default searchbutton searchbuttonpopup buttonbgcolor productpopupnew" type="button">
                        <div class="searchicon2"></div>
                    </button>
                </span>
                </form>
            </div>
        </div>
        <div class="listproductlast cs_brd_si">
            <ul id="popupproduct" data-items="4">
                @foreach($products as $product)
                    <?php $product = $product->_source ?>
                    <li class="popupproli">
                        <a href="{{product_url($product)}}" target="_blank">
                            <div class="popuplistproduct">
                                <div class="comparestickyimgbox">
                                    <img class="comparestickyimgpro" src="{{getImageNew($product->image_url,'M')}}" alt="productimg">
                                </div>
                                <div class="popuplistproductbox">
                                    <div class="comparestickyproduct_name">{{$product->name}}</div>                                   
                                        <div class="str-rtg">
                                            @if(isset($product->rating))
                                                <span style="width:{{percent($product->rating,5)}}%" class="str-ratg"></span>
                                            @endif
                                        </div>                                  
                                    <div class="product_price">Rs {{number_format($product->saleprice)}}</div>
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<script>
    $(".cs_brd_si").cssCarousel();

    search_box = $("#product_search");

    $("form .auto_search").autocomplete({
        minLength: 2,
        source: completion,
        select: function (event, ui) {
            $("form .auto_search").val(ui.item.label);
            search_box.submit();
            return false;
        },
        position: {my: "left bottom", at: "left top"}
    });

    $(document).on('submit', '#product_search', function (e) {
        var search_text = $(this).find('.auto_search').val();

        if (typeof cat_id == "undefined") {
            cat_id = 0;
        }

        var search_url = ajax_url + "/search/" + cat_id + "/" + create_slug(search_text);

        window.location = search_url;

        return false;
    });

    function create_slug(str) {
        str = str.toLowerCase();
        str = str.replace(/\s/g, "-");
        str = str.replace(/,/g, "-");

        return str;
    }
</script>