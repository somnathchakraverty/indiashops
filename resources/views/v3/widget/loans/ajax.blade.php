<a class="alltab" href="http://www.indiashopps.com/{{$loan_type}}-loan" target="_blank">
    VIEW ALL {{$loan_type}} Loans <span class="arrow">&rsaquo;</span>
</a>
<div class="trendingdealsprobox">
    <div class="cs_dkt_si">
        <ul>
            @foreach( $loans as $loan )
                <li class="thumnail">                    
                        <div class="loansthumnailimgbox">
                            <img class="productimg" src="{{getImageNew("","M")}}" data-src="{{$loan->logo}}" alt="{{$loan->name}}-bank" onclick="window.open('http://www.indiashopps.com/{{$loan_type}}-loan#bank={{$loan->name}}')">
                        </div>
                        <div class="loans-container">
                            <div class="product_name textcenter" onclick="window.open('http://www.indiashopps.com/{{$loan_type}}-loan')">{{$loan->count}}
                                Loan(s) offers from {{$loan->name}}</div>
                            <div class="rate-starts" onclick="window.open('http://www.indiashopps.com/{{$loan_type}}-loan')">
                                Int. rate starts at {{$loan->interest}}%
                            </div>
                        </div>
                        <a href="https://www.indiashopps.com/{{$loan_type}}-loan#bank={{urlencode($loan->name)}}" class="productbutton" target="_blank">VIEW
                            OFFERS</a>
                </li>
            @endforeach
        </ul>
    </div>
</div>