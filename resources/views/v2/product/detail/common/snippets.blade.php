<div class="whitecolorbg">
    <div class="sub-title"><span>{{explode(" ",$name)[0]}} Price List in India</span></div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th width="5%">#</th>
            <th width="80%">{{$name}}</th>
            <th width="15%">Price in India</th>
        </tr>
        </thead>
        <tbody>
            @foreach($products as $key => $product)
            <?php $p = $product->_source ?>
                <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>
                        <a href="{{product_url($p)}}" target="_blank">{{$p->name}}</a>
                    </td>
                    <td>Rs. {{number_format($p->saleprice)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
