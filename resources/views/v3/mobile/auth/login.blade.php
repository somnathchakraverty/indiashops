@extends('v3.mobile.master')
<style>
    .search-header { width: 100% !important; height: 45px !important; }
    .facebook { background: #3b5998; border-radius: 5px; font-size: 16px; font-weight: 700; width: 38%; display: inline-block; text-align: center; float: left; margin-right: 20px }
    .google { background: #dd4b39; border-radius: 5px; font-size: 16px; font-weight: 700; width: 38%; display: inline-block; text-align: center }
    .btn { color: #fff; padding: 10px }
    .modal-dialog { width: 100%; margin: auto; margin-top: 30px; }
    .modal-title { text-align: center !important; font-size: 16px !important; font-weight: 700 !important }
    .loginfbg { width: 90%; margin: 15px auto }
    .modal-content { position: relative; background:url(../assets/v3/images/reg_bg_co.jpg) top center; -webkit-background-clip: padding-box; background-clip: padding-box; border: 1px solid #999; border: 1px solid rgba(0, 0, 0, .2); border-radius: 6px; outline: 0; -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, .5); box-shadow: 0 3px 9px rgba(0, 0, 0, .5) }
    .well { min-height: 20px; padding: 19px; width: 80%; margin: 20px auto; overflow: hidden; background-color: #f5f5f5; border: 1px solid #e3e3e3; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05); box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05) }
    label { display: inline-block; max-width: 100%; font-size: 15px; font-weight: 700 }
    .loginidtext { font-size: 13px; color: #000; font-weight: 500; height: 42px; margin-bottom: 10px; padding: 0px 10px; width: 100%; border-radius: 5px; border: 1px solid #bbb; outline: none; }
    .btn-success { color: #fff; background-color: #449d44; border-color: #398439; width: 45%; float: left; border: none; font-size: 16px; font-weight: 700; padding: 12px 0; border-radius: 5px }
    .btn-info { color: #fff; background-color: #5bc0de; border-color: #46b8da; float: right; font-weight: 700; margin-top: -17px; border-radius: 5px }
    #myModalLabel b { text-transform: uppercase; }
    .alert p { text-align: left; font-size: 13px; color: #ff0000; }
    .cshbcktext { color: #ff6746; font-size: 14px; text-transform: uppercase; font-weight: bold; text-align: center; }
</style>
@section('page_content')
    <section>
        <div class="container">
            {!! Breadcrumbs::render("login") !!}
        </div>
    </section>
    <div class="container">
        <div id="login-overlay" class="modal-dialog">
            <div class="modal-content loginpage">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel" style="padding-top:15px;">
                        Login to <b>indiashopps.com</b>
                    </h4>
                    <div class="cshbcktext">Register to claim the Cashback Offer</div>
                    <div class="loginfbg">
                        <a href="<?=newUrl('slogin/facebook')?>" class="btn facebook">Facebook</a>
                        <a href="<?=newUrl('slogin/google')?>" class="btn google">Google</a>
                    </div>
                    @if( $errors->count() )
                        <br/>
                        <div class="alert alert-danger" role="alert" style="padding: 0 20px">
                            <p>Error: </p>
                            @foreach( $errors->getMessages() as $msg )
                                <p>
                                    {{$msg[0]}}
                                </p>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="modal-body">
                    <div class="well">
                        <form id="loginForm" method="post">
                            <div class="form-group">
                                <label for="username" class="control-label">Username</label>
                                <input type="email" class="form-control loginidtext" name="email" value="" required="" title="Please enter your username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" class="form-control loginidtext" name="password" placeholder="Password" value="" required=""
                                       title="Please enter your password">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <a href="{{route('password.reset_form')}}" style="font-size:13px;font-weight:bold;">Forgot Password ?</a>
                                <br/><br/>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="submit" value="login" name="submit" class="btn btn-success btn-block">Login
                            </button>
                        </form>
                        <a href="{{route('register_v2')}}" class="btn btn-info btn-block registerbutton">Register
                            Now!
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{get_file_url('mobile/js/front.js')}}" defer></script>
    <script>
        function loadCarousels() {}
        function uiLoaded() {}
    </script>
@endsection