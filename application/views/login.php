<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Login Page - HRD APPS  <?php if (isset($pagetitle)) echo ' - '.$pagetitle;?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('assets/loginstyle/bootstrap.css');?>" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url('assets/css/font-awesome.min.css');?>" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/loginstyle/style.css');?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/loginstyle/style-responsive.css');?>" rel="stylesheet">
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');?>">
	<link rel="icon" href="<?php echo base_url('assets/img/favicon.ico');?>" type="image/x-icon">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js');?>"></script>
      <script src="<?php echo base_url('https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js');?>"></script>
    <![endif]-->
  </head>

  <body >

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <div class="form-login" >
		        <h2 class="form-login-heading">sign in now <?php var_dump(get_cookie('code'));?></h2>
		        <div class="login-wrap">
		            <input type="text" class="form-control"  name="username" id="username" placeholder="User ID" autofocus>
		            <br>
		            <input type="password" name="password"  id="password" class="form-control" placeholder="Password">
		            <label class="checkbox">
		                <span class="pull-right">
		                    <a data-toggle="modal" href="login.html#myModal"> Forgot Password?</a>
		
		                </span>
		            </label>
		            <button class="btn btn-theme btn-block" onclick="dologin()"><i class="fa fa-lock"></i> SIGN IN</button>
					<div id="formmsg" class="no-display alert alert-danger"></div>
		            <hr>
		            
		            <!-- <div class="login-social-link centered">
		            <p>or you can sign in via your social network</p>
		                <button class="btn btn-facebook" type="submit"><i class="fa fa-facebook"></i> Facebook</button>
		                <button class="btn btn-twitter" type="submit"><i class="fa fa-twitter"></i> Twitter</button>
		            </div>
		            <div class="registration">
		                Don't have an account yet?<br/>
		                <a class="" href="#">
		                    Create an account
		                </a>
		            </div> -->
		
		        </div>
		
		          <!-- Modal -->
		          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
		              <div class="modal-dialog">
		                  <div class="modal-content">
		                      <div class="modal-header">
		                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		                          <h4 class="modal-title">Forgot Password ?</h4>
		                      </div>
		                      <div class="modal-body">
		                          <p>Enter your e-mail address below to reset your password.</p>
		                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
		
		                      </div>
		                      <div class="modal-footer">
		                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
		                          <button class="btn btn-theme" type="button">Submit</button>
		                      </div>
		                  </div>
		              </div>
		          </div>
		          <!-- modal -->
		
		      </div>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('assets/loginstyle/jquery.js');?>"></script>
    <script src="<?php echo base_url('assets/loginstyle/bootstrap.min.js');?>"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="<?php echo base_url('assets/loginstyle/jquery.backstretch.min.js');?>"></script>
    <script>
		var fullUrl = window.location.origin+window.location.pathname;
		//alert(fullUrl+"/assets/img/login-bg.jpg");				
        $.backstretch(fullUrl+"/assets/img/loginback.jpg", {speed: 500});

function dologin(){
	$('#formmsg').html('').fadeOut();
	var username = $('#username').val();
	var password = $('#password').val();
	
	if (username=='' || password==''){
		$('#formmsg').html('Username dan Password harus diisi.').fadeIn();
	} else {
		
		$.ajax({
			url: "<?php echo base_url('pengguna/dologin'); ?>",
			dataType: 'json',
			type: 'POST',
			data: {username:username,password:password},
			success:   
			function(data){
				console.log(data);				
				if(data.response =="true"){
					//alert('<?php echo base_url('/')."dashboard";?>');
					//window.location='<?php echo base_url('/')."dashboard";?>';
					window.location.replace('<?php echo base_url('/');?>');
				} else {
					$('#formmsg').html('Username atau Password salah').fadeIn();
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown + ' <br> '+username+' <br> '+password);
			},
		});
	}
}
$('input').keydown(function(event) {
		if(event.keyCode == 13) {
		  dologin();
		}
	});
    </script>


  </body>
</html>