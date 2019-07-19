@if( isset($snippets) && !empty($snippets) )
    <table class="table table-striped">
        <thead>
        <tr>
            <?php $all_vars = get_defined_vars();?>
            <th width="50%">Offers</th>
            @if($has_codes)
                <th width="30%">Coupon Code</th>
            @else
                <th width="30%">Offer Categories</th>
            @endif
            <th width="20%">Expiry Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($snippets as $single)
            <?php $pro = $single->_source;?>
            <tr>
                <td>{{$pro->title}}</td>
                @if($has_codes)
                    <td class='red'>{{(($pro->type == 'promotion') ? "Promotion" : $pro->code)}}</td>
                @else
                    <td>{{implode(", ",$pro->sub_cat)}}</td>
                @endif
                <td>{{carbon($pro->expiry_date,"d-m-Y", "Y-m-d")}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif