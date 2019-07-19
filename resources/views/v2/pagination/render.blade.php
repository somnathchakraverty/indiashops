<?php
    // total page count calculation
    $pages = ((int) ceil($total / $rpp));
    // if it's an invalid page request
    if ($current < 1) {
        return;
    } elseif ($current > $pages) {
        return;
    }
    // if there are pages to be shown
    if ($pages > 1 || $alwaysShowPagination === true) {
?>
<ul class="<?= implode(' ', $classes) ?>">
<?php
        /**
         * Previous Link
         */
        // anchor classes and target
        $classes = array('copy', 'page-item');
        $params = $get;
        $params[$key] = ($current - 1);
        //$href = ($target) . '?' . http_build_query($params);
        $page = ( ($current - 1) == 1 ) ? '' : ($current - 1) ;
        $href = str_replace("{page?}",$page,$target);
        $href = str_replace("{page}",$page,$href);
        $href = str_replace("-.html",".html",$href);
        $href = trim($href,"-");
        $href = preg_replace(
            array('/=$/', '/=&/'),
            array('', '&'),
            $href
        );
        if ($current === 1) {
            $href = '#';
            array_push($classes, 'disabled');
        }

        if( ($current - 1) != 1 )
        {
            $index = 'rel="noindex"';
        }
        else
        {
            $index = '';
        }
        $href = trim($href,"-");
?>
    <li class="<?= implode(' ', $classes) ?>">
        <a href="{{$href}}" aria-label="Previous" class="page-link{{$ajax}}" data-page="{{($current - 1)}}" {!! $index !!}>
            <span aria-hidden="true">&laquo;</span> <span class="sr-only">Previous</span>
        </a>
    </li>
<?php
        /**
         * if this isn't a clean output for pagination (eg. show numerical
         * links)
         */
        if (!$clean) {
            /**
             * Calculates the number of leading page crumbs based on the minimum
             *     and maximum possible leading pages.
             */
            $max = min($pages, $crumbs);
            $limit = ((int) floor($max / 2));
            $leading = $limit;
            for ($x = 0; $x < $limit; ++$x) {
                if ($current === ($x + 1)) {
                    $leading = $x;
                    break;
                }
            }
            for ($x = $pages - $limit; $x < $pages; ++$x) {
                if ($current === ($x + 1)) {
                    $leading = $max - ($pages - $x);
                    break;
                }
            }
            // calculate trailing crumb count based on inverse of leading
            $trailing = $max - $leading - 1;
            // generate/render leading crumbs
            for ($x = 0; $x < $leading; ++$x) {
                // class/href setup
                $params = $get;
                $params[$key] = ($current + $x - $leading);
                $page = ( ($current + $x - $leading) == 1 ) ? '' : ($current + $x - $leading) ;
                $href = str_replace("{page?}",$page,$target);
                $href = str_replace("{page}",$page,$href);
                $href = str_replace("-.html",".html",$href);
                $href = trim($href,"-");
                $href = preg_replace(
                    array('/=$/', '/=&/'),
                    array('', '&'),
                    $href
                );

            if( ($current + $x - $leading) != 1 )
            {
                $index = 'rel="noindex"';
            }
            else
            {
                $index = '';
            }
    $href = trim($href,"-");
?>
    <li class="page-item"><a href="{{$href}}" class="page-link{{$ajax}}" data-page="{{($current + $x - $leading)}}" {!! $index !!}><?= ($current + $x - $leading) ?></a></li>
<?php
            }
            // print current page
?>
    <li class="page-item active"><a href="javascript:void" class="page-link{{$ajax}}" data-page=""><?= ($current) ?></a></li>
<?php
            // generate/render trailing crumbs
            for ($x = 0; $x < $trailing; ++$x) {
                // class/href setup
                $params = $get;
                $params[$key] = ($current + $x + 1);
                $href = str_replace("{page?}",($current + $x + 1),$target);
                $href = str_replace("{page}",($current + $x + 1),$href);
                $href = preg_replace(
                    array('/=$/', '/=&/'),
                    array('', '&'),
                    $href
                );

            if( ($current + $x + 1) != 1 )
            {
                $index = 'rel="noindex"';
            }
            else
            {
                $index = '';
            }
    $href = trim($href,"-");
?>
    <li class="page-item"><a href="{{$href}}" class="page-link{{$ajax}}" data-page="{{($current + $x + 1)}}" {!! $index !!}><?= ($current + $x + 1) ?></a></li>
<?php
            }
        }
        /**
         * Next Link
         */
        // anchor classes and target
        $classes = array('copy', 'next');
        $params = $get;
        $params[$key] = ($current + 1);
        $href = str_replace("{page?}",($current + 1),$target);
        $href = str_replace("{page}",($current + 1),$href);
        $href = preg_replace(
            array('/=$/', '/=&/'),
            array('', '&'),
            $href
        );
        if ($current === $pages) {
            $href = '#';
            array_push($classes, 'disabled');
        }

        if( ($current + 1) != 1 )
        {
            $index = 'rel="noindex"';
        }
        else
        {
            $index = '';
        }
    $href = trim($href,"-");
?>
    <li class="<?= implode(' ', $classes) ?>">
        <a href="{{$href}}" class="page-link{{$ajax}}" aria-label="Next" data-page="{{($current + 1)}}" {!! $index !!}>
            <span class="sr-only">Next</span> <span aria-hidden="true">&raquo;</span>
        </a>
    </li>
</ul>
<?php
    }
?>
