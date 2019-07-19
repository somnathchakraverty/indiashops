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
            <div class="clearfix"></div>
            <div style="margin-top: 20px;">
               <form id="contact-form" method="post" action="{{url('user/resetPassword')}}" class="form-horizontal contact-form cf-style-1 inner-top-xs">
                  <input type="hidden" value="{{csrf_token()}}" name="_token">
                  <!-- Name input-->
                  <?php if( isset( $user->id ) ): ?>
                     <div id="contact-sm-6" class="form-group">
                        <label for="passwd" class="col-md-2 control-label">Password*</label>
                        <div class="col-md-6">
                           <input type="password" class="form-control" placeholder="Password*" name="password" id="passwd" required>
                        </div>
                     </div>
                     <div id="contact-sm-6" class="form-group">
                        <label for="cpassword" class="col-md-2 control-label">Confirm Password*</label>
                        <div class="col-md-6">
                           <input type="password" class="form-control" placeholder="Confirm Password*" name="cpassword" id="cpassword" required>
                        </div>
                     </div>
                     <!-- Form actions -->
                     <div class="form-group">
                        <div class="col-sm-3 text-right col-sm-offset-2">
                           <div class="buttons-holder">
                              <input type="hidden" value="change_password" name="form_action">
                              <input type="hidden" value="{{$user->remember_token}}" name="rtoken">
                              <button class="form-control btn btn-danger" type="submit" >Change Password</button>
                           </div><!-- /.buttons-holder -->
                        </div>
                     </div>
                  <?php else: ?>
                  <div id="contact-sm-6" class="form-group">
                     <label for="name" class="col-md-2 control-label">Username*</label>
                     <div class="col-md-6">
                        <input type="email" class="form-control" placeholder="Username/Email*" name="email" id="username" required>
                     </div>
                  </div>
                  <!-- Form actions -->
                  <div class="form-group">
                     <div class="col-sm-3 text-right col-sm-offset-2">
                        <div class="buttons-holder">
                           <button class="form-control btn btn-danger" type="submit">Reset Password</button>
                        </div><!-- /.buttons-holder -->
                     </div>
                     <div class="col-sm-3 text-right">
                        <div class="buttons-holder">
                           <a class="form-control btn btn-danger" href="{{url('/user/login')}}" type="submit">Login</a>
                        </div><!-- /.buttons-holder -->
                     </div>
                  </div>
                  <?php endif; ?>
               </form>
            </div>
         </div>
      </div>
   </div>
<!-- ========================================= about end : END ========================================= -->      
</div>
<style type="text/css">
   .btn.facebook{ background: #3b5998  }
   .btn.google{ background:  #dd4b39 }
   .btn{ color: #fff; padding: 10px;  }
   .form-control { height: auto; }
</style>
@endsection