<amp-selector role="tablist" layout="container" class="ampTabContainer">
    <?php $i = 0 ?>
    @foreach($loans as $loan_type => $type_loans)
        <div role="tab" class="tabButton tableft15" {{($i++==0) ? 'selected' : ''}} option="a">{{unslug($loan_type)}}</div>
        <div role="tabpanel" class="tabContent">
            <amp-carousel class="full-bottom" height="210" layout="fixed-height" type="carousel">
                @foreach( $type_loans as $loan )
                    <div class="thumnail">
                        <div class="loansthumnailimgbox">
                            <a href="https://www.indiashopps.com/{{$loan_type}}-loan#bank={{$loan->name}}" target="_blank">
                                <amp-img class="banklogoimg" src="{{$loan->logo}}" width="80" height="80" alt="{{$loan->name}}-bank"></amp-img>
                            </a>
                        </div>
                        <div class="loans-container">
                            <div class="product_name textcenter">{{$loan->count}} Loan(s) offers
                                from {{$loan->name}}</div>
                            <div class="rate-starts">Int. rate starts at {{$loan->interest}}%</div>
                        </div>
                        <a href="http://www.indiashopps.com/{{$loan_type}}-loan#bank={{$loan->name}}" class="productbutton" target="_blank">
                            View Offers
                        </a>
                    </div>
                @endforeach
            </amp-carousel>
            <div class="allcateglink">
                <a href="http://www.indiashopps.com/{{$loan_type}}-loan">
                    VIEW ALL {{unslug($loan_type)}} Loans <i class="fa fa-angle-right right-arrow"></i>
                </a>
            </div>
        </div>
    @endforeach
</amp-selector>