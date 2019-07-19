@extends('v3.mobile.master')
<style>
.search-header{width:100%!important;height:45px!important;}
.facebook{background:#3b5998;border-radius:5px;font-size:16px;font-weight:700;width:38%;display:inline-block;text-align:center;float:left;margin-right:20px}
.google{background:#dd4b39;border-radius:5px;font-size:16px;font-weight:700;width:38%;display:inline-block;text-align:center}
.btn{color:#fff;padding:10px}
.modal-dialog{width:100%;margin:auto;margin-top:30px}
.modal-title{text-align:center!important;font-size:16px!important;font-weight:700!important}
.loginfbg{width:90%;margin:15px auto}
.modal-content{position:relative;background-color:#fff;-webkit-background-clip:padding-box;background-clip:padding-box;border:1px solid #999;overflow:hidden;border:1px solid rgba(0,0,0,.2);border-radius:6px;outline:0;-webkit-box-shadow:0 3px 9px rgba(0,0,0,.5);box-shadow:0 3px 9px rgba(0,0,0,.5)}
.well{min-height:20px;padding:19px;width:80%;margin:20px auto;overflow:hidden;background-color:#f5f5f5;border:1px solid #e3e3e3;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.05);box-shadow:inset 0 1px 1px rgba(0,0,0,.05)}
label{display:inline-block;max-width:100%;font-size:15px;font-weight:700}
.loginidtext{font-size:13px;color:#000;font-weight:500;height:42px;margin-bottom:10px;padding:0 10px;width:100%;border-radius:5px;border:1px solid #bbb;outline:none}
.textarea{font-size:13px;color:#000;font-weight:500;height:80px;margin-bottom:10px;padding:0 10px;width:100%;border-radius:5px;border:1px solid #bbb;outline:none}
.btn-success{color:#fff;background-color:#449d44;border-color:#398439;width:45%;float:left;border:none;font-size:16px;font-weight:700;padding:12px 0;border-radius:5px}
.rebtn-info{color:#fff;background-color:#5bc0de;border-color:#46b8da;float:right;font-weight:700;margin-top:0;border-radius:5px}
#myModalLabel b{text-transform:uppercase}
.padding20{padding:20px}
.sub-title{font-size:22px;font-weight:700;text-align:left;color:#1f2228;padding:0;margin:15px 0}
.rlist{width:100%;border:1px solid #c7c7c7;padding:5px;margin-bottom:15px;outline:none}
.registration label span{color:red}
.registrationsubmit{background-image:linear-gradient(to left,#ff774c,#ff3131)!important;color:#fff!important;border:none;font-size:14px;border-radius:5px;font-weight:700;padding:12px 15px}
.alert ul li{text-align:left;font-size:13px;color:red}
.fake{background:#fff;padding:10px!important;font-size:17px!important;border-radius:5px!important;-webkit-box-shadow:0 5px 15px rgba(0,0,0,.5)!important;box-shadow:0 5px 15px rgba(0,0,0,.5)!important;text-align:center!important}
</style>
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render() !!}
        </div>
    </section>
    <div class="container">
        @if(isset($message))
            <h4 style='color:red'>{{$message}}</h4>
        @endif
        <div class="sub-title mtop2 fake">We are just reminding you to be aware of fake activities, promotion campaign or any such type of fake actions. As of now, we are not running any kind of promotional campaign. Please be Aware of Fake Calls or Promotion Campaign.</div>
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
                        <input type="text" class="form-control loginidtext" placeholder="Your Name*" name="name">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control loginidtext" placeholder="Your E-mail" name="email">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control loginidtext" placeholder="Subject*" name="subject" value="{{( request()->has('report') ) ? base64_decode(request()->get('report')) :''}}">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control textarea" rows="3" placeholder="Your message" name="msg"></textarea>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha floatleft" data-them="light" data-sitekey="{{env('CAPTCHA_KEY','6LfU1DUUAAAAAK0UwOnfypfZooNouoqDMu-LGd2C')}}"></div>
                    </div>
                    <div class="contbutton" style="margin-top:15px;">
                        <button type="submit" class="btn btn-success sendmessage">Send Message</button>
                        <button type="reset" class="btn btn-danger registrationsubmit" style="float:right;">Reset
                        </button>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                </form>
            </div>
        </div>
    </div>
    <div class="whitecolorbg" style="margin-top:20px;">
        <div class="container"><img class="img-responsive" src="{{asset('assets/v2/')}}/images/Contact-Us.jpg"></div>
    </div>
@endsection
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="{{get_file_url('mobile/js/front.js')}}" defer></script>
    <script>
        function loadCarousels(){}
        function uiLoaded(){}
    </script>
@endsection