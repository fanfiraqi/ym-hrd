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
	<link rel="icon" type="image/png" href="<?php echo base_url('assets/css/images/favicon.ico');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/stylesheet.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/jquery-ui/css/cupertino/jquery-ui-1.10.4.custom.min.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/sb-admin.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.styles.css');?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.bootstrap.css');?>" />

	
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.10.2.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-ui/js/jquery-ui-1.10.4.custom.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js');?>"></script>
	<!-- js plugin -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
	<!-- <script type="text/javascript" src="<?php echo base_url('assets/js/plugins/input-mask/jquery.inputmask.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/input-mask/jquery.inputmask.date.extensions.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/input-mask/jquery.inputmask.extensions.js');?>"></script> -->

	<!-- .js plugin -->
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootbox.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/sb-admin.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/main.scripts.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.price_format.js');?>"></script>
	
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
		//ceknotif();
		//setInterval(function(){ceknotif()},20000);
	});
	</script>
	<?php } ?>
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
		
        <?php echo $this->load->view('sidebar');?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
					<?php
					$flashmsg = $this->session->flashdata('flashmsg');
					$flashtype = $this->session->flashdata('flashtype');
					if(!empty($flashmsg)){
						echo '<div class="flashHandler alert alert-'.$flashtype.'">'.$flashmsg.'</div>';
					}
					?>
                    <h2 class="page-header"><?php if (isset($pagetitle)) echo $pagetitle;?></h2>
					
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
			<div class="row">
				<div class="col-lg-12">
                    <?php echo $contents; ?>
                </div>
			</div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


</body>

</html>
