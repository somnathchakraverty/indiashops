@extends('v3.master')
@section('page_content')
    <div class="container">
                <div id="login-overlay" class="modal-dialog">
                    <div class="modal-content loginpage">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Login to <b>indiashopps.com</b></h4>
                            <div class="cshbcktext">Register to claim the Cashback Offer</div>
                            <?php if( $errors->count() ):
                            $messages = $errors->getMessages(); ?>
                            <br/>
                            <div class="alert alert-danger" role="alert">
                                <p>Error: </p>
                                <?php foreach( $messages as $msg ): ?>
                                <p> <?=$msg[0]?> </p>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="well">
                                        <form id="loginForm" method="post">
                                            <div class="form-group">
                                                <label for="username" class="control-label" style="font-weight:bold;font-size:15px;">Username</label>
                                                <input type="email" class="form-control loginidtext" name="email" value="" required="" title="Please enter your username" placeholder="Username" id="username">
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="control-label" style="font-weight:bold;font-size:15px;">Password</label>
                                                <input type="password" class="form-control loginidtext" name="password" placeholder="Password" value="" required=""
                                                       title="Please enter your password" id="password">
                                                <span class="help-block"></span>
                                            </div>
                                            <div id="loginErrorMsg" class="alert alert-error hide">Wrong username or
                                                Password
                                            </div>
                                            <div class="checkbox_for">
                                                <input type="checkbox" name="remember" id="remember">
                                                <label for="remember" style="float:left;font-weight:bold;"><span></span>Remember Login</label>
                                                <!--<p class="help-block">(if this is a private computer)</p>-->
                                                <a class="forgot_pas" href="{{route('password.reset_form')}}">Forgot Password ?</a>
                                            </div>

                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <div class="butn">
                                            <button type="submit" value="login" name="submit" style="float:left; width:40%;" class="btn btn-success btn-block">Login</button>
                                            <a href="{{route('register_v2')}}" class="btn btn-info btn-block registerbutton">Register Now!</a>
                                            </div>
                                        </form>
                                        
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <p class="lead">Register Now <span class="text-success">AND</span></p>
                                    <ul class="list-unstyled" style="line-height: 2">
                                        <li><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                                            Compare Products and Save Money
                                        </li>
                                        <li><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                                            Get Discount Coupons
                                        </li>
                                        <li><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                                            Get Best Deals for All E-commerce sites
                                        </li>
                                        <li><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                                            Get Price Alert for Watched Product
                                        </li>
                                        <li><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                                            See What is Latest and Trending
                                        </li>
                                        <li><span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>
                                            Get Personalised Search Results
                                        </li>
                                    </ul>
                                   
                                   <div class="butn">
                                        <a href="<?=newUrl('slogin/facebook')?>" class="btn facebook facebooklogin col-sm-5">Facebook</a>
                                        <a href="<?=newUrl('slogin/google')?>" class="btn google googlelogin col-sm-5">Google</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
   
@endsection
@section('scripts')
<style>
.btn.facebook{background:#3b5998;font-size:17px;}
.btn.google{background:#dd4b39;font-size:17px;}
.btn{color:#fff;padding:10px;}
.modal-dialog{top:0px!important; margin:0 auto;}
.cshbcktext{color:#ff714a;font-size:15px;font-weight:bold;text-align:center;overflow:hidden;padding:0px;text-transform:uppercase;}
.forgot_pas{font-size:12px;color:#ff3633;font-weight:bold;float:right;}
.checkbox{margin:0px; padding:0px;}
.list-unstyled li{font-size:14px!important;}
.checkbox_for{margin:0px; padding:0px;}
.butn{margin-top:10px;padding:0px;clear:both;width:100%;display:inline-block;}
.registerbutton{margin-top:0px;float:right;}
.btn.facebook{background:#3b5998;font-size:15px;width:48%;}
.btn.google{background:#dd4b39;font-size:15px;width:48%;}
.loginpage{top:20px!important;margin:20px 0px;background:url(../assets/v3/images/reg_bg_co.jpg) top center;}
</style>
@endsection