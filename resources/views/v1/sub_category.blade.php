@extends('v1.layouts.master')
@section('content')
<!-----------------Left menu-------------------- -->
<div class="container">
	<div class="row">
	<br>
		<div class="col-sm-3">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Women</h3>
                </div>
                <ul class="list-group">
                    <a href="#" class="list-group-item">Fastrack</a>
                    <a href="#" class="list-group-item ">Jashn Floral</a>
                    <a href="#" class="list-group-item">Wrangler</a>
                    <a href="#" class="list-group-item">Fazali Kurtis</a>
                </ul>
            </div>
			<div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Women</h3>
                </div>
                <ul class="list-group">
                    <a href="#" class="list-group-item">Fastrack</a>
                    <a href="#" class="list-group-item ">Jashn Floral</a>
                    <a href="#" class="list-group-item">Wrangler</a>
                    <a href="#" class="list-group-item">Fazali Kurtis</a>
                </ul>
            </div>
		</div>
<!-----------------right slider-------------------- -->
		<div class="col-sm-9">
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
    						<a href="#"><img src="<?=$img?>" alt=""></a>
    					</div>
                    <?php endforeach; ?>
				</div>
			</div><!-- /carousel -->
<!-----------------right category-------------------- -->
			<div class="hidden-xs hidden-sm ">
				<div id='product-list-cat-menu'>
					<ul>
                        <?php foreach( $cat as $c ): ?>
						  <li class=''><a href='#<?=$c->group_name?><?=$c->id?>' class="ssmooth"><?=$c->name?></a></li>
                        <?php endforeach; ?>
						<!-- <li class='last'><a href='#'>Precious Jewellery</a></li> -->
					</ul>
				</div>
			</div>
<!--------------category----------------------- -->
<?php foreach( $cat as $c ): ?>
<h4 class="listing_category_heading" id="<?=$c->group_name?><?=$c->id?>"><?=$c->name?></h4>
<hr>    
        <div class="row">
		<?php $childs = count($c->children); ?>
        <?php if( $childs > 0 ): ?>
            <?php foreach( $c->children as $ch ): ?>
                <div class="col-sm-4 col-md-3 col-xs-6">
                    <a href="#" class="listing_category">
                    	<img class="img-responsive" src="<?=$ch->image?>" alt= ""/>
                    	<h5><?=$ch->name?></h5>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        </div>
<?php endforeach; ?>
		</div>
	</div>
</div>
@endsection