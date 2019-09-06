<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>Yatim Mandiri - HRD <?php if (isset($pagetitle)) echo ' - '.$pagetitle;?></title>
	<meta name="description" content="Yatim Mandiri - Human Resource Information System" />
	<meta name="keywords" content="Yatim Mandiri - Human Resource Information System" />
	<meta name="author" content="hencework"/>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.ico');?>">
	<link rel="icon" href="<?php echo base_url('assets/img/favicon.ico');?>" type="image/x-icon">
	
	<!-- Data table CSS -->
	<link href="<?php echo base_url('assets/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css');?>" rel="stylesheet" type="text/css"/>
	
	<!-- Toast CSS -->
	<link href="<?php echo base_url('assets/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css');?>" rel="stylesheet" type="text/css">
	
	<!-- bootstrap-select CSS -->
	<link href="<?php echo base_url('assets/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css');?>" rel="stylesheet" type="text/css"/>	
	<link href="<?php echo base_url('assets/vendors/bower_components/jquery-ui/themes/base/all.css');?>" rel="stylesheet" type="text/css"/>	
		
	<!-- switchery CSS -->
	<link href="<?php echo base_url('assets/vendors/bower_components/switchery/dist/switchery.min.css');?>" rel="stylesheet" type="text/css"/>
	
	<!-- Custom CSS -->
	<link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet" type="text/css">


	<!-- JavaScript -->
	
    <!-- jQuery -->
    <script src="<?php echo base_url('assets/vendors/bower_components/jquery/dist/jquery.min.js');?>"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js');?>"></script>
    
	
	<!-- Data table JavaScript -->
	<script src="<?php echo base_url('assets/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js');?>"></script>
	

	<!-- Slimscroll JavaScript -->
	<script src="<?php echo base_url('assets/js/jquery.slimscroll.js');?>"></script>

	<!-- Progressbar Animation JavaScript -->
	<script src="<?php echo base_url('assets/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js');?>"></script>
	<script src="<?php echo base_url('assets/vendors/bower_components/jquery.counterup/jquery.counterup.min.js');?>"></script>
	
	<!-- Fancy Dropdown JS -->
	<script src="<?php echo base_url('assets/js/dropdown-bootstrap-extended.js');?>"></script>
	
	<!-- Sparkline JavaScript -->
	<script src="<?php echo base_url('assets/vendors/jquery.sparkline/dist/jquery.sparkline.min.js');?>"></script>
	
	<!-- Owl JavaScript -->
	<script src="<?php echo base_url('assets/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js');?>"></script>
	
	<!-- Switchery JavaScript -->
	<script src="<?php echo base_url('assets/vendors/bower_components/switchery/dist/switchery.min.js');?>"></script>
	
	<!-- Toast JavaScript -->
	<script src="<?php echo base_url('assets/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js');?>"></script>
		
	
	<!-- Bootstrap Select JavaScript -->
	<script src="<?php echo base_url('assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js');?>"></script>
	
	
	



	<script type="text/javascript" src="<?php echo base_url('assets/js/main.scripts.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.price_format.js');?>"></script>
	<script src="<?php echo base_url('assets/vendors/jquery-ui.min.js');?>"></script>
		

	<?php if ($this->auth->is_login()){ ?>
	<script type="text/javascript">
	function ceknotif(){
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url('notif');?>',
			//dataType: 'json',
			success: function(msg) {
				if (msg=='none'){
					$('#notif').removeClass('notif');
					$('#notifitem').remove();
				} else {
					$('#notifitem').remove();
					$('#notif').addClass('notif').after(msg);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger',2000);
			},
			cache: false
		});
	}
	$(document).ready(function(){
		ceknotif();
		setInterval(function(){ceknotif()},60000);
	});
	</script>
	<?php } ?>
</head>

<body>
	<!-- Preloader -->
	<div class="preloader-it">
		<div class="la-anim-1"></div>
	</div>
	<!-- /Preloader -->

    <div class="wrapper theme-2-active pimary-color-blue">
		
		
		 <?php echo $this->load->view('header');?>
		
        <?php echo $this->load->view('sidebar');?>
        
		<!-- Main Content -->
		<div class="page-wrapper">
            <div class="container-fluid pt-10">
			
					<!-- Title -->
					<div class="row heading-bg" >
						<div class="col-lg-6 col-md-6 col-md-8 col-xs-12">
							<h5 class="txt-dark"><?php if (isset($pagetitle)) echo $pagetitle;?></h5>
						</div>
					
						<!-- Breadcrumb -->
						<div class="col-lg-6 col-sm-6 col-sm-4 col-xs-12" >
							<ol class="breadcrumb">
								
								<?php if (isset($breadcrumbs)) 
											echo $breadcrumbs; 
										else 
											echo "&nbsp;";
								?>	
							</ol>
						</div>
						<!-- /Breadcrumb -->
					
					</div>
					<!-- /Title -->
				
					<!-- ================================ -->
					<?php echo $contents; ?>
			</div>
			
			<!-- Footer -->
			<footer class="footer container-fluid pl-30 pr-30">
				<div class="row">
					<div class="col-sm-12">
						<p>2018 - <?php echo date('Y')?>&copy; YatimMandiri.Org</p>
					</div>
				</div>
			</footer>
			<!-- /Footer -->
			
		</div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->
	
		<!-- Init JavaScript -->
	<script src="<?php echo base_url('assets/js/dashboard2-data.js');?>"></script>	
	<script src="<?php echo base_url('assets/js/init.js');?>"></script>
</body>

</html>
