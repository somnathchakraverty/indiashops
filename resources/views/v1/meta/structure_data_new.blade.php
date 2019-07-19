<?php $prating = 3; ?>
<?php foreach( $vendors as $v ): ?>
<?php $prating = ( isset($v->_source->rating) && $v->_source->rating > $prating ) ? $v->_source->rating : $prating ; ?>
<?php endforeach?>
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "Product",
  "name": "{{$product->name}}",
  "productID": "sku:{{$product->id}}",
  "sku": "{{$product->id}}",
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
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "{{$prating}}",
    "ratingCount": "{{rand(10,500)}}"
  },
  "offers": {
    "@type": "AggregateOffer",
    "lowPrice": "{{round($product->saleprice)}}",
    @if(count($vendors)>0)
    "highPrice": "{{round($vendors[count($vendors)-1]->_source->saleprice)}}",
    @endif
    "priceCurrency": "INR",
    "areaServed":"IN",
    "offerCount":{{count($vendors)}},
    @if(count($vendors) > 0)
  "offers": [
  <?php $i=1; foreach($vendors as $v){ ?>
      {
        "@type": "Offer",
        "url": "{{$v->_source->product_url}}",
        "price": "{{$v->_source->saleprice}}",
        "priceCurrency": "INR",
        "acceptedPaymentMethod":"http://purl.org/goodrelations/v1#COD",
        "deliveryLeadTime":{
          "@type":"QuantitativeValue",
          "value":"3 to 7 days"
        },
        "eligibleDuration":{
          "@type":"QuantitativeValue",
          "value":"Till Stock Lasts"
        },
        "priceSpecification":{
          "@type":"PriceSpecification",
          "valueAddedTaxIncluded":true
        },
        "serialNumber":"{{isset($v->_source->product_id) ?: $v->_source->ref_id}}",
        "eligibleRegion":"IN",
        "warranty":{
          "@type":"WarrantyPromise",
          "durationOfWarranty":"As per manufacturer's warranty"
        },
        "availableDeliveryMethod":"http://purl.org/goodrelations/v1#DeliveryModeFreight",
        "businessFunction":"http://purl.org/goodrelations/v1#Sell",
        "eligibleCustomerType":"http://purl.org/goodrelations/v1#Enduser",
        @if(!isset($product->availability))
          @if($v->_source->track_stock == 1)
        "availability":"https://schema.org/InStock"
      @else
        "availability":"https://schema.org/OutOfStock"
      @endif
    @else
    "availability":"https://schema.org/{{$product->availability}}"
    @endif
      }@if($i<count($vendors)),@endif
      <?php $i++; } ?>
    ],
    "seller": [
  <?php $i=1; foreach($vendors as $v){ ?>
      {
        "@type": "Organization",
        "name": "<?php echo config('vendor.name.'.$v->_source->vendor); ?>",
        "url": "<?php echo config('vendor.url.'.$v->_source->vendor); ?>",
        "logo": "<?php echo config('vendor.vend_logo.'.$v->_source->vendor); ?>"
      }@if($i<count($vendors)),@endif
      <?php $i++; } ?>
    ],
    @endif    
    @if($product->grp=="mobile")
    "category":"{{ucwords($product->grp)}} > Mobile List > {{ucwords($product->category)}}",
    @else
      @if(strtolower($product->grp) == strtolower($product->parent_category))
  "category":"{{ucwords($product->grp)}} > {{ucwords($product->category)}}",
      @else
  "category":"{{ucwords($product->grp)}} > {{ucwords($product->parent_category)}} > {{ucwords($product->category)}}",
      @endif
    @endif
@if($product->track_stock == 1)
    "availability":"https://schema.org/InStock",
    "inventoryLevel":{{rand(1,50)}},
@else
    "availability":"https://schema.org/OutOfStock",
    "inventoryLevel":0,
@endif
    "itemCondition":"https://schema.org/NewCondition"
  }
}
</script>