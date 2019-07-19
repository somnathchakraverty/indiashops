<form class="form_search" id="searchbox" action="{{ url('search') }}" method="get">
    <label for="pos_query_top"></label>
    <!-- image on background -->
        <!-- <input type="hidden" value="{{ csrf_token() }}" name="_token"> -->
        <input type="text" value="<?=Request::get('search_text')?>" required name="search_text" placeholder="Search Best Prices. Compare Before Your Buy ..." class="search_query form-control main_search"/>
        <div class="pos_search form-group">
            <select class="selectpicker" name="group" id="search_id" style="visibility: hidden;">
                <option value="all">Categories</option>
                <?php $grp = Request::get('group') ?>
                <?php foreach( $navigation as $key => $nav ): ?>
                    <option value="<?=$nav['category']->name?>" <?= ( $grp == $nav['category']->name ) ? "selected" : "";?>> <?=$nav['category']->name?> </option>
                <?php endforeach; ?>
            </select>
            <input type="hidden" name="cat_id" class="search_cat_id">
        </div>
        <button class="btn btn-default submit_search" value="Search" name="" type="submit">
            <i class="glyphicon glyphicon-search"></i>
        </button>
</form>