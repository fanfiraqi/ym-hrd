<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<title>Droopy I Fast build Admin dashboard for any platform</title>
		<meta name="description" content="Droopy is a Dashboard & Admin Site Responsive Template by hencework." />
		<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Droopy Admin, Droopyadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
		<meta name="author" content="hencework"/>
		
		<!-- Favicon-->
		<link rel="icon" type="image/png" href="<?php echo base_url('assets/img/favicon.ico');?>" />
		
		<!-- vector map CSS -->
		<link href="<?php echo base_url('assets/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css');?>" rel="stylesheet" type="text/css"/>
		
			
		<!-- Custom CSS -->
		<link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet" type="text/css">
	</head>
	<body>
		<!--Preloader-->
		<div class="preloader-it">
			<div class="la-anim-1"></div>
		</div>
		<!--/Preloader-->
		
		<div class="wrapper  pa-0">
			<header class="sp-header">
				<div class="sp-logo-wrap pull-left">
					<a href="index.html">
						<img class="brand-img mr-10" src="<?php echo base_url('assets/img/logo.png');?>" alt="brand"/>
						<span class="brand-text">Droopy</span>
					</a>
				</div>
				<div class="form-group mb-0 pull-right">
					<span class="inline-block pr-10">Don't have an account?</span>
					<a class="inline-block btn btn-success  btn-rounded btn-outline" href="signup.html">Sign Up</a>
				</div>
				<div class="clearfix"></div>
			</header>
			
			<!-- Main Content -->
			<div class="page-wrapper pa-0 ma-0 auth-page" >
				<div class="container-fluid" >
					<!-- Row -->
					<div class="table-struct full-width full-height" >
						<div class="table-cell vertical-align-middle auth-form-wrap">
							<div class="auth-form  ml-auto mr-auto no-float">
								<div class="row">
									<div class="col-sm-12 col-xs-12" style="border:solid #000 1px !important;">
										<div class="mb-30">
											<h3 class="text-center txt-dark mb-10">Sign in to Droopy</h3>
											<h6 class="text-center nonecase-font txt-grey">Enter your details below</h6>
										</div>	
										<div class="form-wrap" >
											<form action="#">
												<div class="form-group">
													<label class="control-label mb-10" for="exampleInputEmail_2">Email address</label>
													<input type="email" class="form-control" required="" id="exampleInputEmail_2" placeholder="Enter email">
												</div>
												<div class="form-group">
													<label class="pull-left control-label mb-10" for="exampleInputpwd_2">Password</label>
													<a class="capitalize-font txt-primary block mb-10 pull-right font-12" href="forgot-password.html">forgot password ?</a>
													<div class="clearfix"></div>
													<input type="password" class="form-control" required="" id="exampleInputpwd_2" placeholder="Enter pwd">
												</div>
												
												<div class="form-group">
													<div class="checkbox checkbox-primary pr-10 pull-left">
														<input id="checkbox_2" required="" type="checkbox">
														<label for="checkbox_2"> Keep me logged in</label>
													</div>
													<div class="clearfix"></div>
												</div>
												<div class="form-group text-center">
													<button type="submit" class="btn btn-success  btn-rounded">sign in</button>
												</div>
											</form>
										</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
					<!-- /Row -->	
				</div>
				
			</div>
			<!-- /Main Content -->
		
		</div>
		<!-- /#wrapper -->
		
		<!-- JavaScript -->
		
		<!-- jQuery -->
		<script src="<?php echo base_url('assets/vendors/bower_components/jquery/dist/jquery.min.js');?>"></script>
		  <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.backstretch.min.js');?>"></script>
	 <script>
		var fullUrl = window.location.origin+window.location.pathname;		
		//alert(fullUrl+"assets/img/loginback.jpg");			
		 var x=$.backstretch(fullUrl+"assets/img/loginback.jpg", {speed: 500});
		// alert(x);
     </script>  
		<!-- Bootstrap Core JavaScript 
		<script src="<?php echo base_url('assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
		<script src="<?php echo base_url('assets/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js');?>"></script>-->
		
		<!-- Slimscroll JavaScript -->
		<script src="<?php echo base_url('assets/js/jquery.slimscroll.js');?>"></script>
		 <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
  
		<!-- Init JavaScript -->
		<script src="<?php echo base_url('assets/js/init.js');?>"></script>
		
	</body>
</html>
