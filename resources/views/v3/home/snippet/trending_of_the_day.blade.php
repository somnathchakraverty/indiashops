@if(!isset($ajax))
    <div class="col-md-6 pleft">
        <div class="input-group">
            <div class="input-group-btn search-panel">
                <select name="cat_id" class="All-Categories">
                    <option value="0">All Categories</option>
                    @foreach($headers->search as $item)
                        <option value="{{strtolower($item->name)}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="searchicon"></div>
            <div class="search_wrapper">
                <input type="text" class="form-control Search-anything Searchbgcolor" name="x" placeholder="Search anything...">
                <div class="clear_search" data-section="trending_of_the_day" style="display: none">&nbsp;</div>
            </div>
            <span class="input-group-btn">
                <button class="btn btn-default searchbutton buttonbgcolor section_search" data-section="trending_of_the_day" type="button">SEARCH</button>
            </span>
        </div>
    </div>
    <div class="trendingdealsprobox" id="trending_of_the_day_search">
@endif
<div class="cs_dkt_si">
    <ul data-items="5">
        @foreach($products as $product )
        <li class="thumnail">
            @include('v3.common.product.card', [ 'product' => $product ])
        </li>
        @endforeach
    </ul>
</div>
</div>