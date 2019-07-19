<!DOCTYPE HTML>
<html lang="en-us">
<head>
    <meta charset="utf-8" />
    <title>IndiaShopps</title>
     <link rel="stylesheet" href="<?=asset("/css/v1/bootstrap.min.css")?>" type="text/css" />
	<link rel="stylesheet" href="<?=asset("css/v1/font-awesome.min.css")?>" type="text/css" />
    <script type="text/javascript" src="<?=asset("js/v1/jquery.min.js")?>"></script>
    <script type="text/javascript" src="<?=asset("js/v1/bootstrap.min.js")?>"></script>
	<style>
		.error_header{
			background: #d70d00;
			height:40px;
		}
		.main{margin-top: 100px;}
		.error_500_content{
			color: #999;
			font-family: arial;
			font-size: 17px;
			line-height: 23px;
			margin-top: 48px;
			
		}
		.heading_error{
		    color: #d70d00;
			font-family: inherit;
			font-size: 100px;
		}
		.heading_error1{
			color: #000;
			font-size: 39px;
			margin: -30px;
		}

		 .error_img1{
			margin-top: -46px;
		 }
	</style>
</head>
<body>
<!--==========Header==============-->
<div class="error_header">
</div> 
<div class="container">
	<div class="main">
		<div class="row">
			<div class="col-md-6">
				<h5 class="error_500_content text-center">Something went wrong at our end.<br>
					Don't worry, it's not you - it's us. Sorry about that....
				</h5>
				<br>
				<h1 class="heading_error text-center">Reload
					<span class="heading_error1">Please </span>
				</h1>
			</div>
			<div class="col-md-2">
				<img src="<?=asset("/images/v1/img_500.gif")?>" class="error_img">
			</div>			
			<div class="col-md-3">
				<img src="<?=asset("/images/v1/uh_ho.png")?>" class="error_img1">	
			</div>
		</div>
		<h5 class="error_500_content text-center" style="margin-top:46px;">
			Page doesn't exist or some other error occured. Go to our <a href="/">home page</a> or go back to 
			<a href="<php echo url(); >">previous page </a>
		</h5>
	</div>    
</div>    


</body>
</html>