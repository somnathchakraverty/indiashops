<div class="modal-content popup2width">
    <button type="button" class="close popupright2" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span></button>
    <div class="productdetailspopup mtop0">
        <img class="popup-best" src="{{asset('assets/v3')}}/images/popup-best.jpg" alt="best">
        <h3>Checkout the Best Price</h3>
        <h2>Save time, Save Money!</h2>
        <p>Use our award winning search to get best deals</p>
        <div class="searchpopup2">
            <div class="input-group">
                <form class="form_search" id="subscribe" action="/search" method="get">
                    <div class="input-group-btn search-panel floatleft">
                        <select name="cat_id" class="All-Categories">
                            <option value="0">All Categories</option>
                            <option value="women">Women</option>
                            <option value="men">Men</option>
                            <option value="kids">Kids</option>
                            <option value="home &amp; decor">Home &amp; Decor</option>
                            <option value="appliances">Appliances</option>
                            <option value="mobile">Mobile</option>
                            <option value="computers">Computers</option>
                            <option value="electronics">Electronics</option>
                            <option value="camera">Camera</option>
                            <option value="care">Care</option>
                            <option value="beauty &amp; health">Beauty &amp; Health</option>
                            <option value="sports &amp; fitness">Sports &amp; Fitness</option>
                            <option value="books">Books</option>
                            <option value="lifestyle">Lifestyle</option>
                            <option value="automotive">Automotive</option>
                        </select>
                    </div>
                    <div class="searchicon mleft154"></div>
                    <input type="text" class="form-control Search-anything auto_search width235" name="x" placeholder="Search anything..."/>
                    <span class="input-group-btn">
                        <button class="btn btn-default searchbutton orange-button" type="submit">SEARCH</button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    search_box = $("#subscribe");

    $("form .auto_search").autocomplete({
        minLength: 2,
        source: completion,
        select: function (event, ui) {
            $("form .auto_search").val(ui.item.label);
            search_box.submit();
            return false;
        },
        position: { my : "left bottom", at: "left top" }
    });

    $(document).on('submit','#subscribe',function(e){
        var search_text = $(this).find('.auto_search').val();
        var cat_id = $(this).find('.All-Categories').val();

        if( typeof cat_id == "undefined" )
        {
            cat_id = 0;
        }

        var search_url  = ajax_url+"/search/"+cat_id+"/"+create_slug(search_text);

        window.location = search_url;

        return false;
    });

    function create_slug( str )
    {
        str = str.toLowerCase();
        str = str.replace(/\s/g , "-");
        str = str.replace(/,/g , "-");

        return str;
    }
</script>