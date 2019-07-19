@if(isset($questions )&& !empty($questions))
    <div class="whitecolorbg">
        <div class="sub-title"><span>{{ucwords($name)}} - Questions And Answers</span></div>
        @foreach($questions as $k => $q)
            @if(!empty($q->question) && count($q->answer) > 0)
                <div class="questionsdetails">
                    <h3><b>Q. </b>{{$q->question}}</h3>
                    <ul>
                        @foreach($q->answer as $key => $ans)
                            @if(!empty($ans))
                                <li>{{$ans}}</li>
                            @endif
                            @if($key>=5)
                                <?php break; ?>
                            @endif
                        @endforeach
                    </ul>
                </div>
                @if($k>=3)
                    <?php break; ?>
                @endif
            @endif
        @endforeach
    </div>
@endif