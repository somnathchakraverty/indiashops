@extends('v1.layouts.master')
@section('content')
@if(isset($description))
  @section('description')
     <meta name="description" content="{{$description}}" /> <!-- Description from controller -->
  @endsection
@endif
<div class="all-category-bg">
<div class="container">
	<div class="row">
		<div class="col-md-12" >
			<h1 class="all-category-heading">Most Compared Mobiles</h1>
			<div class="col-md-9 col-sm-8">
				<section class="section leave-a-message">
				<?php foreach( $list as $l ): ?>
					<?php $group = explode(":", $l ); ?>
					<div class="row most_compare_pro_bg">
						<div class="col-md-3 col-sm-3 col-xs-5">
							<?php $img1 = getImage( $products[$group[0]]->image_url, $products[$group[0]]->vendor ) ;?>
							<?php $img2 = getImage( $products[$group[1]]->image_url, $products[$group[1]]->vendor ) ;?>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<img src="<?=$img1?>" alt="image" class="most_compare_pro_img img-responsive"/>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-6">
								<img src="<?=$img2?>" alt="image" class="most_compare_pro_img img-responsive"/>
							</div>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-7">
							<?php 	$url = newUrl("compare-mobiles");
									$url .= "/".create_slug($products[$group[0]]->name." ".$products[$group[0]]->id)."/".create_slug($products[$group[1]]->name." ".$products[$group[1]]->id)
							?>
							<span class="most_compare_pro_heading">
								<a href="<?=$url?>" ><?=$products[$group[0]]->name?> <strong class="most_compare_pro_heading_vs">V/S</strong> <?=$products[$group[1]]->name?></a>
							</span>
						</div>
					</div>
					<br>
				<?php endforeach; ?>
				</section>
			</div>
			<div class="col-md-3 col-sm-4">
				<div class="panel panel-default" style="min-height: 200px; margin-bottom: 10px;border: none;" >
				<div class="panel-heading best_phones_under_heading">Mobiles</div>
					<?php $range = array( 5000, 10000, 15000, 20000, 25000 ); ?>
					
					<ul class="best_phones_under">
						@foreach( $range as $r )
						<li>
							<a href="{{route('bestphones',[$r])}}" title="Best Mobile Phones Under Rs. {{$r}}">Best Mobile Phones Under Rs. {{$r}}</a>
						</li>
						@endforeach
					</ul>
				</div>
				<div id="slider_form_sticky_wrapper">
					<div class="slider_form_bg_img">
						<div class="slider_form_bg">
							<form class="slider_form" method="POST" id="compare_mobiles">
								<div class="row">
									<div class="slider_form_heading hidden-xs hidden-sm">Compare Phones</div>
								<div class="col-md-12 col-sm-12">
								<div class="form-group">
									<label for="status" class="control-label "></label>
									<div class="col-sm-12 col-md-12">
										<select class="form-control compare_mobiles" id="mobile1" name="mobile1">
											<option value="">-----SELECT-----</option>
										</select>
									</div>
								</div>
								</div>
								</div>
								<div class="row">
									<div class="col-md-12 col-sm-12 col-md-offset-5 col-sm-offset-4">
									 <img class="img-responsive" src="<?=asset("/images/v1/mobile_vs.png")?>" alt="Logo" />
									</div>
								</div>
								<div class="row">
								<div class="col-md-12 col-sm-12">
								<div class="form-group"  style="margin-top: 10px;">
									<label for="status" class="control-label "></label>
									<div class="col-sm-12 col-md-12">
										<select class="form-control compare_mobiles" id="mobile2" name="mobile2">
											<option value="">-----SELECT-----</option>
										</select>
									</div>
								</div>
								</div>
								</div>
								<div class="row">
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="col-md-offset-3 col-sm-12 col-md-12">
										<button type="submit" class="btn btn-danger slider_form_button">Compare</button>
									  </div>
								  </div>
								  </div>
								</div>
								<input type="hidden" value="{{csrf_token()}}" name="_token" />
							</form>
							<div class="slider_form_button_bottom hidden-sm">
								<a href="<?=newUrl('most-compared-mobiles.html')?>">
									<i class="fa fa-mobile" aria-hidden="true" style="font-size: 1.2em;"></i>
									&nbsp;Most Compared Mobiles
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	CONTENT.compare_url = '<?=newUrl('compare_mobiles.json')?>';
	CONTENT.compare.load();

	$("#compare_mobiles").submit(function(){
		var com_url = '<?=newUrl("compare-mobiles")?>';
		var m1 = $("#mobile1").val();
		var m2 = $("#mobile2").val();

		if( m1.length > 0 && m2.length > 0 )
		{
			var next_url = com_url+"/"+m1+"/"+m2
			location.href = next_url
		}

		return false;
	});

	$(document).ready(function(){
		$(window).scroll(function(){
			if( ($(window).scrollTop() + 100) > $("#slider_form_sticky_wrapper").offset().top && $(window).width() >= 768 )
		    {
		        $(".slider_form_bg_img").addClass("sticky");
		    }
		    else
		    {
		        $(".slider_form_bg_img").removeClass("sticky");
		    }
		});
	});
</script>
<style>
	.slider_form_bg_img{ top: 60px; -webkit-transition:all .5s ease-in-out;-moz-transition:all .5s ease-in-out;-o-transition:all .5s ease-in-out;-ms-transition:all .5s ease-in-out;transition:all .5s ease-in-out; }
	.slider_form_bg_img.sticky{ position: fixed; top: 85px; -webkit-transition:all .5s ease-in-out;-moz-transition:all .5s ease-in-out;-o-transition:all .5s ease-in-out;-ms-transition:all .5s ease-in-out;transition:all .5s ease-in-out;  }
</style>
@endsection