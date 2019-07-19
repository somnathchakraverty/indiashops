<div class="whitecolorbg">
    <div class="container">
        <div class="pricetablecat" id="specifications">
            <div class="more-less-toggledetails">
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
                        <?php $pro = $single->_source; ?>
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
            </div>
        </div>
    </div>
</div>
<a href="javascript:void;" class="productbutton orangebutton" id="toggle-btndetails">View More</a>
<script>
    $(document).on('click', '#toggle-btndetails', function () {
        if ($('.more-less-toggledetails').hasClass('show')) {
            $('.more-less-toggledetails').removeClass('show');
            $(this).html("View More");

            $('html, body').animate({
                scrollTop: $("#specifications").offset().top - 20
            }, 100);
        }
        else {
            $('.more-less-toggledetails').addClass('show');
            $(this).html("Show Less");
        }
    });
</script>