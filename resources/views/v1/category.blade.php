@extends('v1.layouts.master')
@if(isset($meta) && !empty($meta->description))
    @section('description')
        <meta name="description" content="<?php echo $meta->description; ?>" />   
    @endsection
@endif

@section('meta')
    <link rel="alternate" href="android-app://com.indiashopps.android/indiashopps/store--p--<?=@$scat?>" />
@endsection
@section('content')
<!-----------------Left menu-------------------- -->
<div class="container">
	<div class="row">
	<br>
		<div class="col-sm-4 col-md-3">
			<div class="panel panel-default "><!-- stick -->
                <div class="panel-heading">
                    <h3 class="panel-title">Categories</h3>
                </div>
                <div class="list-group">
                    <?php foreach( $cat as $c ): ?>
                        <a href='#<?=$c->group_name?><?=$c->id?>' class="ssmooth list-group-item"><?=$c->name?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        @if($cat_name == "mobile")
         <div class="panel panel-default ">
                <div class="panel-heading">
                    <h3 class="panel-title">Popular Brands</h3>
                </div>
                <div class="list-group">                    
                    <a href='<?=newUrl('mobile/htc--mobiles')?>' class="ssmooth list-group-item" title="HTC Mobile Phones">HTC Mobile Phones</a>                   
                    <a href='<?=newUrl('mobile/lg--mobiles')?>' class="ssmooth list-group-item" title="LG Mobile Phones">LG Mobile Phones</a>                   
                    <a href='<?=newUrl('mobile/oppo--mobiles')?>' class="ssmooth list-group-item" title="Oppo Mobile Phones">Oppo Mobile Phones</a>                   
                    <a href='<?=newUrl('mobile/lenovo--mobiles')?>' class="ssmooth list-group-item" title="Lenovo Mobile Phones">Lenovo Mobile Phones</a>                   
                </div>
            </div> 
        @endif        
		</div> 
<!-----------------right slider-------------------- -->
        {!! Breadcrumbs::render() !!}
		<div class="col-md-9 col-sm-8">
            <div id="right-container">
			<!-- Carousel -->
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
				<ol class="carousel-indicators">
                    <?php $i = 0; ?>
                    <?php foreach( $slider as $img ): ?>
                        <?php if( $i == 0 ) $class="active"; else $class = ""; ?>
    					<li data-target="#carousel-example-generic" data-slide-to="<?=$i?>" class="<?=$class?>"></li>
                    <?php $i++; ?>
                    <?php endforeach; ?>
				</ol>
			<!-- Wrapper for slides -->
				<div class="carousel-inner">
                    <?php $i = 0; ?>
                    <?php foreach( $slider as $img ): ?>
                        <?php if( $i == 0 ) $class="active"; else $class = ""; $i++; ?>
    					<div class="item <?=$class?>">
    						<a target="<?php echo (!empty($img->refer_url)?'target=\"_blank\"':'');  ?>" href="<?php echo (!empty($img->refer_url)?$img->refer_url:'');  ?>"><img alt="<?php echo (!empty($img->alt)?$img->alt:''); ?>" src="<?=$img->image_url?>" alt=""></a>
    					</div>
                    <?php endforeach; ?>
				</div>
			</div><!-- /carousel -->
            @if(!empty($meta->h1))
                <h1 style="font-size:17px;"><?php echo $meta->h1; ?></h1>
                @if(!empty($meta->text))
                    <div class="moredata">
                        <?php echo ($meta->text); ?>
                    </div>
                @endif
            @endif
