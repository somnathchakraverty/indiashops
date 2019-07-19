    <div class="css-carousel">       
            <ul>
                @foreach( $loans as $loan )
                    <li>
                        <div class="thumnail">
                            <div class="loansthumnailimgbox">
                                <img class="banklogoimg" data-src="{{$loan->logo}}" alt="{{$loan->name}}-bank" onclick="window.open('http://www.indiashopps.com/{{$loan_type}}-loan#bank={{$loan->name}}')">
                            </div>
                            <div class="loans-container">
                                <div class="product_name textcenter">{{$loan->count}} Loan(s) offers
                                    from {{$loan->name}}</div>
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
    <a href="http://www.indiashopps.com/{{$loan_type}}-loan" class="allcateglink" target="_blank">
        VIEW ALL {{$loan_type}} Loans
        <span class="right-arrow"></span>
    </a>
