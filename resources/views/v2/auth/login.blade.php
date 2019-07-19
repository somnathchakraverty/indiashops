@extends('v2.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 PL0">
                <div id="login-overlay" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Login to <b>indiashopps.com</b></h4>
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
                                                <label for="username" class="control-label">Username</label>
                                                <input type="email" class="form-control" name="email" value="" required="" title="Please enter your username" placeholder="username">
                                                <span class="help-block"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="control-label">Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="password" value="" required=""
                                                       title="Please enter your password">
                                                <span class="help-block"></span>
                                            </div>
                                            <div id="loginErrorMsg" class="alert alert-error hide">Wrong username or password</div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="remember" id="remember"> Remember login
                                                </label>
                                                <p class="help-block">(if this is a private computer)</p>
                                            </div>
                                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                                            <button type="submit" value="login" name="submit" class="btn btn-success btn-block">Login</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <p class="lead">Register now <span class="text-success">AND</span></p>
                                    <ul class="list-unstyled" style="line-height: 2">
                                        <li><span class="fa fa-check text-success"></span> Compare Products and Save Money</li>
                                        <li><span class="fa fa-check text-success"></span> Get Discount Coupons</li>
                                        <li><span class="fa fa-check text-success"></span> Get Best Deals for All E-commerce sites</li>
                                        <li><span class="fa fa-check text-success"></span> Get Price Alert for Watched Product</li>
                                        <li><span class="fa fa-check text-success"></span> See What is Latest and Trending</li>
                                        <li><span class="fa fa-check text-success"></span> Get Personalised Search Results</li>
                                    </ul>
                                    <p><a href="{{route('register_v2')}}" class="btn btn-info btn-block">Yes please, register now!</a></p>
                                </div>
                                <div class="">
                                    <div class="col-xs-12">
                                        <a href="<?=newUrl('slogin/facebook')?>" class="btn facebook col-sm-6"><i class="fa fa-facebook"></i> Facebook</a>
                                        <a href="<?=newUrl('slogin/google')?>" class="btn google col-sm-6"><i class="fa fa-google-plus"></i> Google</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <style>
        .btn.facebook{ background: #3b5998 ; font-size:17px; }
        .btn.google{ background:  #dd4b39; font-size:17px;  }
        .btn{ color: #fff; padding: 10px;  }
        .form-control { height: auto; padding:10px;}
    </style>
@endsection