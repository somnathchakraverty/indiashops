<!-- $aggr is the variable for the filter data..  -->
<?php //echo "<PRE>"; print_r( $aggr ); exit;?>
<?php $categories = (isset( $aggr->grp ) ) ? $aggr->grp : array(); ?>
<?php if(isset($aggr->categories)) unset($aggr->categories); ?>
<div id="applyfilter">
<div class="leftpartfull"> <a id="filter-close" href="#" class="btn btn-lg pull-right toggle"><i class="glyphicon glyphicon-remove"></i></a></div>
<div class="applyhadding">APPLY FILTER</div>
<div class="filterdestop">
<div id="wrapper" style="position:relative">
    <div id="" style="position:relative">
        <div id="wrapper1" style="position:relative">
            <div class="" id="sidebar">
                <div id='product-left-fixed-menu' class="nano-content">
                    <ul >
                        @if($isSearch && empty($category_id) && $route == 'search')
                            <li class='active has-sub'><a href='#'>Category</a>
                                <div class="nano category_nano">
                                    <div class="nano-content">
                                        <ul  style="width: 95%;">
                                            <?php foreach( $categories->buckets as $ccat ): ?>
                                            <li class=' has-sub'>
                                                <a><?=ucwords($ccat->key)?> ( <?=$ccat->doc_count?> ) </a>
                                                <?php if( isset( $ccat->category_id ) && is_object( $ccat->category_id ) ): ?>
                                                <ul>
                                                    <?php foreach( $ccat->category_id->buckets as $c ): ?>
                                                    <?php $url = route('search_new',[create_slug($c->category->buckets[0]->key),create_slug($query),'']); ?>
                                                    <li>
                                                        <a href="{{$url}}">
                                                            <?=ucwords($c->category->buckets[0]->key)?> ( <?=$c->doc_count?> )
                                                        </a>
                                                    </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                                <?php endif; ?>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        @endif
                        <li class='active has-sub'><a href='#'>Price</a>
                            <ul>
                                <div>
                                    <div class="col-md-11">
                                        <br/>
                                        <div id="price-range"></div>
                                        <br/><br/>
                                    </div>
                                    <div class="col-md-6">
                                        <label>FROM:</label><br/>
                                        <input type="number" name="minPrice" id="minPrice" value="<?=@$minPrice?>" class="form-control fltr__src priceboxnew" field="saleprice_min" min="<?=@$minPrice?>" max="<?=@$maxPrice?>"/>
                                    </div>
                                    <br/>
                                    <div class="col-md-6">
                                        <label>TO:</label><br/>
                                        <input type="number" name="maxPrice" id="maxPrice" value="<?=@$maxPrice?>" class="form-control fltr__src priceboxnew" field="saleprice_max" min="<?=@$minPrice?>" max="<?=@$maxPrice?>"/>
                                        <br/>
                                    </div>
                                </div>
                            </ul>
                        </li>
                        <li class='active has-sub'><a href='#'>Search</a>
                            <ul>
                                <div id="custom-search-input">
                                    <div class="input-group col-md-12">
                                        <input type="text" class="form-control fltr__src lestpagesearchnew" placeholder="Search Products" id="search" field="query" value="<?=Request::get('search_text')?>" />
                                        <span class="input-group-btn">
													<button class="btn btn-info btn-lg" type="button">
														<i class="glyphicon glyphicon-search"></i>
													</button>
												</span>
                                    </div>
                                </div>
                            </ul>
                        </li>
                        @foreach( $aggr as $key => $section )
                            @if( $key != 'saleprice_min' && $key != 'saleprice_max' && $key != 'grp' && $key != 'filters_all' && count($section->buckets) > 0 )
                                <li class='active has-sub'><a href='#'>{{ucwords(str_replace( "_"," ",$key))}}</a>
                                    <ul>
                                        <div id="custom-search-input">
                                            <div class="input-group col-md-12">
                                                <input type="text" class="form-control search_attr lestpagesearchnew" placeholder="Search" id="search-{{strtolower($key)}}"/>
                                                <span class="input-group-btn">
													<button class="btn btn-info btn-lg" type="button">
														<i class="glyphicon glyphicon-search"></i>
													</button>
												</span>
                                            </div>
                                        </div>
                                        <div id='{{strtolower($key)}}-wrapper' class="nano">
                                            <div class="nano-content">
                                                @foreach( $section->buckets as $b )
                                                    @if( !empty($b->key) )
                                                        <div class="checkbox {{strtolower($key)}}">
                                                            <?php $key = strtolower($key); ?>
                                                            {{-- Adding Check for pre-filter for Custom Pages..--}}
                                                            <?php $selected = ((isset($custom_filters) && isset($custom_filters[$key]) && $custom_filters[$key] == $b->key)) ? "checked" : '' ?>
                                                            <label class="fix-slide-checkbox">
                                                                <input type="checkbox" value="<?=$b->key?>" id="chk<?=cleanID($b->key); ?>" class="fltr__src checkboxsize" field="{{($key)}}" {{$selected}}>
                                                                @if( $key == 'vendor' )
                                                                    <span class="value"><?=ucwords(config('vendor.name.'.$b->key ))?> </span>
                                                                @else
                                                                    <span class="value leftspace"><?=ucwords($b->key)?> </span>
                                                                @endif
                                                                <span class="count">[<?=$b->doc_count?>]</span>
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div> <!-- /col-md-4 -->
    </div>
</div>
</div>
<div class="applybuttonmobile" id="apply_filter">APPLY</div>
</div>
<style type="text/css">
    #product-left-fixed-menu{
        width: 95%;height:100%;overflow: hidden;
    }
    #product-left-fixed-menu > ul > li > ul { max-height: 215px; overflow:hidden; }
    .ui-slider-handle.ui-state-default{ position: absolute !important; background: #D70D00 !important;  }
    .col-md-11{ padding-right: 0px;  }
    .category_nano{ height: 220px; }
    .category_nano li a:hover { background: #eee!important; color: #000 !important; }
</style>