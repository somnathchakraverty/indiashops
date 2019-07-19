<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "{{$product->name}}",
  @if(isset($img) && count($img>0))
        "image": "{{$img[0]}}",
  @endif
    @if(isset($product->mini_spec) && !empty($product->mini_spec))
        "description": "Product Description: {{substr(trim(str_replace(";",", ",$product->mini_spec)),0,-1)}}",
  @endif
    @if(isset($product->color) && !empty($product->color))
        "color":"{{$product->color}}",
  @endif
    "brand": {
      "@type": "Thing",
      "name": "{{ucwords($product->brand)}}"
  },
  "offers": {
    "@type": "AggregateOffer",
    "lowPrice": "{{round($product->saleprice)}}",
    @if(count($vendors)>0)
        "highPrice": "{{round($vendors[count($vendors)-1]->_source->saleprice)}}",
    @endif
    "priceCurrency": "INR",
    "offerCount":{{count($vendors)}}, 
     @if(count($vendors)>0)
        "seller": [
        <?php $i = 1; foreach($vendors as $v){ ?>
        {
          "@type": "Organization",
          "name": "<?php echo config('vendor.name.' . $v->_source->vendor); ?>",
        "url": "<?php echo config('vendor.url.' . $v->_source->vendor); ?>",
        "logo": "<?php echo config('vendor.vend_logo.' . $v->_source->vendor); ?>"
      }@if($i<count($vendors)),@endif
        <?php $i++; } ?>
        ],
        @endif
    @if($product->track_stock == 1)
        "availability":"https://schema.org/InStock"
    @else
        "availability":"https://schema.org/OutOfStock"
    @endif
    },
    "itemCondition":"https://schema.org/NewCondition"
  }

</script>