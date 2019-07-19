@extends('v1.layouts.master')
@section('content')
<main id="contact-us" >
	<div class="container">
		<div class="row">
			<div class="col-md-7" id="contact-col">
				{!! Breadcrumbs::render() !!}
				<section class="section leave-a-message">
					<?php if(isset($message)) { 
						echo "<h2 style='color:red'>".$message."</h2>";
					} ?>
						<h4 class="bordered" style="padding-bottom:10px;">HAVE ANY QUESTION. PLEASE FILL THE FORM</h4>
							<form class="form-horizontal contact-form cf-style-1 inner-top-xs" action="" method="post" id="contact-form" method="post" action="<?php echo url('contact'); ?>">
								<input name="_token" type="hidden" value="<?php echo csrf_token(); ?>"/>
									<!-- Name input-->
									<div class="form-group"  id="contact-sm-6">
									  <label class="col-md-3 control-label" for="name">Your Name*</label>
									  <div class="col-md-9" >
										<input id="name" name="name" type="text" placeholder="Your name" class="form-control" >
									  </div>
									</div>
							
									<!-- Email input-->
									<div class="form-group"  id="contact-sm-6">
									  <label class="col-md-3 control-label" for="email">Your E-mail</label>
									  <div class="col-md-9" >
										<input id="email" name="email" type="text" placeholder="Your email" class="form-control">
									  </div>
									</div>
									<!-- Email input-->
									<div class="form-group"  id="contact-sm-6">
									  <label class="col-md-3 control-label" for="subject">Subject*</label>
									  <div class="col-md-9">
										<input id="subject" name="subject" type="text" placeholder="Subject" class="form-control">
									  </div>
									</div>
									<!-- Message body -->
									<div class="form-group">
									  <label class="col-md-3 control-label" for="message">Your message</label>
									  <div class="col-md-9">
										<textarea class="form-control le-input" name="msg" required id="message" name="message" placeholder="Please enter your message here..." rows="8"></textarea>
									  </div>
									</div>
									<!-- Form actions -->
									<div class="form-group">
									  <div class="col-md-12 text-right">
										<div class="buttons-holder">
											<button type="reset" class="le-button huge btn btn-default" id="reset-button">Reset</button>
											<button type="submit" class="le-button huge btn btn-danger">Send Message</button>
										</div><!-- /.buttons-holder -->
									  </div>
									</div>
						  </form>
				</section><!-- /.leave-a-message -->	
			</div>
			<div class="col-md-5">
				<img src="<?php echo asset('images/img1.jpg'); ?>"  class="img-responsive" style="margin-top: 36px;">
			</div>
			
		</div><!-- /.row -->
	</div><!-- /.container -->
</main>
@endsection