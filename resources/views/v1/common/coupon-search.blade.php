<form class="form_search" id="searchbox" action="{{ url('couponsearch') }}" method="get">
    <label for="pos_query_top"></label>
    <!-- image on background -->
        <!-- <input type="hidden" value="{{ csrf_token() }}" name="_token"> -->
        <input type="text" value="<?=Request::get('search_text')?>" required name="search_text" placeholder="Search Best Coupons...." class="search_query form-control ac_input" autocomplete="off" />
        <button class="btn btn-default submit_search" value="Search" name="" type="submit">
            <i class="glyphicon glyphicon-search"></i>
        </button>
</form>