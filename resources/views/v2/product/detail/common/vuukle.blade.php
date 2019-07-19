<script src=http://vuukle.com/js/vuukle.js type="text/javascript"></script>
<script type=text/javascript>
    var VUUKLE_CUSTOM_TEXT = '{ "rating_text": "Give a rating:", "comment_text_0": "Leave a comment", "comment_text_1": "comment", "comment_text_multi": "comments", "stories_title": "Most Read Stories" }';
    var UNIQUE_ARTICLE_ID = '{{$product->id}}';
    var SECTION_TAGS = "{{implode(", ",explode(" ",$product->tags))}}";
    var ARTICLE_TITLE = "{{$product->name}}";
    var GA_CODE = "UA-69454797-1";
    var VUUKLE_API_KEY = "235645d5-5b90-4c2c-9422-cbdc44a34e5c";
    var TRANSLITERATE_LANGUAGE_CODE = "en";
    var VUUKLE_COL_CODE = "fd0825";
    var ARTICLE_AUTHORS = btoa(encodeURI('[{"name": "Indiashopps", "email":"admin@indiashopps.com","type": "internal"}]'));
    create_vuukle_platform(VUUKLE_API_KEY, UNIQUE_ARTICLE_ID, "0", SECTION_TAGS, ARTICLE_TITLE, TRANSLITERATE_LANGUAGE_CODE, "1", "", GA_CODE, VUUKLE_COL_CODE, ARTICLE_AUTHORS);
</script>