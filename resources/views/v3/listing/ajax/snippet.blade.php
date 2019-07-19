@if( isset($snippet) && !empty($snippet) )
    <table class="table table-striped">
        <thead>
        <tr>
            <?php $all_vars = get_defined_vars();?>
            <th>{{app('seo')->listSnippetTitle($all_vars, "Models List")}}</th>
            <th>Updated Price List</th>
            @if(getSnippetField($all_vars))
                <th>{{getSnippetField($all_vars)}}</th>
            @endif
        </tr>
        </thead>
        <tbody>
        @foreach ($snippet as $single)
        <?php $pro = $single->_source;?>
        <tr>
            <td>{{$pro->name}}</td>
            <td class='red'>Rs. {{number_format($pro->saleprice)}}</td>
            @if(getSnippetField($all_vars))
                <td>{{getSnippetField($all_vars,$pro)}}</td>
            @endif
        </tr>
        @endforeach
        </tbody>
    </table>
@endif