<!--------------category----------------------- -->
            <?php foreach( $cat as $c ): ?>                
            <a href="<?=newUrl( create_slug($c->group_name)."/".create_slug( $c->name ))?>">
                <h4 class="listing_category_heading" id="<?=$c->group_name?><?=$c->id?>"><?=$c->name?></h4>
            </a>
            <hr>    
                    <div class="row">
            		<?php $childs = count($c->children); ?>
                    <?php if( $childs > 0 ): ?>
                        <?php foreach( $c->children as $ch ): ?>                            
                            <?php if( !empty($cat_name) ) $c->group_name = $cat_name; ?>
                            <?php $url = newUrl( create_slug($c->group_name)."/".create_slug( $c->name )."/".seoUrl( create_slug($ch->name) ) ); ?>
                            <div class="col-sm-4 col-md-3 col-xs-6">
                                <a href="<?=$url?>" class="listing_category">
                                	<img class="img-responsive" src="<?=$ch->image?>" alt= "<?=$ch->name?>"/>
                                	<h5><?=$ch->name?></h5>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php else:  ?>
                        <?php if($c->name == 'Mobiles'): ?>
                            <div class="col-sm-4 col-md-3 col-xs-6">
                                <a href="<?=newUrl( create_slug($c->group_name)."/".seoUrl(create_slug( $c->name )))?>" class="listing_category">
                                    <img class="img-responsive" src="<?=$c->image?>" alt= "<?=$c->name?>"/>
                                    <h5>All Mobile Phones</h5>
                                </a>
                            </div>
                            <div class="col-sm-4 col-md-3 col-xs-6">
                                <a href="<?=newUrl( create_slug($c->group_name)."/samsung--".seoUrl(create_slug( $c->name )))?>" class="listing_category">
                                    <img class="img-responsive" src="http://images.indiashopps.com/v1/brands/samsung_mobile.png" alt= "samsung <?=$c->name?>"/>
                                    <h5>Samsung Mobile Phones</h5>
                                </a>
                            </div>
                            <div class="col-sm-4 col-md-3 col-xs-6">
                                <a href="<?=newUrl( create_slug($c->group_name)."/lenovo--".seoUrl(create_slug( $c->name )))?>" class="listing_category">
                                    <img class="img-responsive" src="http://images.indiashopps.com/v1/brands/lenovo_mobile.png" alt= "lenovo <?=$c->name?>"/>
                                    <h5>Lenovo Mobile Phones</h5>
                                </a>
                            </div>
                            <div class="col-sm-4 col-md-3 col-xs-6">
                                <a href="<?=newUrl( create_slug($c->group_name)."/htc--".seoUrl(create_slug( $c->name )))?>" class="listing_category">
                                    <img class="img-responsive" src="http://images.indiashopps.com/v1/brands/htc_mobile.png" alt= "htc <?=$c->name?>"/>
                                    <h5>HTC Mobile Phones</h5>
                                </a>
                            </div>
                    <?php elseif($c->name == 'Tablets'): ?>
                            <div class="col-sm-4 col-md-3 col-xs-6">
                                <a href="<?=newUrl( create_slug($c->group_name)."/".seoUrl(create_slug( $c->name )))?>" class="listing_category">
                                    <img class="img-responsive" src="<?=$c->image?>" alt= "<?=$c->name?>"/>
                                    <h5>All Tablets</h5>
                                </a>
                            </div>
                            <div class="col-sm-4 col-md-3 col-xs-6">
                                <a href="<?=newUrl( create_slug($c->group_name)."/apple--".seoUrl(create_slug( $c->name )))?>" class="listing_category">
                                    <img class="img-responsive" src="http://images.indiashopps.com/v1/brands/ipad_tabs.png" alt= "apple ipads"/>
                                    <h5>Apple iPads</h5>
                                </a>
                            </div>
                            <div class="col-sm-4 col-md-3 col-xs-6">
                                <a href="<?=newUrl( create_slug($c->group_name)."/asus--".seoUrl(create_slug( $c->name )))?>" class="listing_category">
                                    <img class="img-responsive" src="http://images.indiashopps.com/v1/brands/asus_tabs.png" alt= "Asus <?=$c->name?>"/>
                                    <h5>Asus Tablets</h5>
                                </a>
                            </div>
                            <div class="col-sm-4 col-md-3 col-xs-6">
                                <a href="<?=newUrl( create_slug($c->group_name)."/samsung--".seoUrl(create_slug( $c->name )))?>" class="listing_category">
                                    <img class="img-responsive" src="http://images.indiashopps.com/v1/brands/samsung_tabs.png" alt= "samsung <?=$c->name?>"/>
                                    <h5>Samsung Tablets</h5>
                                </a>
                            </div>

                        <?php else: ?>
                        <div class="col-sm-4 col-md-3 col-xs-6">
                            <a href="<?=newUrl( create_slug($c->group_name)."/".seoUrl(create_slug( $c->name )))?>" class="listing_category">
                                <img class="img-responsive" src="<?=$c->image?>" alt= "<?=$c->name?>"/>
                                <h5><?=$c->name?></h5>
                            </a>
                        </div>
                         <?php endif; ?>


                    <?php endif; ?>
                    </div>
            <?php endforeach; ?>
            </div>
		</div>
	</div>
</div>
<style type="text/css">
    div.sticky-div{position: fixed;
    top: 90px;
    width: 17.1%;
    -webkit-transition: all 0.1s ease 0s;
    transition: all 0.1s ease 0s;
    }

    .listing_category h5{ min-height:  35px;  }
</style>
@endsection