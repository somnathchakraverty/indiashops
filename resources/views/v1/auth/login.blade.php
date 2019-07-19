@extends('v1.layouts.master')
@section('content')
<div class="wrapper" style="min-height: 370px;">
             <!-- ========================================== about us ========================================= -->
   <div class="container">
      {!! Breadcrumbs::render() !!}
      <div class="row">
      <br>
         <div class="col-sm-3">
            <div>
            <div class="panel panel-default "><!-- stick -->
                   <div class="panel-heading">
                       <h3 class="panel-title">Ads</h3>
                   </div>
               </div>
            </div>
         </div>
         <div class="col-sm-9">
            <div class="row">
               <div class="col-md-6">
                  <?php $messages = $errors->getMessages() ?>
                  <?php if( !empty( $messages ) ): ?>

                  <div class="alert alert-danger" role="alert">
                     <p>Error: </p>
                     <?php foreach( $errors->getMessages() as $msg ): ?>
                        <p> <?=$msg[0]?> </p>
                     <?php endforeach; ?>
                  </div>
                  <?php endif; ?>

                  <?php if( !empty( $success ) ): ?>

                  <div class="alert alert-success" role="alert">
                     <p>Success: </p>
                     <?php foreach( $success as $msg ): ?>
                        <p> <?=$msg?> </p>
                     <?php endforeach; ?>
                  </div>
                  <?php endif; ?>
               </div>
            </div>
            <div class="col-sm-6 col-md-4 col-sm-offset-3">
               <a href="<?=newUrl('slogin/facebook')?>" class="btn facebook col-sm-6"><i class="fa fa-facebook"></i> Facebook</a>
               <a href="<?=newUrl('slogin/google')?>" class="btn google col-sm-6"><i class="fa fa-google-plus"></i> Google</a>
            </div>
            <div class="clearfix"></div>
            <div style="margin-top: 20px;">
               <form id="contact-form" method="post" action="" class="form-horizontal contact-form cf-style-1 inner-top-xs">
                  <input type="hidden" value="{{csrf_token()}}" name="_token">
                  <!-- Name input-->
                  <div id="contact-sm-6" class="form-group">
                     <label for="name" class="col-md-2 control-label">Username*</label>
                     <div class="col-md-6">
                        <input type="email" class="form-control" placeholder="Username *" name="email" id="username" required>
                     </div>
                  </div>
                  <div id="contact-sm-6" class="form-group">
                     <label for="name" class="col-md-2 control-label">Password*</label>
                     <div class="col-md-6">
                        <input type="password" class="form-control" placeholder="Password *" name="password" id="username" required>
                     </div>
                  </div>
                  <div id="contact-sm-6" class="form-group">
                     <label for="name" class="col-md-2 control-label"></label>
                     <div class="col-md-6">
                        <span> <a href="{{url('user/resetPassword')}}">Forgot Password ?</a> </span>
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="name" class="col-md-2 control-label"></label>
                     <div class="col-md-6">
                        <div class="checkbox seller">
                           <label class="fix-slide-checkbox" style="padding-left:0px !important">
                              <input type="checkbox" class="checkbox-inline" name="remember" id="remember">
                              <span>Remember Me</span>
                           </label>
                        </div>
                     </div>
                  </div>
                  <!-- Form actions -->
                  <div class="form-group">
                     <div class="col-sm-3 text-right col-sm-offset-2">
                        <div class="buttons-holder">
                           <button class="form-control btn btn-danger login_btn" type="submit">Login</button>
                        </div><!-- /.buttons-holder -->
                     </div>
                     <div class="col-sm-3 text-right">
                        <div class="buttons-holder">
                           <a class="form-control btn btn-danger login_btn" href="{{url('user/register')}}" type="submit">Register</a>
                        </div><!-- /.buttons-holder -->
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
<!-- ========================================= about end : END ========================================= -->      
</div>
<style type="text/css">
   .btn.facebook{ background: #3b5998 ; font-size:17px; }
   .btn.google{ background:  #dd4b39; font-size:17px;  }
   .btn{ color: #fff; padding: 10px;  }
   .form-control { height: auto; padding:10px;}
	.login_btn{font-size: 16px; padding: 8px;font-weight: 500 !important;}
</style>
@endsection