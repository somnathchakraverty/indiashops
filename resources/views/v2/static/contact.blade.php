@extends('v2.master')
@section('breadcrumbs')
    <section style="background-color:#fff;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sub-menu">
                        <li><a href="{{route("home_v2")}}">Home</a> >>  <a href="#">Contact US</a> </li>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('content')
    <div class="shadow-boxaboutus">
        <div class="container">
            <div class="row">
                <div class="col-md-12 PL0">
                    @if(isset($message))
                        <h4 style='color:red'>{{$message}}</h4>
                    @endif
                    <h3 style="color:#e40046">Feedback & Suggestions !!</h3>
                    <div class="col-md-7">
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
                                <input style="border-radius:5px;" type="text" class="form-control" placeholder="Your Name*" name="name">
                            </div>
                            <div class="form-group">
                                <input style="border-radius:5px;" type="email" class="form-control" placeholder="Your E-mail" name="email">
                            </div>
                            <div class="form-group">
                                <input style="border-radius:5px;" type="text" class="form-control" placeholder="Subject*" name="subject" value="{{( request()->has('report') ) ? base64_decode(request()->get('report')) :''}}">
                            </div>
                            <div class="form-group">
                                <textarea style="border-radius:5px;" class="form-control" rows="3" placeholder="Your message" name="msg"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha" data-them="light" data-sitekey="{{env('CAPTCHA_KEY','6LfU1DUUAAAAAK0UwOnfypfZooNouoqDMu-LGd2C')}}"></div>
                            </div>
                            <button type="submit" class="btn btn-success" style="float:right;">Send Message</button>
                            <button type="reset" class="btn btn-danger" style="float:right; margin:0px 10px 20px 10px;">Reset</button>
                            <input type="hidden" name="_token" value="{{csrf_token()}}" />
                        </form>
                    </div>
                    <div class="col-md-5"><img class="img-responsive" src="{{asset('assets/v2/')}}/images/Contact-Us.jpg"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection