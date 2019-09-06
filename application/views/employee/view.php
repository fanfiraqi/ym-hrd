
<ul class="nav nav-tabs" id="myTab">
  <li><a href="#info" data-toggle="tab">Informasi Utama</a></li>
  <li><a href="#pendidikan" data-toggle="tab">Pendidikan</a></li>
  <li><a href="#kerja" data-toggle="tab">Pengalaman Kerja</a></li>
  <li><a href="#organisasi" data-toggle="tab">Pengalaman Organisasi</a></li>
  <li><a href="#pelatihan" data-toggle="tab">Pelatihan</a></li>
  <li><a href="#prestasi" data-toggle="tab">Prestasi</a></li>
  <li><a href="#pelanggaran" data-toggle="tab">pelanggaran</a></li>
  <li><a href="#kontrak" data-toggle="tab">Mutasi &amp; Kontrak</a></li>
</ul>

<?php echo form_hidden('id',$row->ID);?>

<div class="tab-content" style="padding : 10px;" >
  <div class="tab-pane fade active in" role="tabpanel" id="info">



<div class="panel panel-default "  >
        <div class="panel-heading">
			<div class="pull-left"><h6 class="panel-title txt-dark">Data Personal</h6></div>
			<div class="clearfix"></div>
		</div>
	<div class="panel-wrapper collapse in">
	<div  class="panel-body row pa-15" >

<div class="row">
<div class="col-md-6">
		<div class="form-group">
			<label for="nik" class="col-sm-4 control-label">NIK</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->NIK;
				?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="nama" class="col-sm-4 control-label">Nama Lengkap</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->NAMA;
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="nama" class="col-sm-4 control-label">Nama Panggilan</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->NAMA_PANGGILAN;
				?>
			</div>
		</div>
	</div>
</div>

<div class="row">	
	<div class="col-md-6">
		<div class="form-group">
			<label for="kotalahir" class="col-sm-4 control-label">Tempat Lahir</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->TEMPAT_LAHIR;
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="tgllahir" class="col-sm-4 control-label">Tanggal Lahir</label>
			<div class="col-sm-8"> :			
				<?php
					echo revdate($row->TGL_LAHIR);
				?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="kotalahir" class="col-sm-4 control-label">No. KTP</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->NO_KTP;
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">Jenis Kelamin</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->NAMA_SEX;
				?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="alamat" class="col-sm-4 control-label">Alamat KTP</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->ALAMATKTP;
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="alamat" class="col-sm-4 control-label">Alamat Domisili</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->ALAMAT;
				?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="telepon" class="col-sm-4 control-label">No. Telepon / HP</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->TELEPON;
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="email" class="col-sm-4 control-label">Email</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->EMAIL;
				?>
			</div>
		</div>
	</div>

				<div class="col-md-6">
					<div class="form-group">
						<label for="nikah" class="col-sm-4 control-label">Pendidikan Terakhir</label>
						<div class="col-sm-8"> :
							<?php
								echo $row->PENDIDIKAN;
							?>
						</div>
					</div>
				</div>	
			
</div>

</div><!-- panel body -->
</div><!-- panel wrapper -->

<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark">Data Keluarga</h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div  class="panel-body row pa-15" ><br>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="nikah" class="col-sm-4 control-label">Status Pernikahan</label>
			<div class="col-sm-8"> : 
				<?php
					echo $arrStsNikah[$row->STATUS_NIKAH];
				?>
			</div>
		</div>
	</div>
	<?php if ($row->STATUS_NIKAH<>"BN"){?>
	<div class="col-md-6">
		<div class="form-group">
			<label for="nikah" class="col-sm-4 control-label">Jumlah Anak</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->JUMLAH_ANAK;
				?>
			</div>
		</div>
	</div>
	<?php }?>
</div>
<?php if ($row->STATUS_NIKAH<>"BN"){?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="nikah" class="col-sm-4 control-label">Nama Kontak Keluarga</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->NAMA_KONTAK_KELUARGA;
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="nikah" class="col-sm-4 control-label">Nomer Telp Keluarga</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->TELP_KELUARGA;
				?>
			</div>
		</div>
	</div>
</div>
<?php }?>
</div><!-- panel body -->
</div><!-- panel wrapper -->

