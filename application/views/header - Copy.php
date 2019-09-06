<nav class="navbar navbar-metro navbar-static-top" role="navigation" id="mynavbar">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="#"><?php echo $this->session->userdata('param_company')." - HUMAN RESOURCE & PAYROLL SYSTEM";?></a>
	</div>
	<!-- /.navbar-header -->
<?php if ($this->auth->is_login()) { ?>
	<ul class="nav navbar-top-links navbar-right">		
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="notif">
				<i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
			</a>
			
			<!-- /.dropdown-alerts -->
		</li>
		<!-- /.dropdown -->
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="<?php echo base_url('pengguna/edit/'.$this->session->userdata('auth')->ID);?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
				</li>
				<?php if ( $this->session->userdata('auth')->ROLE=="Admin"){?>
				<li><a href="<?php echo base_url('setting/parameter');?>"><i class="fa fa-gear fa-fw"></i> Settings</a>
				</li>
				<? }?>
				<li class="divider"></li>
				<li><a href="<?php echo base_url('logout');?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
				</li>
			</ul>
			<!-- /.dropdown-user -->
		</li>
		<!-- /.dropdown -->
	</ul>
	<div class="navbar-text pull-right">
		<?php echo anchor('pengguna/edit/'.$this->session->userdata('auth')->ID,$this->session->userdata('auth')->NAMA);?>
	</div>
	<!-- /.navbar-top-links -->
<?php } ?>
</nav>
<!-- /.navbar-static-top -->