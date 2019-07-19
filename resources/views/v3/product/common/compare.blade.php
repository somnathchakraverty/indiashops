@if( isset($product) && isset($products) && isset($facets) && is_array($products) )
    <div class="comparison">Compare with Competitors</div>
    <div class="comparisontable overflow">
        <div class="filtercompetitorstext">FILTER COMPETITORS BY</div>
        <div class="pricerangebox">
            <div class="col-md-5">
                <div class="Pricerangetext">Price range</div>
                <div class="rangepart">
                    <div id="price-range">
                        <div class="ui-slider"></div>
                    </div>
                </div>
                <div class="colompdp">
                    <label>From</label>
                    <input type="number" name="minPrice" id="minPrice" value="{{$facets->saleprice_min->value}}" class="form-control priceboxnewpdp __fltr_detail__" field="saleprice_min" min="{{$facets->saleprice_min->value}}" max="{{$facets->saleprice_max->value}}">
                </div>
                <div class="colompdp">
                    <label>To</label>
                    <input type="number" name="maxPrice" id="maxPrice" value="{{$facets->saleprice_max->value}}" class="form-control priceboxnewpdp __fltr_detail__" field="saleprice_max" min="{{$facets->saleprice_min->value}}" max="{{$facets->saleprice_max->value}}">
                </div>
            </div>

            <div class="col-md-7">
                <div class="Pricerangetext">Show Only <span id="appliedFilter"></span></div>
                <?php $i = 1; $ignore = ['price_ranges', 'grp', 'type', 'resolution_type'] ?>
                @foreach($facets as $section => $facet)
                    @if( !in_array($section, $ignore ) && isset($facet->buckets) && $facet->buckets > 4 && $i <= 4 && strlen($section) <= 20 )
                        <div class="androidpart">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true" aria-expanded="false">
                                {{unslug($section)}}
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu top63">
                                @foreach($facet->buckets as $f)
                                    @if( !empty($f->key) )
                                        <?php
                                        if ($section == 'vendor'):
                                            $key = config('vendor.name.' . $f->key);
                                        else:
                                            $key = $f->key;
                                        endif;
                                        ?>
                                        <li class="checkbox {{create_slug($f->key)}}">
                                            <input type="checkbox" class="__fltr_detail__" id="chkbattery-{{create_slug($f->key)}}" value="{{$f->key}}" name="{{$section}}" field="{{$section}}"/>
                                            <label for="chkbattery-{{create_slug($f->key)}}">
                                                <span></span>{{ucwords($key)}}</label>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <?php $i++; ?>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="comparelistpdp" id="right_container">
            <div class="comparelistboxpdp">
                <div class="comparelistproimg">
                    <img class="comparison-producttowimg" src="{{getImageNew($product->image,"S")}}" alt="{{$product->name}} Image">
                </div>
                <div class="comparelisttow-container">
                    <div class="product_namecomp">{{$product->name}}</div>
                    <div class="startingfrom">Starting From</div>
                    <div class="pricecompto">Rs {{number_format($product->price)}}</div>
                </div>
                <div class="fulfucontnew">
                    <div class="thisphone"></div>
                    @if(isset($product->mini_spec))
                        @foreach(miniSpecs($product->mini_spec,6) as $spec)
                            <div class="comproductfu">{!! $spec !!}</div>
                        @endforeach
                    @endif
                </div>
                <a href="#specifications" class="adtocardbuttonpdp bottom11">See specs</a>
            </div>
            <div class="comtowprorightpart" id="compare_wrapper">
            <div class="cs_dkt_si">
                <ul data-items="3">
                    @foreach($products as $product)
                        <?php $product = $product->_source; ?>
                        <li>
                            <div class="comparelistboxpdp">
                                <div class="comparelistproimg">
                                    <img class="comparison-producttowimg" src="{{getImageNew($product->image_url,"S")}}" alt="{{$product->name}} Image">
                                </div>
                                <div class="comparelisttow-container">
                                    <div class="product_namecomp">{{$product->name}}</div>
                                    <div class="startingfrom">Starting From</div>
                                    <div class="pricecompto">Rs {{number_format($product->saleprice)}}</div>
                                </div>
                                <div class="fulfucontnew">
                                    @if(isset($product->mini_spec))
                                        @foreach(miniSpecs($product->mini_spec,6) as $spec)
                                            @if(!empty($spec))
                                                <div class="comproductfu">
                                                    <span class="glyphicon glyphicon-thumbs-up thumbs-upcolor" aria-hidden="true"></span> {!! $spec !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    <a href="{{product_url($product)}}" target="_blank" class="read-more">Read more</a>
                                </div>
                                <a cat="{{$product->category_id}}" prod-id="{{$product->id}}" class="adtocardbuttonpdp add_to_compare">Add
                                    to Compare</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        change_min_max_price('{{$facets->saleprice_min->value}}', '{{$facets->saleprice_max->value}}');

        $("#price-range").slider({
            range: true,
            min: parseInt('{{$facets->saleprice_min->value}}'),
            max: parseInt('{{$facets->saleprice_max->value}}'),
            animate: "slow",
            values: [parseInt('{{$facets->saleprice_min->value}}'), parseInt('{{$facets->saleprice_max->value}}')],
            change: function (event, ui) {
                var sMinPrice = ui.values[0];
                var sMaxPrice = ui.values[1];

                if (!ListingPage.model.manual_slide) {
                    $("#minPrice").val(sMinPrice);
                    $("#maxPrice").val(sMaxPrice);
                    $("#minPrice").change();
                }
            },
            slide: function (event, ui) {
                var sMinPrice = ui.values[0];
                var sMaxPrice = ui.values[1];
                $("#minPrice").val(sMinPrice);
                $("#maxPrice").val(sMaxPrice);
            },
            animate: "slow",
        });
    </script>
    <style>
        .androidpart li { padding: 2px 0px; }
        input[type="checkbox"] + label { font-size: 12px !important; }
        .btn-danger { font-size: 12px !important; padding: 3px !important; float: right !important; font-weight: bold !important; }
        .top63 { top: 63px !important; width: 172px; }
    </style>
@endif