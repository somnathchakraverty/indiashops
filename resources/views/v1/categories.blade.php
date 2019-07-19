@extends('v1.layouts.master')
@section('content')
<!--==============All Category=============-->	
<div class="all-category-bg">
    <div class="container">
        {!! Breadcrumbs::render() !!}
        <h4>All Categories</h4>
        <hr>
            <?php $count = 1; ?>
            <?php foreach( $categories as $c ): ?>
                <?php if( $count == 1 ): ?>
                    <div class="row">
                <?php endif; ?>
                    <?php $parent_url = newUrl().create_slug( $cat['category']->name ); ?>
                    <div class="col-sm-3">
                        <div class="all-category-heading">
                            <a href="<?=newUrl(create_slug( $cat['category']->name ) )?>">
                                <span><?=$cat['category']->name?></span>
                            </a>
                        </div>
                        <?php $childs = count($cat['children']); ?>
                        <?php if( $childs > 0 ): $child = 1; ?>
                        <ul class="all-category-menu">
                            <?php foreach( $cat['children'] as $c_cat ): ?>
                            <?php $child_url = $parent_url."/".seoUrl(create_slug( $c_cat['category']->name )); ?>
                            <li>
                                <a href="<?=$child_url?>">
                                    <i class="fa fa-angle-double-right"></i> <?=$c_cat['category']->name?>
                                </a>
                            </li>
                            <?php
                                if( $child == 4 )
                                    break;
                                else
                                    $child++;
                            ?>
                            <?php endforeach; ?>
                            <li>
                                <a href="<?=$parent_url?>">
                                    <i class="fa fa-angle-double-right"></i> View All
                                </a>
                            </li>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php $count++; ?>
                    <?php if( $count == 5 ): ?>
                    <?php $count = 1; ?>
                        </div>
                    <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
@endsection