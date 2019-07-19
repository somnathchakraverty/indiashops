@extends('v1.layouts.master')
@section('meta')
    <meta name="skills" content="Developer" />
@endsection
@section('content')
<!--==============left category=============-->	
<div class="all-category-bg">
	<div class="container">
		{!! Breadcrumbs::render() !!}
		<h4>Deal Activated. Please visit <a onClick="ga('send', 'event', 'coupon', 'click');" href="<?=$product_detail->offer_page;?>"><?=strtoupper($product_detail->vendor_name);?></a> to avail the offer.</h4>
		<hr>
		<div class="row">
			<div class="col-md-12 col-sm-12 vendor-logo" style="margin-bottom: 10px;">
				<h5><?=$product_detail->title?></h5>
				<p class="coupon-details-content"><?=$product_detail->description?></p>
                    <?php if( !empty($product_detail->code) ): ?>
					<div class="col-md-offset-3 col-sm-offset-2" >
    					<div class="coupon-details-code">
						
    						<?php if( @$_SERVER["HTTP_REFERER"] != url("coupon/".create_slug($product_detail->title)."/".$product_detail->promo) && stripos( @$_SERVER["HTTP_REFERER"] , url("coupons") ) === false ): ?>
    							<a out-url='<?=$product_detail->offer_page?>' onClick="ga('send', 'event', 'coupon', 'click');" href="<?=newUrl("coupon/".create_slug($product_detail->title)."/".$product_detail->promo); ?>" target="_blank" style="color:#fff" class="get-code">Get Code</a>
    						<?php else: ?>
    							<span><?=$product_detail->code;?></span>
    						<?php endif; ?>
							</div>
    					</div>
                    <?php else: ?>
					<div class="row">
						<?php $url = (Request::getPathInfo().(Request::getQueryString() ? ('?'.Request::getQueryString()) : "" )) ?>
						<div class="col-md-7 col-md-offset-5 col-sm-offset-5 col-xs-offset-4">
							<a class="btn btn-success" href="<?=$url?>" onClick="ga('send', 'event', 'coupon', 'click');" onclick="window.open('<?=$product_detail->offer_page;?>'); return false;">GO TO <?=strtoupper($product_detail->vendor_name);?></a>
						</div>
					</div>
                    <?php endif; ?>
                    <?php //dd($product_detail);?>
					<div class="row">
					<div class="col-md-8 col-md-offset-4 col-sm-offset-4">
						<div class="coupon-detail-bg">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<img src="<?=$product_detail->vendor_logo;?>" alt="" class="img-responsive" width="100%">
								</div>
								<div class="col-md-5 col-sm-5 col-xs-5">
									<a class="btn btn-danger view-offer" href="<?=newUrl('/coupons/discount/'.helper::encode_url($product_detail->category)."-coupons.html");?>">View all offers</a>
								</div>
							</div>
						</div>	
						</div>
					</div>

					<?php if( !empty( $message ) ): ?>
						<div class="alert alert-success">
							<?=$message?>
						</div>
					<?php endif; ?>
			
				<!-- --------------Report A Problem--------------- -->					
					<div class="vendor-logo">
						<div class="row">
							<div class="col-md-7 col-sm-8">
								<h6 class="coupon-details-content col-md-offset-5 col-sm-offset-5"><a href="#credits" class="toggle"> 
								 <i class="fa fa-exclamation-triangle"></i> Report A Problem</a></h6>
								<div class="hidden col-md-offset-5" id="credits"> 
								<h4>This coupon didn't work ? Let us know</h4>
								<div class="panel-body">                
									<form accept-charset="UTF-8" action="" method="POST">
										<textarea class="form-control counted" name="message" placeholder="Share your experience" rows="5" style="margin-bottom:10px;"></textarea>
										<h6 class="pull-right" id="counter">320 characters remaining</h6>
										<input type="hidden" name="_token" value="{{csrf_token()}}">
										<button class="btn btn-info" type="submit">Submit</button>
									</form>
								</div>
							</div>
							</div>
							<div class="col-md-4">
								<h6 class="coupon-details-content"><i class="fa fa-check-square-o"></i> Verified Today</h6>
							</div>
						</div>	
					</div>
				
			</div>
			<!--<div class="col-md-6 col-sm-6">
				<div class="vendor-logo">
					<div class="row">
						<div class="col-md-8">
							<h6 class="coupon-details-content"><i class="fa fa-exclamation-triangle"></i> Report A Problem</h6>
							<div class="panel-body">                
								<form accept-charset="UTF-8" action="" method="POST">
									<textarea class="form-control counted" name="message" placeholder="Share your experience" rows="5" style="margin-bottom:10px;"></textarea>
									<h6 class="pull-right" id="counter">320 characters remaining</h6>
									<button class="btn btn-info" type="submit">Submit</button>
								</form>
							</div>
						</div>
						<div class="col-md-4">
							<h6 class="coupon-details-content"><i class="fa fa-check-square-o"></i> Verified Today</h6>
						</div>
					</div>	
				</div>
			</div>-->
		</div>	
	</div>		
</div>
<style type="text/css">
	h4 a{ color: #d70d00 !important; text-decoration: underline !important;  }
	a:hover{ text-decoration: none!important;  }

		@media (max-width: 1280px) {
    .coupon-details-code{
		margin-left:143px;
	}
    }
	@media (max-width: 1920px) {
    .coupon-details-code{
		margin-left:153px;
	}
    }
		@media (max-width: 360px) {
    .coupon-details-code{
		margin-left:40px;
	}
    }
</style>
@endsection