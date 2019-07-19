<div class="trendingdealsprobox">
<div class="cs_dkt_si">
    <ul>
        @foreach( $loans as $loan )
        <li class="thumnail">           
                <div class="loansthumnailimgbox">
                    <img class="productimg" src="{{$loan->logo}}" alt="{{$loan->name}}-bank" onclick="window.open('http://www.indiashopps.com/{{$loan_type}}-loan')">
                </div>
                <div class="loans-container">
                    <span class="product_name textcenter" onclick="window.open('http://www.indiashopps.com/{{$loan_type}}-loan')">{{$loan->count}} Loan(s) offers from {{$loan->name}}</span>
                    <span class="rate-starts" onclick="window.open('http://www.indiashopps.com/{{$loan_type}}-loan')">Int. rate starts at {{$loan->interest}}%</span>
                </div>
                <a href="http://www.indiashopps.com/{{$loan_type}}-loan" class="productbutton" target="_blank">VIEW OFFERS</a>
        </li>
        @endforeach
    </ul>
</div>
</div>