<?php
$setMenu=$this->config->item('mymenu');
$mySubMenu=$this->config->item('mySubMenu');
$role=$this->config->item('myrole');
//$sess=$this->session->userdata('gate');
//$role=$sess['group_id'];
//$this->config->set_item('myrole', $role);
/*
1	superadmin		
3	administrator_hrd	
11	direktur_divisi		
12	direktur_laz		
13	direktur_lpp		
20	gm_ro	General		
26	kepala_cabang		
33	manager_ro		
35	pejabat_sementara_kacab	
39	sekretaris		
42	spv_kesekretariatan	
56	staff_general_affair	
57	staff_it		
60	staff_personalia	
61	staff_r_&_d		
62	staff_umum		
66	manager_hrd_payroll

*/
?>
<!-- Left Sidebar Menu -->
		<div class="fixed-sidebar-left">
			<ul class="nav navbar-nav side-nav nicescroll-bar">
			<li><hr class="light-grey-hr mb-10"/></li>
			<li class="navigation-header">
				<?php echo anchor("",'<div class="pull-left"><i class="fa fa-home mr-20"></i><span class="right-nav-text">Beranda</span></div>');?>
			</li>
			<li><hr class="light-grey-hr mb-10"/></li>
			<?php if (in_array($role, [1,3, 66])){?>
			<li <?php echo ($setMenu=="mn1"?'class="open"':"")?> >
				<a  href="javascript:void(0);" data-toggle="collapse"  data-target="#pengaturan_dr" ><div class="pull-left"><i class="fa fa-gear mr-20"></i><span class="right-nav-text">Pengaturan</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>

				<ul id="pengaturan_dr" class="collapse collapse-level-1">
					<li ><?php echo anchor('cabang/index','Cabang', ($mySubMenu=="mn11"?"class='active-page'":""));?></li>
					<li><?php echo anchor('divisi/index','Divisi', ($mySubMenu=="mn12"?"class='active-page'":""));?></li>
					<li><?php echo anchor('jabatan/index','Jabatan', ($mySubMenu=="mn13"?"class='active-page'":""));?></li>
					<li><?php echo anchor('struktur/index','Struktur Organisasi', ($mySubMenu=="mn14"?"class='active-page'":""));?></li>
					<li><?php echo anchor('libur/index','Hari Libur', ($mySubMenu=="mn15"?"class='active-page'":""));?></li>
					<li><?php echo anchor('jenisijin/index','Jenis Cuti/Ijin', ($mySubMenu=="mn16"?"class='active-page'":""));?></li>
				
				</ul>
			<li><hr class="light-grey-hr mb-10"/></li>
			
			<? } ?>
			<?php if (in_array($role, [1,3, 26, 60, 66])){?>
			<li <?php echo ($setMenu=="mn2"?' class="open" ':"")?>>
				<a  href="javascript:void(0);" data-toggle="collapse" data-target="#pegawai_dr"><div class="pull-left"><i class="fa fa-sitemap fa-fw mr-20"></i><span class="right-nav-text">Karyawan</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
		
				<ul id="pegawai_dr" class="collapse collapse-level-1">					
							<li ><?php echo anchor('employee/index','Data Pegawai', ($mySubMenu=="mn21"?"class='active-page'":""));?></li>
							<li ><?php echo anchor('employee_data/pendidikan','Data Pendidikan', ($mySubMenu=="mn291"?"class='active-page'":""));?></li>
							<li ><?php echo anchor('employee_data/organisasi','Pengalaman Organisasi', ($mySubMenu=="mn292"?"class='active-page'":""));?></li>
							<li ><?php echo anchor('employee_data/pengalaman_kerja','Pengalaman Kerja', ($mySubMenu=="mn293"?"class='active-page'":""));?></li>
							<li ><?php echo anchor('pelatihan/index','Data Pelatihan', ($mySubMenu=="mn25"?"class='active-page'":""));?></li>
							<li ><?php echo anchor('prestasi/index','Data Prestasi', ($mySubMenu=="mn24"?"class='active-page'":""));?></li>							
							<li ><?php echo anchor('pelanggaran/index','Pelanggaran', ($mySubMenu=="mn26"?"class='active-page'":""));?></li>
							<li ><?php echo anchor('cuti/index','Permohonan Cuti/Ijin', ($mySubMenu=="mn22"?"class='active-page'":""));?></li>	
							<li ><?php echo anchor('lembur/index','Permohonan Lembur', ($mySubMenu=="mn23"?"class='active-page'":""));?></li>	
							<li ><?php echo anchor('mutasi/index','Riwayat/Mutasi', ($mySubMenu=="mn27"?"class='active-page'":""));?></li>
							<li ><?php echo anchor('resign/index','Resign/Berhenti', ($mySubMenu=="mn28"?"class='active-page'":""));?></li>
				</ul>		
					
			</li>	
			
			<?}?>	
			
			<?php if (in_array($role, [1,3, 26, 60, 66])){?>
			<li><hr class="light-grey-hr mb-10"/></li>
			<li <?php echo ($setMenu=="mn3"?' class="open" ':"")?>>
					<a href="javascript:void(0);" data-toggle="collapse" data-target="#manajer_dr"><div class="pull-left"><i class="fa fa-check-square-o mr-20"></i><span class="right-nav-text">Manajer Operation</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>					

						<ul id="manajer_dr" class="collapse collapse-level-1">
							<li><?php echo anchor('cuti/approval','Cuti/Ijin Approval', ($mySubMenu=="mn31"?"class='active-page'":""));?></li>
							<li ><?php echo anchor('lembur/approval','Lembur Approval', ($mySubMenu=="mn32"?"class='active-page'":""));?></li>							
							<li ><?php echo anchor('resign/approval','Resign Approval', ($mySubMenu=="mn33"?"class='active-page'":""));?></li>							
						</ul>
			</li>
			<?}?>
			
			<li><hr class="light-grey-hr mb-10"/></li>
			<?php if (in_array($role, [1,3, 26, 60, 66])){?>
			<li  <?=($setMenu=="mn4"?" class='open' ":"")?>>
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#presensi_dr"><div class="pull-left"><i class="fa fa-edit fa-fw mr-20"></i><span class="right-nav-text">Presensi Kehadiran</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
				
				<ul id="presensi_dr" class="collapse collapse-level-1">
					<li><?php echo anchor('absensi/index','Upload Absensi', ($mySubMenu=="mn41"?"class='active-page'":""));?></li>
					<li><?php echo anchor('absensi/rekapAbsen','Rekap Absen Staf', ($mySubMenu=="mn42"?"class='active-page'":""));?></li>	
					<li><?php echo anchor('absensi/rekapAbsenzisco','Rekap Absen zisco', ($mySubMenu=="mn43"?"class='active-page'":""));?></li>	
				</ul>
			</li>
			<?}?>
			
			
			<?php if (in_array($role, [1,3, 20,26,33])){?>
			<li><hr class="light-grey-hr mb-10"/></li>
			<li <?=($setMenu=="mn5"?" class='open' ":"")?>>
				
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#pinjaman_dr"><div class="pull-left"><i class="fa fa-usd mr-20"></i><span class="right-nav-text">Pinjaman</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
		
				<ul id="pinjaman_dr" class="collapse collapse-level-1">
					<li><?php echo anchor('pinjaman/index',' Pinjaman', ($mySubMenu=="mn51"?"class='active-page'":""));?></li>
					<li><?php echo anchor('angsuran/index','Pembayaran Angsuran', ($mySubMenu=="mn52"?"class='active-page'":""));?></li>
				</ul>
			</li>
			<?}?>

			<?php if (in_array($role, [1,3, 26, 60, 11,12,13,20, 66])){?>
			<li><hr class="light-grey-hr mb-10"/></li>
			<li <?=($setMenu=="mn6"?"class='open'":"")?>>
				
				<a href="javascript:void(0);" data-toggle="collapse" data-target="#reporting_dr"><div class="pull-left"><i class="fa fa-print mr-20"></i><span class="right-nav-text">Reporting</span></div><div class="pull-right"><i class="zmdi zmdi-caret-down"></i></div><div class="clearfix"></div></a>
		
				<ul id="reporting_dr" class="collapse collapse-level-1">
					<li ><?php echo anchor('keuReportLoan/index','Data Pinjaman',($mySubMenu=="mn65"?"class='active-page'":""));?></li>
						<li ><?php echo anchor('hrdReportPersonal/index','Personal Data', ($mySubMenu=="mn61"?"class='active-page'":""));?></li>
						<li ><?php echo anchor('hrdReportRekapHRD/rekapFilter','Rekap HRD Bulanan', ($mySubMenu=="mn62"?"class='active-page'":""));?></li>
						<li ><?php echo anchor('hrdReportAbsensi/index','Rekap Absensi Staff', ($mySubMenu=="mn63"?"class='active-page'":""));?></li>						
						<li ><?php echo anchor('hrdReportAbsensi/zisco','Rekap Absen Zisco', ($mySubMenu=="mn64"?"class='active-page'":""));?></li>						
				</ul>
			</li>
			<li><hr class="light-grey-hr mb-10"/></li>
			<?}?>
			</ul>
			<div  style="position:fixed; top:95%;z-index:1080;margin-left:20px;"><label  style="text-align:center; font-size:x-small;"><b>Best Running with Firefox @2018</b></label></div> 
		</div>
		<!-- /Left Sidebar Menu -->