<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark">Data HRD</h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div  class="panel-body row pa-15"><br>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="rekening" class="col-sm-4 control-label">No. Rekening</label>
			<div class="col-sm-8"> : 
				<?php
					echo $row->REKENING;
				?>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Cabang</label>
			<div class="col-sm-8"> : 
				<?php
					echo $rsmaster->NAMA_CABANG;
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="divisi" class="col-sm-4 control-label">Divisi</label>
			<div class="col-sm-8"> : 
				<?php echo $rsmaster->NAMA_DIV; ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="jabatan" class="col-sm-4 control-label">Jabatan</label>
			<div class="col-sm-8"> : 
				<?php echo $rsmaster->NAMA_JAB; ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="stspegawai" class="col-sm-4 control-label">Status Karyawan</label>
			<div class="col-sm-8"> : 
				<?php echo $row->STS_PEGAWAI; ?>
			</div>
		</div>
	</div>
</div>
<div class="row" id="rowtetap">
	<div class="col-md-6">
		<div class="form-group">
			<label for="tglaktif" class="col-sm-4 control-label">Tanggal Aktif Kerja</label>
			<div class="col-sm-8"> : 
				<?php
					echo revdate($row->TGL_AKTIF);
				?>
			</div>
		</div>
	</div>
</div>
</div><!-- panel body -->
</div><!-- panel wrap -->
</div><!-- panel default -->




<div class="row">
	<div class="col-md-6">		
			<?php echo anchor('employee/edit/'.$row->ID,'Edit Data',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> 
			<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Kembali',
					'onclick'=>"backTo('".base_url('employee/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
			<!-- <?php echo anchor('employee/cetak_datapeg/'.$row->ID,'Cetak Data Pegawai',array('id'=>'btsubmit','class'=>'btn btn-primary'));?>  -->
	</div>
</div>

	</div>
	
	
	
		
	<div class="tab-pane" id="pendidikan"><?php $this->load->view('employee/adm_pendidikan'); ?></div>
	<div class="tab-pane" id="kerja"><?php $this->load->view('employee/adm_kerja'); ?></div>
	<div class="tab-pane" id="organisasi"><?php $this->load->view('employee/adm_organisasi'); ?></div>
	<div class="tab-pane" id="pelatihan"><?php $this->load->view('employee/adm_pelatihan'); ?></div>
	<div class="tab-pane" id="prestasi"><?php $this->load->view('employee/adm_prestasi'); ?></div>
	<div class="tab-pane" id="pelanggaran"><?php $this->load->view('employee/adm_pelanggaran'); ?></div>
	<div class="tab-pane" id="kontrak"><?php $this->load->view('employee/adm_kontrak'); ?></div>
</div>

<script>

$(document).ready(function(){	
	$('#myTab a:first').tab('show');

	 $('#dataKerja').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 10,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "NO" },
				{"mData": "KETERANGAN" }
			],
			"sAjaxSource": "<?php echo base_url('employee/json_view_emp/kerja_'.$row->NIK);?>"
		});

	 $('#dataOrganisasi').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 10,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "NO" },
				{"mData": "KETERANGAN" }
			],
			"sAjaxSource": "<?php echo base_url('employee/json_view_emp/organisasi_'.$row->NIK);?>"
		});

	 $('#dataPelanggaran').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 50,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "NO" },
				{"mData": "NAMA_PELANGGARAN" },
				{"mData": "TANGGAL" },
				{"mData": "KETERANGAN" }
			],
			"sAjaxSource": "<?php echo base_url('employee/json_view_emp/pelanggaran_'.$row->NIK);?>"
		});

		$('#dataPelatihan').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 10,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "NO" },
				{"mData": "NAMA_PELATIHAN" },
				{"mData": "TANGGAL" },
				{"mData": "KETERANGAN" }
			],
			"sAjaxSource": "<?php echo base_url('employee/json_view_emp/pelatihan_'.$row->NIK);?>"
		});

		 $('#dataPrestasi').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 10,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "NO" },
				{"mData": "NAMA_PENILAIAN" },
				{"mData": "DETIL_DOKUMEN" },
				{"mData": "DETIL_EVALUASI" },
				{"mData": "INFO_VALIDASI" },
				{"mData": "TANGGAPAN" }
			],
			"sAjaxSource": "<?php echo base_url('employee/json_view_emp/prestasi_'.$row->NIK);?>"
		});

		 $('#dataPendidikan').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 10,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "NO" },
				{"mData": "FORMAL" },
				{"mData": "INFORMAL" }
			],
			"sAjaxSource": "<?php echo base_url('employee/json_view_emp/pendidikan_'.$row->NIK);?>"
		});

		 $('#dataKontrak').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 10,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "TGLTETAP" },
				{"mData": "JENIS" },
				{"mData": "CABANG" },
				{"mData": "DIVISI" },
				{"mData": "JABATAN" },
				{"mData": "TGLAWAL" },
				{"mData": "TGLAKHIR" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('employee/json_kontrak/'.$row->NIK);?>"
		});
});

</script>