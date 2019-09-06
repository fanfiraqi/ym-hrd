<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>NH <?php if (isset($pagetitle)) echo ' - '.$pagetitle;?> </title>
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="keyword" content="">
	<meta name="author" content="">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/stylesheet.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/jquery-ui/css/cupertino/jquery-ui-1.10.4.custom.min.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sb-admin.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.styles.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.bootstrap.css');?>" />

	<style>
	</style>
	
	
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.10.2.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui/js/jquery-ui-1.10.4.custom.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js');?>"></script>
	<!-- js plugin -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
	<!-- .js plugin -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/sb-admin.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/main.scripts.js');?>"></script>
	<script type="text/javascript" src="<?php //echo base_url('assets/js/demo/dashboard-demo.js');?>"></script>
	
	<script type="text/javascript">
	
	</script>
	<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome/css/font-awesome-ie7.min.css');?>" />		
	<![endif]-->
	
	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo base_url('assets/js/html5shiv.js');?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/respond.min.js');?>"></script>
	<![endif]-->
	
	

</head>

<body style="background-color:#fff">

    <div id="wrapper">

        

        <?php echo $contents; ?>

    </div>
    <!-- /#wrapper -->


</body>

</html>
