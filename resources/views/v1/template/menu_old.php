<?php $parent = 1; $url = newUrl(); ?>
<?php foreach( $navigation as $key => $nav ): ?>
    <div id="ver_pt_menu<?=$nav['category']->id?>" class="pt_menu">
        <div class="parentMenu">
            <?php $parent_url = $url.create_slug( $nav['category']->name ); ?>
            <a href="<?=$parent_url?>" title="<?=$nav['category']->name?>"><span class="cate-thumb">
                <img class="img-responsive" src="<?=asset("/images/v1/icons")?>/<?=$nav['category']->icon?>" alt= "Buy <?=$nav['category']->name ?> Online Icon"/></span>
                <span><?=$nav['category']->name?></span>
            </a>
        </div>
        <div class="wrap-popup hidden-xs">
            <div id="ver_popup<?=$nav['category']->id?>" class="popup">
                <div class="box-popup">
                    <div class="block1">
                    <?php $childs = count($nav['children']); ?>
                    <?php if( $childs > 0 ): $child = 1; ?>
                    <?php foreach( $nav['children'] as $key => $cnav ): ?>
                        <?php $child_url = $parent_url."/".create_slug( $cnav['category']->name ); ?>
                        <div class="column first col1" style="float:left;">
                            <div class="itemMenu level1">
                                <a class="itemMenuName level3" href="<?=$child_url?>" title="<?=$cnav['category']->name?>">
                                    <span><?=$cnav['category']->name?></span>
                                </a>
                                <div class="itemSubMenu level3">
                                    <div class="itemMenu level4">
                                        <?php $cchilds = count($cnav['children']); ?>
                                        <?php if( $cchilds > 0 ): $j = 1; ?>
                                            <?php foreach( $cnav['children'] as $key => $last ): ?>
                                                <?php $last_url = $child_url."/".create_slug( $last['category']->name ); ?>
                                                <a class="itemMenuName level4" href="<?=seoUrl($last_url)?>" title="<?=$last['category']->name?>">
                                                    <span><?=$last['category']->name?></span>
                                                </a>
                                            <?php
                                                if( $j == 4 )
                                                    break;
                                                else
                                                    $j++;
                                            ?>
                                            <?php endforeach; ?>
                                            <a class="itemMenuName level4" href="<?=$child_url?>" title="View All <?=$cnav['category']->name?>">
                                                <span>View All</span>
                                            </a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                        if( $child == 8 )
                            break;
                        else
                            $child++;
                    ?>
                    <?php endforeach; ?>
                    <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        if( $parent == 7 )
            break;
        else
            $parent++;
    ?>
    <?php endforeach;?>
    <div id="ver_pt_menu20" class="pt_menu noSub">
        <div class="parentMenu">
            <a href="<?=newUrl('coupons')?>">
                <span class="cate-thumb">
                    <img class="img-responsive" src="<?=asset("/images/v1/icons/coupon.png")?>" alt= "View All Icon"/>
                </span>
                    <span>Coupons</span>
            </a>
        </div>
    </div>
    <div id="ver_pt_menu19" class="pt_menu noSub">
        <div class="parentMenu">
            <a href="<?=newUrl('all-categories')?>">
                <span class="cate-thumb">
                    <img class="img-responsive" src="<?=asset("/images/v1/icons/view_all.png")?>" alt= "View All Icon"/>
                </span>
                    <span>View All</span>
            </a>
        </div>
    </div>