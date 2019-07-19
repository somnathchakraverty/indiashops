<div class="filters">Filters</div>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    @foreach($facets as $section => $facet )
        <?php $ignore = ['cat_id', 'doc_count']; ?>
        @if( !in_array($section, $ignore) && count($facet->buckets) > 1 )
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
                                <input type="text" class="form-control brandssearch brd_sear search_attr" placeholder="Search {{unslug($section)}}">
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
