<?php
$product = $data->product_detail;

if (strpos($product->image_url, ',') !== false && (strpos($product->image_url, '"]') === false)) {
    $product->image_url = explode(",", $product->image_url);
    $product->image_url = str_replace('"', '', $product->image_url[0]);
}

if (!empty(json_decode($product->image_url))) {
    $images = json_decode($product->image_url);
} else {
    $images[] = $product->image_url;
}
if (!is_array($images)) {
    $images[] = getImageNew($product->image_url);
}
$prating = 3;
if (isset($vendors)) {
    foreach ($vendors as $v) {
        $prating = ($v->_source->rating > $prating) ? $v->_source->rating : $prating;
    }
}

if (isset($product->rating) && $product->rating > 0) {
    $prating = $product->rating;
}
$detail_meta = false;

try {
    if (isset($product->meta) && !empty($product->meta)) {
        $detail_meta = json_decode($product->meta);
    }
}
catch (\Exception $e) {
    $detail_meta = false;
}
?>
@if($detail_meta && $product->seo_title )
    <title>{{$product->seo_title}}</title>
    <meta itemprop="name" content="{{$product->seo_title}}">

    <meta name="twitter:title" content="{{$product->seo_title}}">
    <meta name="twitter:image:alt" content="{{$product->seo_title}}">
    <meta property="og:title" content="{{$product->seo_title}}"/>
    <meta name="description" content="{{$detail_meta->description}}">
    @if(isset($detail_meta->keywords))
        <meta name="keywords" content="{!! html_entity_decode($detail_meta->keywords) !!}">
    @endif
@else
    @include('v2.mobile.ajax.product.meta.title', ['product' => $product ])
    @if(isset($meta) && is_object($meta))
        <meta name="description" content="{{$meta->description}}">
    @elseif(isset($description) && !empty($description))
        @include('v2.mobile.ajax.product.meta.meta_description', ['product' => $product ])
    @endif
@endif

<meta itemprop="image" content="{{getImageNew($images[0],'XS')}}">
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@IndiaShopps">
<meta name="twitter:creator" content="@IndiaShopps">
<meta name="twitter:image" content="{{getImageNew($images[0],'XS')}}">
<meta name="twitter:image:src" content="{{getImageNew($images[0],'XS')}}">
<meta property="og:type" content="article"/>
<meta property="og:url" content="{{Request::url()}}"/>
<meta property="og:image" content="{{getImageNew($images[0],'XS')}}"/>
<meta property="og:site_name" content="IndiaShopps | Buy | Compare Online"/>
<meta property="fb:admins" content="100000220063668"/>
<meta property="fb:app_id" content="1656762601211077"/>
<link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--pd--<?=$product->id?>"/>
<link rel="amphtml" href="{{amp_url($product)}}"/>
<link rel="canonical" href="{{route('product_detail_v2',[create_slug($product->name),$product->id])}}"/>
@section('json')
    @include('v2.product.json_ld', ['product' => $product,'vendors' => $vendors,'prating'=>$prating ])
@endsection