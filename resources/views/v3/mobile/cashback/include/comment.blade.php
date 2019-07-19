<div class="comment">
    <div class="message-title bg-light p-2">
        <div class="row">
            <div class="col-6 col-lg-3 col-md-4">
                <span class="text-muted font-weight-bold">created</span>
            </div>
            <div class="col-6 col-lg-9 col-md-8">
                <span class="text-muted font-weight-bold">comment</span>
            </div>
        </div>
    </div>
    <ul class="list-unstyled text-capitalize">
        <li class="border-bottom p-3">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-4">
                    <p class="msg-date text-muted">
                        {{\Carbon\Carbon::parse($comment->comment_time)->format('dS M, Y')}}
                    </p>
                    <p class="font-weight-bold">{{ucfirst($comment->added_by)}}</p>
                </div>
                <div class="col-6 col-lg-9 col-md-8">
                    <div class="comment">
                        <span>{{$comment->comment}}</span>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>