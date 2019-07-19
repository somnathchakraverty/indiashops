@if(isset($youtube_url))
    <?php
    $html = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe src=\"//www.youtube.com/embed/$2\" allowfullscreen height='350px' width='100%' style='border: none;'></iframe>", $youtube_url);
    ?>
    <div class="reviewscartbox">       
            <div id="product_video">
                {!! $html !!}
            </div>        
    </div>
@endif
<style>
    .reviewscartbox #flexiselDemo10 .nbs-flexisel-item {width:1%!important;}
</style>