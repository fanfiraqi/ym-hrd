<? $setMenu=$this->config->item('mymenu');
$role=$this->session->userdata('auth')->ROLE;?>
<nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav" id="side-menu">
			
			<li>
				<?php echo anchor('','<i class="fa fa-home"></i> Beranda');?>
			</li>
			<?php if ($role=="Admin"|| $role=="Manager HRD"){?>
			<li <?=($setMenu=="menuSatu"?"class='active'":"")?>>
				<a href="#"><i class="fa fa-gears fa-fw"></i> Pengaturan<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li ><?php echo anchor('setting/parameter','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Parameter');?></li>					
					<li ><?php echo anchor('pengguna/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pengguna');?></li>
					<li><?php echo anchor('cabang/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cabang');?></li>
					<li><?php echo anchor('divisi/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Divisi');?></li>
					<li><?php echo anchor('jabatan/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jabatan');?></li>
					<li><?php echo anchor('struktur/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Struktur Organisasi');?></li>
					<li><?php echo anchor('libur/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hari Libur');?></li>
					<li><?php echo anchor('jenisijin/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jenis Cuti/Ijin');?></li>
				
				</ul>
				<!-- /.nav-second-level -->
			</li><? } ?>
			<?php if ($role=="Admin" || $role=="Manager HRD" || $role=="Direktur HRD" || $role=="Operator HRD"){?>
			<li <?=($setMenu=="menuDuaSatu" || $setMenu=="menuDuaDua"?"class='active'":"")?>>
				<a href="#"><i class="fa fa-sitemap fa-fw"></i> Pegawai<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
				
					<li <?=($setMenu=="menuDuaSatu"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Personal File <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li <?=($setMenu=="menuDuaSatu"?"class='active'":"")?>><?php echo anchor('employee/index','Kelola Pegawai');?></li>
							<li <?=($setMenu=="menuDuaSatu"?"class='active'":"")?>><?php echo anchor('cuti/index','Permohonan Cuti/Ijin');?></li>	
							<li <?=($setMenu=="menuDuaSatu"?"class='active'":"")?>><?php echo anchor('lembur/index','Permohonan Lembur');?></li>	
							<li <?=($setMenu=="menuDuaSatu"?"class='active'":"")?>><?php echo anchor('prestasi/index','Data Prestasi');?></li>
							<li <?=($setMenu=="menuDuaSatu"?"class='active'":"")?>><?php echo anchor('pelatihan/index','Data Pelatihan');?></li>
							<li <?=($setMenu=="menuDuaSatu"?"class='active'":"")?>><?php echo anchor('pelanggaran/index','Pelanggaran');?></li>
							<li <?=($setMenu=="menuDuaSatu"?"class='active'":"")?>><?php echo anchor('mutasi/index','Mutasi');?></li>
							<li <?=($setMenu=="menuDuaSatu"?"class='active'":"")?>><?php echo anchor('resign/index','Resign/Berhenti');?></li>
						</ul>
					</li>
					
					<?php if ($role=="Admin" || $role=="Manager HRD" || $role=="Direktur HRD" ){?>
					<li <?=($setMenu=="menuDuaDua"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Manajer Operation <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<li <?=($setMenu=="menuDuaDua"?"class='active'":"")?>><?php echo anchor('cuti/approval','Cuti/Ijin Approval');?></li>
							<li <?=($setMenu=="menuDuaDua"?"class='active'":"")?>><?php echo anchor('lembur/approval','Lembur Approval');?></li>							
						</ul>
					</li>
					<?}?>
				</ul>
			</li>
			<?}?>

			<?php if ($role=="Admin" || $role=="Manager HRD" || $role=="Direktur HRD" ){?>
			<li  <?=($setMenu=="menuTiga"?"class='active'":"")?>>
				<a href="#"><i class="fa fa-edit fa-fw"></i> Presensi Kehadiran<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><?php echo anchor('absensi/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Upload Absensi');?></li>
					<li><?php echo anchor('absensi/rekapAbsen','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rekap Absen');?></li>	
				</ul>
			</li>
			<?}?>

			<?php if ($role=="Manager HRD"){?>
				<li <?=($setMenu=="menuEmpatSatu"?"class='active'":"")?>><?php echo anchor('payroll_staff/daily_report','<i class="fa fa-edit fa-fw"></i>&nbsp;Entri Penilaian ISO');?></li>
				<li <?=($setMenu=="menuEmpatSatu"?"class='active'":"")?>><?php echo anchor('payroll_staff/entri_ubudiah','<i class="fa fa-edit fa-fw"></i>&nbsp;Entri Penilaian Ubudiah Staff');?></li>
				<li <?=($setMenu=="menuEmpatDua"?"class='active'":"")?>><?php echo anchor('ubudiah_fo/index','<i class="fa fa-edit fa-fw"></i>&nbsp;Entri Penilaian Ubudiah FO');?></li>
				<li <?=($setMenu=="menuEmpatTiga"?"class='active'":"")?>><?php echo anchor('ubudiah_fr/index','<i class="fa fa-edit fa-fw"></i>&nbsp;Entri Penilaian Ubudiah FR');?></li>
			<?}?>


			<?php if ( $role=="Admin" || $role=="Direktur Keuangan" || $role=="Manager Keuangan" || $role=="Operator ZIS"){?>
			<li <?=($setMenu=="menuEmpatSatu" || $setMenu=="menuEmpatDua" || $setMenu=="menuEmpatTiga" || $setMenu=="menuEmpatEmpat"?"class='active'":"" || $setMenu=="menuEmpatLima"?"class='active'":"")?>>
				<a href="index.html"><i class="fa fa-money"></i> Payroll<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<?php if ( $role=="Admin" || $role=="Direktur Keuangan" || $role=="Manager Keuangan" ){?>
					<li <?=($setMenu=="menuEmpatEmpat"?"class='active'":"")?>><?php echo anchor('tunjangan_anak/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Master Tunjangan Anak');?></li>	
					<?}?>
					<?php if ( $role=="Admin" || $role=="Direktur Keuangan" || $role=="Manager Keuangan" ){?>
					<li <?=($setMenu=="menuEmpatSatu"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Staff Payroll<span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">							
							<li <?=($setMenu=="menuEmpatSatu"?"class='active'":"")?>><?php echo anchor('komponengaji/index','Master Jenis Gaji Staff');?></li>
							<li <?=($setMenu=="menuEmpatSatu"?"class='active'":"")?>><?php echo anchor('payroll_staff/set_gaji','Set Master Nominal Gaji/Tunj');?></li>
							<?php if ( $role!="Direktur Keuangan" ){?>
							<li <?=($setMenu=="menuEmpatSatu"?"class='active'":"")?>><?php echo anchor('payroll_staff/daily_report','Entri Penilaian ISO');?></li>
							<li <?=($setMenu=="menuEmpatSatu"?"class='active'":"")?>><?php echo anchor('payroll_staff/entri_ubudiah','Entri Penilaian Ubudiah Staff');?></li>
							<?}?>
							<li <?=($setMenu=="menuEmpatSatu"?"class='active'":"")?>><?php echo anchor('payroll_staff/payroll_filter','Penggajian Staff');?></li>	
						</ul>
					</li>
					<?}?>
					<li <?=($setMenu=="menuEmpatDua"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FO Payroll<span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
							<?php if ( $role=="Admin" || $role=="Direktur Keuangan" || $role=="Manager Keuangan" ){?>
							<li <?=($setMenu=="menuEmpatDua"?"class='active'":"")?>><?php echo anchor('mastergaji_fo/index','Master Gaji/Tunjangan FO');?></li>
							<?}?>
							<?php if ( $role=="Admin" || $role=="Operator ZIS" || $role=="Manager Keuangan" ){?>
							<li <?=($setMenu=="menuEmpatDua"?"class='active'":"")?>><?php echo anchor('perolehan_fo/index','Input Perolehan & Kunjungan');?></li>
							<?}?>
							<?php if ( $role!="Direktur Keuangan" & $role!="Operator ZIS"){?>
							<li <?=($setMenu=="menuEmpatDua"?"class='active'":"")?>><?php echo anchor('ubudiah_fo/index','Entri Penilaian Ubudiah FO');?></li>
							<?}?>
							<?php if ( $role=="Admin" || $role=="Operator ZIS"){?>
							<li <?=($setMenu=="menuEmpatDua"?"class='active'":"")?>><?php echo anchor('evaluasi_fo/index','Evaluasi Level FO');?></li>
							<?}?>
							<?php if ( $role=="Admin"){?>
							<li <?=($setMenu=="menuEmpatDua"?"class='active'":"")?>><?php echo anchor('penggajian_fo/index','Penggajian FO');?></li>			
							<?}?>
						</ul>
					</li>
					
					<li <?=($setMenu=="menuEmpatTiga"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FR Payroll<span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">				
							<?php if ( $role=="Admin" || $role=="Direktur Keuangan" || $role=="Manager Keuangan" ){?>
							<li <?=($setMenu=="menuEmpatTiga"?"class='active'":"")?>><?php echo anchor('mastergaji_fr/index','Master Gaji/Tunjangan FR');?></li>
							<?}?>
							<?php if ($role=="Admin" ||  $role=="Operator ZIS" || $role=="Manager Keuangan" || $role=="Manager Keuangan"){?>
							<li <?=($setMenu=="menuEmpatTiga"?"class='active'":"")?>><?php echo anchor('perolehan_fr/index','Input Target & Perolehan FR');?></li>
							<?}?>
							<?php if ($role!="Direktur Keuangan" & $role!="Operator ZIS"){?>
							<li <?=($setMenu=="menuEmpatTiga"?"class='active'":"")?>><?php echo anchor('ubudiah_fr/index','Entri Penilaian Ubudiah FR');?></li>
							<?}?>
							<?php if ( $role=="Admin" || $role=="Direktur Keuangan" || $role=="Manager Keuangan" ){?>
							<li <?=($setMenu=="menuEmpatTiga"?"class='active'":"")?>><?php echo anchor('penggajian_fr/index','Penggajian FR');?></li>
							<?}?>
						</ul>
					</li>
					<?php if ( $role=="Admin" || $role=="Direktur Keuangan"  || $role=="Manager Keuangan" ){?>
					<li <?=($setMenu=="menuEmpatLima"?"class='active'":"")?>><?php echo anchor('emailPage/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kirim Email');?></li>
					<?}?>
				
				</ul>
			</li>
			<?}?>

			
			

			<?php if ( $role=="Admin" || $role=="Direktur Keuangan" || $role=="Manager Keuangan" ){?>
			<li <?=($setMenu=="menuTujuhSatu" || $setMenu=="menuTujuhDua" || $setMenu=="menTujuhTiga" || $setMenu=="menuEmpatEmpat"?"class='active'":"" || $setMenu=="menuEmpatLima"?"class='active'":"")?>>
				<a href="index.html"><i class="fa fa-money"></i> THR<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					
					<li <?=($setMenu=="menuTujuhSatu"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;THR Staff <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">							
							<li <?=($setMenu=="menuTujuhSatu"?"class='active'":"")?>><?php echo anchor('thr_staff/index','Master THR Staff');?></li>
							<li <?=($setMenu=="menuTujuhSatu"?"class='active'":"")?>><?php echo anchor('thr_staff/form','Form THR Staff');?></li>							
						</ul>
					</li>

					
					<li <?=($setMenu=="menuTujuhDua"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;THR FO <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">							
							<li <?=($setMenu=="menuTujuhDua"?"class='active'":"")?>><?php echo anchor('thr_FO/index','Master THR FO');?></li>
							<li <?=($setMenu=="menuTujuhDua"?"class='active'":"")?>><?php echo anchor('thr_FO/form','Form THR FO');?></li>							
						</ul>
					</li>


					
					<li <?=($setMenu=="menTujuhTiga"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;THR FR <span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">							
							<li <?=($setMenu=="menTujuhTiga"?"class='active'":"")?>><?php echo anchor('thr_FR/index','Master THR FR');?></li>
							<li <?=($setMenu=="menTujuhTiga"?"class='active'":"")?>><?php echo anchor('thr_FR/form','Form THR FR');?></li>							
						</ul>
					</li>
					<li <?=($setMenu=="menTujuhEmpat"?"class='active'":"")?>><?php echo anchor('emailPageTHR/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kirim Email THR');?></li>
				</ul>
			</li>
			<?	} ?>


			<?php if ( $role=="Admin" || $role=="Direktur Keuangan"  || $role=="Manager Keuangan" ){?>
			<li <?=($setMenu=="menuLima"?"class='active'":"")?>>
				<a href="index.html"><i class="fa fa-star"></i> Pinjaman<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
					<li><?php echo anchor('pinjaman/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pinjaman');?></li>
					<li><?php echo anchor('angsuran/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pembayaran Angsuran');?></li>
				</ul>
			</li>
			<?}?>


			<?php if ( $role=="Admin" || $role=="Direktur Keuangan"  || $role=="Manager Keuangan" || $role=="Manager HRD" || $role=="Direktur HRD" || $role=="Operator HRD"){?>
			<li <?=($setMenu=="menuEnamSatu" || $setMenu=="menuEnamDua"?"class='active'":"")?>>
				<a href="index.html"><i class="fa fa-print"></i> Reporting<span class="fa arrow"></span></a>
				<ul class="nav nav-second-level">
				<?php if ($role=="Admin" || $role=="Manager HRD" || $role=="Direktur HRD" || $role=="Operator HRD"){?>
					<li <?=($setMenu=="menuEnamSatu"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HRD<span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
						<li <?=($setMenu=="menuEnamSatu"?"class='active'":"")?>><?php echo anchor('hrdReportPersonal/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Personal Data');?></li>
						<li <?=($setMenu=="menuEnamSatu"?"class='active'":"")?>><?php echo anchor('hrdReportRekapHRD/rekapFilter','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rekap HRD Bulanan');?></li>
						<li <?=($setMenu=="menuEnamSatu"?"class='active'":"")?>><?php echo anchor('hrdReportAbsensi/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rekap Absensi Staff');?></li>
						</ul>
					</li>
					<?}?>
					<?php if ( $role=="Admin" || $role=="Direktur Keuangan"  || $role=="Manager Keuangan"){?>
					<li <?=($setMenu=="menuEnamDua"?"class='active'":"")?>><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;KEUANGAN<span class="fa arrow"></span></a>
						<ul class="nav nav-third-level">
						<li <?=($setMenu=="menuEnamDua"?"class='active'":"")?>><?php echo anchor('keuReportLoan/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Data Pinjaman');?></li>
						<!-- <li <?=($setMenu=="menuEnamDua"?"class='active'":"")?>><?php echo anchor('keuReportPerolehan/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rekap Perolehan FO-FR');?></li> -->
						<?php if ( $role!="Operator ZIS"){?>
						<li <?=($setMenu=="menuEnamDua"?"class='active'":"")?>><?php echo anchor('keuReportPayroll/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rekap Gaji');?></li>
						<li <?=($setMenu=="menuEnamDua"?"class='active'":"")?>><?php echo anchor('keuReportTHR/index','&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rekap THR');?></li>
						<?}?>
						</ul>
					</li>
					<?}?>
				</ul>

			</li>
			<?}?>
			
		</ul>
		<!-- /#side-menu -->
	</div>
	<!-- /.sidebar-collapse -->
</nav>
<!-- /.navbar-static-side -->