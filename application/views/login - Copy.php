<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>NH</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keyword" content="">
	<meta name="author" content="">
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/css/images/favicon.ico');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/stylesheet.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sb-admin.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.styles.css');?>" />
	
	
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.10.2.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
	
	
	<!-- .js plugin -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>
	
	<script type="text/javascript" src="<?php echo base_url('assets/js/main.scripts.js');?>"></script>
	
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome/css/font-awesome-ie7.min.css');?>" />		
	<![endif]-->
	
	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo base_url('assets/js/html5shiv.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/respond.min.js');?>"></script>
	<![endif]-->
	
	

</head>

<body>

    <div id="wrapper">

        

        <?php echo $this->load->view('header');?>
		
         <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Silakan Login</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" id="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <a href="javascript:void(0)" onclick="dologin()" class="btn btn-lg btn-success btn-block">Login</a>
                            </fieldset>
							<br />
							<div id="formmsg" class="no-display alert alert-danger"></div>
                        </form>
						
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- /#wrapper -->

<script>
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
				if(data.response =="true"){
					window.location.replace('<?php echo base_url('/');?>');
				} else {
					$('#formmsg').html('Username atau Password salah').fadeIn();
				}
			}
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
