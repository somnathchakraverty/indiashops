<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "{{$product->name}}",
  @if(isset($img) && count($img>0))
  "image": "{{$img[0]}}",
  @endif
  @if(isset($product->description) && !empty($product->description))  
  "description": "Product Description: {{trim(strip_tags( html_entity_decode($product->description)))}}",
  @endif
  @if(isset($product->color) && !empty($product->color))
  "color":"{{$product->color}}",
  @endif  
  "brand": {
    "@type": "Thing",
    "name": "{{ucwords($product->brand)}}"
  },
  "offers": {
    "@type": "Offer",
    @if($product->track_stock == 1)
    "availability": "http://schema.org/InStock",
    @else
    "availability":"https://schema.org/OutOfStock",
    @endif
    "price": "{{round($product->saleprice)}}",
    "priceCurrency": "INR"
  },
  "itemCondition":"https://schema.org/NewCondition"
 }
</script>