@extends('v3.master')
@section('page_content')
    <style>
        .fake { background: #fff; padding: 10px !important; border-radius: 5px !important; -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, .5) !important; box-shadow: 0 5px 15px rgba(0, 0, 0, .5) !important; text-align: center !important; }
    </style>
    <div class="container">
        {!! Breadcrumbs::render() !!}
    </div>
    <div class="container">
        @if(isset($message))
            <h4 style='color:red'>{{$message}}</h4>
        @endif
        <div class="sub-title mtop2 fake">We are just reminding you to be aware of fake activities, promotion campaign
            or any such type of fake actions. As of now, we are not running any kind of promotional campaign. Please be
            Aware of Fake Calls or Promotion Campaign.
        </div>
        <div class="sub-title mtop2">Feedback & Suggestions !!</div>
        <div class="col-md-7 pleft">
            <div class="modal-content registration padding20">
                @if($errors->count()>0)
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Name*" name="name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Your E-mail" name="email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Subject*" name="subject" value="{{( request()->has('report') ) ? base64_decode(request()->get('report')) :''}}">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="Your message" name="msg"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha floatleft" data-them="light" data-sitekey="{{env('CAPTCHA_KEY','6LfU1DUUAAAAAK0UwOnfypfZooNouoqDMu-LGd2C')}}"></div>
                    </div>
                    <div class="contbutton">
                        <button type="submit" class="btn btn-success sendmessage">Send Message</button>
                        <button type="reset" class="btn btn-danger sendmessage">Reset</button>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                </form>
            </div>
        </div>
        <div class="col-md-5">
            <img class="img-responsive" src="{{asset('assets/v2/')}}/images/Contact-Us.jpg" alt="About Indiashopps"/>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js" defer></script>
@endsection