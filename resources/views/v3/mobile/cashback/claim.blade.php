@extends('v3.mobile.layout.cashback')
@section('cashback_section')
<style type="text/css">
		.c-lable span strong{font-size:18px;}
		.border-bottom{width:94%;padding:10px 0px;clear:both;border-top:2px dashed #e8e9e9!important;border-bottom:none!important;}
		.list-unstyled{margin-top:10px;}		
		.c-lable-data span{font-size:16px;}
		.claim-messages{clear:both;margin-top:20px;display:block;float:left;width:100%;}
		.text-muted strong{font-size:20px;color:#000!important;padding:10px 0;}
		.text-muted{padding:0px 0px!important;}
		.comment{clear:both;}
		.comment span{font-size:15px;padding-bottom:10px!important;display:block;text-align:justify;}
		.msg-date{font-size:16px;color:#000;padding-top:0px!important;}
		.font-weight-bold{font-size:17px;color:#000; font-weight:bold;}
		.post-message{height:80px!important;width:98%!important;margin:20px 0px;float:left;}
		.rounded{clear:both;float:left;}
</style>
    <section>       
            <h2 class="hmb-5">View Your Missing Cashback Claim</h2>
            <ul class="list-unstyled mb-5">
                <li class="media p-2 border-top border-bottom">
                    <div class="c-lable">
                        <span><strong>Created:</strong></span>
                    </div>
                    <div class="media-body">
                        <div class="c-lable-data">
                            <span>{{\Carbon\Carbon::parse($claim->click_time)->format('dS M, Y')}}</span>
                        </div>
                    </div>
                </li>
                <li class="media p-2 my-3 border-top border-bottom">
                    <div class="c-lable">
                        <span><strong>Claim Status:</strong></span>
                    </div>
                    <div class="media-body">
                        <div class="c-lable-data">
                            <span>{{$claim->status}}</span>
                        </div>
                    </div>
                </li>
                <li class="media p-2 my-3 border-top border-bottom">
                    <div class="c-lable">
                        <span><strong>Merchant:</strong></span>
                    </div>
                    <div class="media-body">
                        <div class="c-lable-data">
                            <span>{{config('vendor.name.'.$claim->vendor_id)}}</span>
                        </div>
                    </div>
                </li>
                <li class="media p-2 my-3 border-top border-bottom">
                    <div class="c-lable">
                        <span><strong>Order Date:</strong></span>
                    </div>
                    <div class="media-body">
                        <div class="c-lable-data">
                            <span>{{\Carbon\Carbon::parse($claim->click_time)->format('dS M, Y')}}</span>
                        </div>
                    </div>
                </li>
                <li class="media p-2 my-3 border-top border-bottom">
                    <div class="c-lable">
                        <span><strong>Offer Title:</strong></span>
                    </div>
                    <div class="media-body" style="clear:both;">
                        <div class="c-lable-data">
                            <span>{{$claim->payout->details}}</span>
                        </div>
                    </div>
                </li>
                <li class="media p-2 my-3 border-top border-bottom">
                    <div class="c-lable">
                        <span><strong>Purchase Value:</strong></span>
                    </div>
                    <div class="media-body">
                        <div class="c-lable-data">
                            <span>{{$claim->order_amount}}</span>
                        </div>
                    </div>
                </li>
                <li class="media p-2 my-3 border-top border-bottom">
                    <div class="c-lable">
                        <span><strong>Expected Cashback:</strong></span>
                    </div>
                    <div class="media-body">
                        <div class="c-lable-data">
                            <span>{{$claim->getUserCashback()}}</span>
                        </div>
                    </div>
                </li>
                <li class="media p-2 my-3 border-top border-bottom">
                    <div class="c-lable">
                        <span><strong>Order Number:</strong></span>
                    </div>
                    <div class="media-body">
                        <div class="c-lable-data">
                            <span>{{$claim->order_id}}</span>
                        </div>
                    </div>
                </li>
                @if( $claim->status != 'closed' )
                    <form method="get" style="margin-top:20px;float:left;" onsubmit="return confirm('Are you sure, You want to close the claim ?')">
                        <input type="hidden" name="action" value="close"/>
                        <input type="hidden" name="claim_id" value="{{$claim->ticket_id}}"/>
                        <button type="submit" class="btn btn-primary">Close This Claim</button>
                        <a href="{{route('cashback.missing.claim')}}" class="btn btn-primary">< Back to Claims</a>
                    </form>
                @endif
            </ul>
            <div class="claim-messages">
                <p class="text-muted"><strong>Messages related to your claim</strong></p>
                <div id="comments">
                    @if($claim->comments->count()>0)
                        @foreach( $claim->comments as $comment )
                            @include('v3.mobile.cashback.include.comment')
                        @endforeach
                    @endif
                </div>
                @if( $claim->status != 'closed' )
                    <div class="claim-comment-box mt-5">
                        <div id="errors"></div>
                        <div id="success"></div>
                        <form class="ajax_submit" method="post" action="{{route('cashback.claim.comment',[$claim->ticket_id])}}" data-target="#comments">
                            <textarea class="form-control post-message" required name="comment" placeholder="Write your message here"></textarea>
                            <div class="text-right mt-4">
                                {{csrf_field()}}
                                <button type="submit" class="btn btn-primary rounded">Post a message</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
     
    </section>
@endsection
@section('section_scripts')
    <script>

    </script>
@endsection