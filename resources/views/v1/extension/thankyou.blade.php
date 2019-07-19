@extends('v1.layouts.master')
@section('content')
<div class="wrapper">
             <!-- ========================================== about us ========================================= -->
   <div class="container">
      <div class="row">
      <br>
         {!! Breadcrumbs::render() !!}
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
            
            <?php if( !@$registered ): ?>
               <h1 style="color:#d70d00">Amazing !!! You have taken first step to be a happy Shopper.</h1>
               <p>To get you the best personalized offers & deals based on your choices , please let us know your interests as below. </p>
               <p>We will keep looking for best offers based on your personal choice so you get just what you want. </p>
               <p>Please spread happiness by Liking our page on Facebook and sharing with your Friends & Family. </p>
            <?php else: ?>
               <h1>Already Registered..</h1>
            <?php endif; ?>
            <?php
               if( @$registered )
               {
                  $attr = "disabled";
               }
            ?>
            <?php if( !@$registered ): ?>
            <div class="col-sm-4 col-sm-offset-3">
               <a href="<?=newUrl('slogin/facebook')?>" class="btn facebook col-sm-6"><i class="fa fa-facebook"></i> Facebook</a>
               <a href="<?=newUrl('slogin/google')?>" class="btn google col-sm-6"><i class="fa fa-google-plus"></i> Google</a>
            </div>
            <?php endif; ?>
            <div class="clearfix"></div>
            <div style="margin-top: 20px;">
               <form id="contact-form" method="post" action="" class="form-horizontal contact-form cf-style-1 inner-top-xs">
                  <input type="hidden" value="{{csrf_token()}}" name="_token">
                  <!-- Name input-->
                  <div id="contact-sm-6" class="form-group">
                     <label for="name" class="col-md-2 control-label">Username*</label>
                     <div class="col-md-6">
                        <input type="email" class="form-control" placeholder="Username *" name="username" id="username" required <?=@$attr?> >
                     </div>
                  </div>
                  <div id="contact-sm-6" class="form-group">
                     <label for="name" class="col-md-2 control-label">Password*</label>
                     <div class="col-md-6">
                        <input type="password" class="form-control" placeholder="Password *" name="password" id="username" required <?=@$attr?> >
                     </div>
                  </div>
                  <div id="contact-sm-6" class="form-group">
                     <label for="name" class="col-md-2 control-label">Gender*</label>
                     <div class="col-md-6">
                        <div class="col-md-3">
                           <input type="radio" name="gender" value="male" id="male" checked <?=@$attr?>/> <label for='male'>Male</label>
                        </div>
                        <div class="col-md-3">
                           <input type="radio" name="gender" value="female" id="female" <?=@$attr?>/> <label for='female'>Female</label>
                        </div>
                     </div>
                  </div>
                  <div id="contact-sm-6" class="form-group">
                     <label for="name" class="col-md-2 control-label">Interest</label>
                     <div class="col-md-6">
                        <span>Please let us know your Interest to get relevant Offers...</span>
                        <select multiple="" class="form-control" name="interests[]" style="height: 100px;" <?=@$attr?> >
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
                           <button class="form-control btn btn-danger" type="submit" <?=@$attr?> >Register</button>
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
   .btn.facebook{ background: #3b5998  }
   .btn.google{ background:  #dd4b39 }
   .btn{ color: #fff; padding: 10px;  }
   .form-control { height: auto; }
</style>
@endsection