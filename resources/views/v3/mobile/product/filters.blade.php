<!--THE-FILTER-->
<div id="applyfilter">
    <div class="leftpartfull">
    <div class="menuheadertop">
        <div class="filtertoppart">
            <a id="filter-close" href="#" class="filter-closetop"></a>
            <div class="applyhadding">FILTERS</div>
        </div>
        </div>
        <div class="part1" style="padding-top:13%;">
            <div class="accordionItem open">
                <div class="accordionItemHeading">Price
                    <span class="arrofilrig"></span>
                </div>
                <div class="accordionItemContent">
                    <div class="rangeslimobile">
                        <div class="uirangesli">
                            <div id="price-range" class=""></div>
                        </div>
                        <div class="colom">
                            <label>From</label>
                            <input type="number" name="minPrice" id="minPrice" value="{{$minPrice}}" class="form-control priceboxnew fltr__src" field="saleprice_min" min="{{$minPrice}}" max="{{$maxPrice}}"/>
                        </div>
                        <div class="colom">
                            <label>To</label>
                            <input type="number" name="maxPrice" id="maxPrice" value="{{$maxPrice}}" class="form-control priceboxnew fltr__src" field="saleprice_max" min="{{$minPrice}}" max="{{$maxPrice}}"/>
                        </div>
                        <button type="button" class="btn btn-default gobutton">Go</button>
                    </div>
                </div>
            </div>
        </div>
        @foreach($facets as $section => $facet )
            <?php $ignore = ['saleprice_min', 'saleprice_max', 'grp', 'filters_all', 'categories', 'price_ranges']; ?>
            @if( !in_array($section, $ignore) && count($facet->buckets) > 0 )
                <div class="part1">
                    <div class="accordionItem close">
                        <div class="accordionItemHeading">{{unslug($section)}}
                            <span class="arrofilrig"></span>
                        </div>
                        <div class="accordionItemContent">
                            <div class="checkbox {{$section}}">
                                @foreach( $facet->buckets as $b )
                                    @if( !empty($b->key) )
                                        <span class="attr_group">
                                            <input type="checkbox" id="chk{{$section}}-{{cleanID($b->key)}}" name="{{$section}}" field="{{$section}}" class="fltr__src" value="{{$b->key}}">
                                            @if( $section == 'vendor' )
                                                <label for="chk{{$section}}-{{cleanID($b->key)}}" class="attr_group_val">
                                                    <span></span>{{ucwords(config('vendor.name.'.$b->key ))}}
                                                    <b>(
                                                        <doc class="sec_count">{{$b->doc_count}}</doc>
                                                        )</b>
                                                </label>
                                            @else
                                                <label for="chk{{$section}}-{{cleanID($b->key)}}" class="attr_group_val">
                                                    <span></span>{{ucwords($b->key)}}
                                                    <b>(
                                                        <doc class="sec_count">{{$b->doc_count}}</doc>
                                                        )</b>
                                                </label>
                                            @endif
                                            </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="backtabbg">
            <a href="#" style="border:none;" class="applybutmob" id="apply_filter">
                <span class="filtappl"></span> APPLY
            </a>
        </div>
    </div>
</div>
<!--END-FILTER-->
<!--THE-SORTBY-->
<div id="openModal" class="modalDialog" style="display: none;">
    <div class="sortbytopnew">
        <div class="leftpartfull">
            <div class="filtertoppart"><a href="#closepopup" title="Close" class="closepopup">X</a>
                <div class="applyhadding">Sort By</div>
            </div>
            <div class="part2">
                <div class="checkbox" id="sorting_options">
                    <input type="radio" name="price" id="c5r" value="" class="fltr__src" field="sort" value="" checked>
                    <label for="c5r"><span></span>Newest First</label>
                    <input type="radio" name="price" id="c7r" class="fltr__src" field="sort" value="p-d">
                    <label for="c7r"><span></span>Price High to Low</label>
                    <input type="radio" name="price" id="c8r" class="fltr__src" field="sort" value="p-a">
                    <label for="c8r"><span></span>Price low to high</label>
                </div>
            </div>
        </div>
    </div>
</div>
<!--THE-BOTTOM-TAB-->
<tabloans class="show hide_filter">
    <div class="loanstabbg top">
        <ul>
            <li>
                <a href="#" id="applyfilter-toggle">
                    <span class="filticon"></span>Filters
                </a>
            </li>
            <li class="borderright">
                <a href="#openModal">
                    <span class="sorticon"></span>Sort By
                </a>
            </li>
        </ul>
    </div>
</tabloans>
<script>
    document.addEventListener('jquery_loaded', function (e) {
        var accItem = document.getElementsByClassName('accordionItem');
        var accHD = document.getElementsByClassName('accordionItemHeading');
        for (i = 0; i < accHD.length; i++) {
            accHD[i].addEventListener('click', toggleItem, false);
        }
        function toggleItem() {
            var itemClass = this.parentNode.className;
            if (itemClass == 'accordionItem close') {
                this.parentNode.className = 'accordionItem open';
            }
            else{
                this.parentNode.className = 'accordionItem close';
            }
        }
    });

    function uiLoaded() {}
</script>
<!--END-SORTBY-->