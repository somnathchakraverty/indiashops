<div class="filters">Filters</div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#price" aria-expanded="true" aria-controls="price">
                    Price Range
                    <span class="fonticontab"></span></a>
            </h4>
        </div>
        <div id="price" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body pleft">
                <div class="panelboxfil">
                    <div class="uirangesli">
                        <div id="price-range" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                            <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                            <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                        </div>
                    </div>
                    <div class="colom">
                        <label>From</label>
                        <input type="number" name="minPrice" id="minPrice" value="{{$minPrice}}" class="form-control priceboxnew fltr__src" data-field="saleprice_min" min="{{$minPrice}}" max="{{$maxPrice}}"/>
                    </div>
                    <div class="colom">
                        <label>To</label>
                        <input type="number" name="maxPrice" id="maxPrice" value="{{$maxPrice}}" class="form-control priceboxnew fltr__src" data-field="saleprice_max" min="{{$minPrice}}" max="{{$maxPrice}}"/>
                    </div>
                    <button type="button" class="btn btn-default gobutton price_filter_go">Go</button>
                    @if(isset($facets->price_ranges))
                        <div class="checkbox">
                            {!! range_html($facets->price_ranges, $minPrice, $maxPrice ) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @foreach($facets as $section => $facet )
        <?php $ignore = ['saleprice_min', 'saleprice_max', 'grp', 'filters_all', 'categories', 'price_ranges']; ?>
        @if( !in_array($section, $ignore) && count($facet->buckets) > 0 )
            <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#filter{{$section}}" aria-expanded="true">
                            {{unslug($section)}}
                            <span class="fonticontab"></span></a>
                    </h4>
                </div>
                <div id="filter{{$section}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body pleft">
                        <div class="panelboxfil">
                            @if(count($facet->buckets) > 5)
                                <input type="text" class="form-control brandssearch search_attr" placeholder="Search {{unslug($section)}}">
                                <div class="searchiconcat"></div>
                            @endif
                            <div class="checkbox {{$section}}">
                                @foreach( $facet->buckets as $b )
                                    @if( !empty($b->key) )
                                        <span class="attr_group">
                                            <input type="checkbox" id="chk{{$section}}-{{cleanID($b->key)}}" name="{{$section}}" data-field="{{$section}}" class="fltr__src" value="{{$b->key}}">
                                            @if( $section == 'vendor' )
                                                <label for="chk{{$section}}-{{cleanID($b->key)}}" class="attr_group_val">
                                                    <span></span>{{ucwords(config('vendor.name.'.$b->key ))}}
                                                    (<b class="sec_count">{{$b->doc_count}}</b> )
                                                </label>
                                            @else
                                                <label for="chk{{$section}}-{{cleanID($b->key)}}" class="attr_group_val">
                                                    <span></span>{{ucwords($b->key)}}
                                                    (<b class="sec_count">{{$b->doc_count}}</b> )
                                                </label>
                                            @endif
                                            </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
