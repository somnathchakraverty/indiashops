<?php if( !empty($c_name) ) :

$snippetscript = array();
$snippetscript['@context'] = "http://schema.org/";
$snippetscript['@type'] = "ItemList";
?>
@if(!isset($title))
    @if( strtolower($c_name) == "mobiles" || strtolower($c_name) == "tablets" )
        <?php $c_name = ucfirst( rtrim($c_name, "s") ) ?>
    @else
        <?php $c_name = ucfirst( $c_name ) ?>
    @endif
    @if(isset($brand) && !empty($brand))
        @if( strtolower($brand) == "lg" || strtolower($brand) == "htc" || strtolower($brand) == "hp" )
            <?php $c_brand = strtoupper($brand) ?>
        @else
            <?php $c_brand = ucfirst( $brand ) ?>
        @endif
    @endif
    <?php $snip_name = "";
    if(isset($brand) && !empty($brand)):
        $snip_name = $c_brand." ";
    endif;
    if(isset($parent) && ($parent == "men" || $parent == "women") )
    {
        $snip_name .= ucfirst($parent)." ";
    }
    if(isset($parent) && ($parent == "kids" && (isset($child) && ($child == "boy-clothing" || $child == "girl-clothing" || $child == "boys-footwear" || $child == "girls-footwear"))) )
    {
        $snip_name .= ucfirst( str_replace("-clothing", "",(str_replace("-footwear", "", $child))) )." ";
    }

    $snip_name .= $c_name;

    ?>
@endif
<div class="thumbnaillisttable whitecolorbg listing-product-box MT15">
    <div class="bs-example" data-example-id="striped-table">
        <div class="col-md-12">
            <h2 id="finder-heading" style="float:left;padding:10px; margin:0px;">
                <?php if(isset($h1)){
                    echo $h1;
                }else{
                    echo $snip_name. " Price List in India";
                } ?>

            </h2>
            <div class="clearfix"></div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Position</th>
                    <th><?php if(isset($h1)){echo $h1;}else{echo $snip_name. " Price List in India";} ?> </th>
                    <th>Prices</th>
                    <th>Rating</th>
                </tr>
                </thead>
                <tbody>
                <?php if(!empty($product)):
                    $snippetscript['itemListElement'] = array();
                    $i=0;
                    foreach($snippet as $single ):
                        $pro = $single->_source;
                        $rand = $pro->id;
                        /*if( $pro->vendor != 0 )
                        {
                         if( $book )
                             $proURL = url('product/detail/'.create_slug($pro->name." book")."/".$single->_id );
                         else
                             $proURL = url('product/detail/'.create_slug($pro->name)."/".$single->_id );
                     }else{
                         $proURL = url('product/'.create_slug($pro->name)."/".$pro->id );
                     }*/
                        echo "<tr>".
                                "<td>".($i+1)."</td>".
                                "<td>$pro->name</td>".
                                "<td class='red'>Rs.". number_format($pro->saleprice)."</td>";
                        if($rand % 2 == 0)
                            echo "<td>4/5</td>";
                        elseif($rand % 3 == 0)
                            echo "<td>4.5/5</td>";
                        else
                            echo "<td>5/5</td>";
                        echo "</tr>";
                        $i++;
                    endforeach;
                endif;
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>