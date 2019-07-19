@if( app('seo') instanceof \indiashopps\Support\SEO\SeoData )
    <title>{!! app('seo')->getTitle() !!}</title>
    <meta name="description" content="{!! app('seo')->getDescription() !!}"/>
    <meta name="keywords" content="{!! app('seo')->getKeywords() !!}"/>
    <meta property="og:title" content="{!! app('seo')->getTitle() !!}"/>
@endif
@if(isset($page) && $page > 1 )
    <meta name="ROBOTS" content="noindex">
@endif