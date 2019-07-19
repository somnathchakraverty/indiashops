@extends('v1.layouts.master')
@section('content')
<div class="wrapper">
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
                  <?php if( $errors->count() ): 
                     $messages = $errors->getMessages(); ?>

                  <div class="alert alert-danger" role="alert">
                     <p>Error: </p>
                     <?php foreach( $messages as $msg ): ?>
                        <p> <?=$msg[0]?> </p>
                     <?php endforeach; ?>
                  </div>
                  <?php endif; ?>
               </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-6  col-md-4 col-sm-offset-3">
               <a href="<?=newUrl('slogin/facebook')?>" class="btn facebook col-sm-6"><i class="fa fa-facebook"></i> Facebook</a>
               <a href="<?=newUrl('slogin/google')?>" class="btn google col-sm-6"><i class="fa fa-google-plus"></i> Google</a>
            </div>
            <div class="clearfix"></div>
            <div style="margin-top: 20px;">
               <form id="contact-form" method="post" action="" class="form-horizontal contact-form cf-style-1 inner-top-xs">
                  <input type="hidden" value="{{csrf_token()}}" name="_token">
                  <!-- Name input-->
                  <div id="contact-sm-6" class="form-group">
                     <label for="username" class="col-md-2 control-label">Username*</label>
                     <div class="col-md-6">
                        <input type="email" class="form-control" placeholder="Email Address*" name="email" id="username" required>
                     </div>
                  </div>
                  <div id="contact-sm-6" class="form-group">
                     <label for="passwd" class="col-md-2 control-label">Password*</label>
                     <div class="col-md-6">
                        <input type="password" class="form-control" placeholder="Password *" name="password" id="passwd" required>
                     </div>
                  </div>
                  <div id="contact-sm-6" class="form-group">
                     <label for="name" class="col-md-2 control-label">Name*</label>
                     <div class="col-md-6">
                        <input type="text" class="form-control" placeholder="Name *" name="name" id="name" required>
                     </div>
                  </div>
                  <div id="contact-sm-6" class="form-group">
                     <label for="male" class="col-md-2 control-label">Gender*</label>
                     <div class="col-md-6">
                        <div class="col-md-3">
                           <input type="radio" name="gender" value="male" id="male" checked> <label for='male'>Male</label>
                        </div>
                        <div class="col-md-3">
                           <input type="radio" name="gender" value="female" id="female"> <label for='female'>Female</label>
                        </div>
                     </div>
                  </div>
                  <div id="contact-sm-6" class="form-group">
                     <label for="interests" class="col-md-2 control-label">Interest</label>
                     <div class="col-md-6">
                        <span>Please let us know your Interest to get relevant Offers...</span>
                        <select multiple="" class="form-control" name="interests[]" id="interests" style="height: 100px;" >
                           <?php foreach( $cats as $cat ) : ?>
                              <option value="<?=$cat->id?>"><?=$cat->name?></option>
                           <?php endforeach; ?>
                        </select>
                        <span>Press Ctrl to select Multiple options</span>
                     </div>
                  </div>
                  <!-- Form actions -->
                  <div class="form-group">
                     <div class="col-sm-4 text-right col-sm-offset-3">
                        <div class="buttons-holder">
                           <button class="form-control btn btn-danger register_btn" type="submit">Register</button>
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
   .btn.facebook{ background: #3b5998 ; font-size: 17px; }
   .btn.google{ background:  #dd4b39 ; font-size: 17px;}
   .btn{ color: #fff; padding: 10px;  }
   .form-control { height: auto; padding: 10px;}
   .register_btn{font-size: 16px; font-weight: 500 !important; padding: 8px;}
</style>
@endsection