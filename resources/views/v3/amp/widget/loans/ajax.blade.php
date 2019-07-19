<div class="trendingdealsprobox">
    <ul id="part49" class="carousel" data-items="1.5" data-scroll="1">
        @foreach( $loans as $loan )
            <li>
                <div class="thumnail">
                    <div class="loansthumnailimgbox">
                        <img class="banklogoimg" src="{{$loan->logo}}" alt="{{$loan->name}}-bank" onclick="window.open('http://www.indiashopps.com/{{$loan_type}}-loan#bank={{$loan->name}}')">
                    </div>
                    <div class="loans-container">
                        <div class="product_name textcenter">{{$loan->count}} Loan(s) offers from {{$loan->name}}</div>
                        <div class="rate-starts">Int. rate starts at {{$loan->interest}}%</div>
                    </div>
                    <a href="http://www.indiashopps.com/{{$loan_type}}-loan#bank={{$loan->name}}" class="productbutton" target="_blank">
                        VIEW OFFERS
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
</div>
<div class="allcateglink">
    <a href="http://www.indiashopps.com/{{$loan_type}}-loan" target="_blank">
        VIEW ALL {{$loan_type}} Loans
        <img class="right-arrow" src="{{asset('assets/v3/mobile')}}/images/right-arrow-2.png" alt="arrow" width="20" height="20">
    </a>
</div>