
<ul class="nav nav-tabs" id="myTab">
  <li><a href="#info" data-toggle="tab">Informasi Utama</a></li>
</ul>




<div class="tab-content"  style="padding : 10px;">
  <div class="tab-pane" id="info">
<?php echo form_open('employee/edit',array('class'=>'form-horizontal','id'=>'myform'));?>
<?php echo form_hidden('id',$row->ID);?>

<div class="panel panel-default card-view" >
        <div class="panel-heading">
			<div class="pull-left"><h6 class="panel-title txt-dark">Data Personal</h6></div>
			<div class="clearfix"></div>
		</div>
	<div class="panel-wrapper collapse in">
	<div  class="panel-body row pa-0">
		<br>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Nama Lengkap</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control', 'value'=>$row->NAMA));?></div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Nama Panggilan</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'nama_panggilan','id'=>'nama_panggilan','class'=>'form-control','value'=>$row->NAMA_PANGGILAN));?></div>
				</div>
			</div>
		</div>

		<div class="row" >
			<div class="col-md-6">
				<div class="form-group">
					<label for="tglaktif" class="col-sm-4 control-label">Tanggal Masuk*</label>
					<div class="col-sm-8">
						<div class="input-group">
							<?=form_input(array('name'=>'tglaktif','id'=>'tglaktif','class'=>'form-control','readonly'=>'readonly','value'=>$row->TGL_AKTIF));?>
							<div class="input-group-addon"><span id="bttglaktif" class="fa fa-calendar"></span></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group"><label  class="col-sm-4 control-label">NIK</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'nik','id'=>'nik','class'=>'form-control','value'=>$row->NIK));?></div>				
				</Div>
			</Div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="kotalahir" class="col-sm-4 control-label">Tempat Lahir</label>
					<div class="col-sm-8">
						<?php
							$kotalahir = array(
								'name'=>'kotalahir',
								'id'=>'kotalahir',
								'class'=>'form-control','value'=>$row->TEMPAT_LAHIR
							);
							echo form_input($kotalahir);
						?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="tgllahir" class="col-sm-4 control-label">Tanggal Lahir</label>
					<div class="col-sm-8">
					<div class="input-group">
						<?php
							$tgllahir = array(
								'name'=>'tgllahir',
								'id'=>'tgllahir',
								'class'=>'form-control',
								'readonly'=>'readonly','value'=>$row->TGL_LAHIR
							);
							echo form_input($tgllahir);
						?>
						<div class="input-group-addon"><span id="bttgllahir" class="fa fa-calendar"></span></div>
					</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="sex" class="col-sm-4 control-label">No.KTP</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'no_ktp','id'=>'no_ktp','class'=>'form-control','value'=>$row->TEMPAT_LAHIR));?></div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="sex" class="col-sm-4 control-label">Jenis Kelamin</label>
					<div class="col-sm-8">
						<?php
							echo form_dropdown('sex',$sex,$row->SEX,'id="sex" class="form-control"');
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="alamatktp" class="col-sm-2 control-label">Alamat KTP</label>
					<div class="col-sm-6">
						<?php
							$alamatktp = array(
								'name'=>'alamatktp',
								'id'=>'alamatktp',
								'class'=>'form-control','value'=>$row->ALAMATKTP
							);
							echo form_input($alamatktp);
							//echo form_input('empnip');
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="alamat" class="col-sm-2 control-label">Alamat Domisili</label>
					<div class="col-sm-6">
						<?php
							$alamat = array(
								'name'=>'alamat',
								'id'=>'alamat',
								'class'=>'form-control','value'=>$row->ALAMAT
							);
							echo form_input($alamat);
							//echo form_input('empnip');
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="telepon" class="col-sm-4 control-label">No. Telepon / HP</label>
					<div class="col-sm-8">
						<?php
							$telepon = array(
								'name'=>'telepon',
								'id'=>'telepon',
								'class'=>'form-control','value'=>$row->TELEPON
							);
							echo form_input($telepon);
						?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="email" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-8">
						<?php
							$email = array(
								'name'=>'email',
								'id'=>'email',
								'class'=>'form-control','value'=>$row->EMAIL
							);
							echo form_input($email);
						?>
					</div>
				</div>
			</div>
		</div><br>
</div><!-- panel body -->
</div><!-- panel wrapper -->

<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark">Data Keluarga</h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div  class="panel-body row pa-0"><br>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="nikah" class="col-sm-2 control-label">Status Pernikahan</label>
			<div class="col-sm-4">
				<?php
					echo form_dropdown('nikah',$nikah,$row->STATUS_NIKAH,'','id="nikah" class="form-control"');
				?>
			</div>
		</div>
	</div>	
</div>
<?php if ($row->STATUS_NIKAH==2){?>

<div class="row " >
		

			<div class="col-md-6">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Jumlah Anak</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'jml_anak','id'=>'jml_anak','class'=>'form-control','value'=>$row->JUMLAH_ANAK));?></div>
				</div>
			</div>
			
</div>	
<div class="row " >
	<div class="col-md-6">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Nama Kontak Keluarga</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'nama_kontak_keluarga','id'=>'nama_kontak_keluarga','class'=>'form-control','value'=>$row->NAMA_KONTAK_KELUARGA));?></div>
				</div>
		</div>
		<div class="col-md-6">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Nomer Telepon</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'no_telp','id'=>'no_telp','class'=>'form-control','value'=>$row->TELP_KELUARGA));?></div>
				</div>
			</div>
</div>
<?php }?>
		<br>
</div><!-- panel body -->
</div><!-- panel wrapper -->

<div class="panel-heading">
<div class="pull-left">
<h6 class="panel-title txt-dark">Data HRD</h6>
</div>
<div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
<div  class="panel-body row pa-0"><br>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="rekening" class="col-sm-2 control-label">No. Rekening</label>
			<div class="col-sm-4">
				<?php
					$rekening = array(
						'name'=>'rekening',
						'id'=>'rekening',
						'class'=>'form-control','value'=>$row->REKENING
					);
					echo form_input($rekening);
				?>
			</div>
		</div>
	</div>
</div>

	

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Cabang</label>
			<div class="col-sm-8">
				<?php
					echo form_dropdown('cabang',$cabang,$row->ID_CABANG,'id="cabang" class="form-control"');
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="divisi" class="col-sm-4 control-label">Divisi</label>
			<div class="col-sm-8">
				<?php echo form_dropdown('divisi',$divisi,$row->ID_DIV,'id="divisi" class="form-control"');?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="jabatan" class="col-sm-4 control-label">Jabatan</label>
			<div class="col-sm-8">
				<?php
					$options = array();
					echo form_dropdown('jabatan',$options,$row->ID_JAB,'id="jabatan" class="form-control"');
				?>
			</div>
		</div>
	</div>
	
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="stspegawai" class="col-sm-4 control-label">Status Karyawan</label>
			<div class="col-sm-8">
				<?php

					echo form_dropdown('stspegawai',$stspegawai,$row->STATUS_PEGAWAI,'id="stspegawai" class="form-control"');
				?>
			</div>
		</div>
	</div>
</div>

<div class="row" id="rowtetap">
	<div class="col-md-6">
		<div class="form-group">
			<label for="tglaktif" class="col-sm-4 control-label">Tanggal Aktif Kerja</label>
			<div class="col-sm-8">
				<div class="input-group">
				<?php
					$tglaktif = array(
						'name'=>'tglaktif',
						'id'=>'tglaktif',
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>revdate($row->TGL_AKTIF)
					);
					echo form_input($tglaktif);
				?>
				<div class="input-group-addon"><span id="bttglaktif" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
</div>

<div class="row" id="rowkontrak">
	<div class="col-md-6">
		<div class="form-group">
			<label for="tglawal" class="col-sm-4 control-label">Tanggal Awal Kontrak</label>
			<div class="col-sm-8">
				<div class="input-group">
				<?php
					$tglawal = array(
						'name'=>'tglawal',
						'id'=>'tglawal',
						'class'=>'form-control',
						'readonly'=>'readonly','value'=>revdate($row->TGL_AWAL_KONTRAK)
					);
					echo form_input($tglawal);
				?>
				<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="tglakhir" class="col-sm-4 control-label">Sampai Dengan</label>
			<div class="col-sm-8">
			<div class="input-group">
				<?php
					$tglakhir = array(
						'name'=>'tglakhir',
						'id'=>'tglakhir',
						'class'=>'form-control',
						'readonly'=>'readonly','value'=>revdate($row->TGL_AKHIR_KONTRAK)
					);
					echo form_input($tglakhir);
				?>
				<div class="input-group-addon"><span id="bttglakhir" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
</div>

	

</div><!-- panel body -->
</div><!-- panel wrap -->
</div><!-- panel default -->
<div class="row">
	<div class="col-md-6">
		
			<?php 
			$btsubmit = array(
					'name'=>'btsubmit',
					'id'=>'btsubmit',
					'value'=>'Simpan',
					'class'=>'btn btn-primary'
				);
			echo form_submit($btsubmit);?>  
			<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Batal',
					'onclick'=>"backTo('".base_url('employee/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>
<?php echo form_close();?>
	</div>
	
	
	<div class="tab-pane" id="family">
		<?php $this->load->view('employee/adm_hubkel'); ?>
	</div>
	
	
</div>



<script type="text/javascript">
$(function() {
    $( "#tglawal" ).datepicker({
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			$( "#tglakhir" ).datepicker( "option", "minDate", selectedDate);
			//$( "#tglaktif" ).datepicker( "setDate",selectedDate);
		}
	});
	$("#bttglawal").click(function() {
		$("#tglawal").datepicker("show");
	});
	
	$( "#tglakhir" ).datepicker({
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			$( "#tglawal" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	$("#bttglakhir").click(function() {
		$("#tglakhir").datepicker("show");
	});
	
	$( "#tgllahir" ).datepicker({
		dateFormat: 'dd-mm-yy',
		maxDate: 'today',
		changeYear: true,
		changeMonth: true,
		yearRange:'-100:+0'
	});
	$("#bttgllahir").click(function() {
		$("#tgllahir").datepicker("show");
	});
	
	$( "#tglaktif" ).datepicker({
		dateFormat: 'dd-mm-yy'
	});
	$("#bttglaktif").click(function() {
		$("#tglaktif").datepicker("show");
	});
});

$('#cabang').change(function(){
	$.ajax({
		url: "<?php echo base_url('employee/comboDivByCab'); ?>",
		dataType: 'json',
		type: 'POST',
		data: {cabang:$(this).val()},
		success: function(respon){
			$('#divisi').find('option').remove().end();
			if (respon.status==1){
				var item = respon.data;
				for (opt=0;opt<item.length;opt++){
					$('#divisi').append('<option value="'+item[opt].ID_DIV+'" '+(item[opt].ID_DIV==<?=$row->ID_DIV?>?' selected':'')+'>'+item[opt].NAMA_DIV+'</option>');
				}
				$('#divisi').val('<?php echo $row->ID_DIV;?>');
			}
			$('#divisi').trigger('change');
		}
	});
}).trigger('change');

$('#divisi').change(function(){
	$.ajax({
		url: "<?php echo base_url('employee/comboJabByDiv'); ?>",
		dataType: 'json',
		type: 'POST',
		data: {cabang:$('#cabang').val(),divisi:$(this).val()},
		success: function(respon){
			$('#jabatan').find('option').remove().end();
			if (respon.status==1){
				var item = respon.data;
				for (opt=0;opt<item.length;opt++){
					$('#jabatan').append('<option value="'+item[opt].ID_JAB+'" '+(item[opt].ID_JAB==<?=$row->ID_JAB?>?' selected':'')+'>'+item[opt].NAMA_JAB+'</option>');
				}
				$('#jabatan').trigger('change');
				
			}
		}
	});
}).trigger('change');

$('#jabatan').change(function(e){
	e.preventDefault();
	switch ($(this).val())
	{
	case "14":
		
		$('#lbllevelfo').text("Level FO");
		$.ajax({
			url: "<?php echo base_url('employee/fillLevelFO'); ?>",
			dataType: 'json',
			type: 'POST',
			data: {cabang:$('#cabang').val(),divisi:$(this).val()},
			success: function(respon){
				
				$('#levelfo').find('option').remove().end();
				if (respon.status==1){
					var item = respon.data;
					for (opt=0;opt<item.length;opt++){
						$('#levelfo').append('<option value="'+item[opt].ID +'">'+item[opt].LEVEL+'</option>');
					}
					<?php 
						$idlevelfo = empty($datafo)?"":$datafo->ID_LEVEL;
						?>
					$('#levelfo').val(<?php echo $idlevelfo;?>);
					$('#levelfo').change();
				}
			}
		});
				
		$('#divfo').show();
		break;
	case "13":
		
		$('#lbllevelfo').text('Kelompok FR');
		$.ajax({
				url: "<?php echo base_url('employee/fillKelompokFR'); ?>",
				dataType: 'json',
				type: 'POST',
				data: {cabang:$('#cabang').val(),divisi:$(this).val()},
				success: function(respon){
					console.log(respon);
					$('#levelfo').find('option').remove().end();
					if (respon.status==1){
						var item = respon.data;
						for (opt=0;opt<item.length;opt++){
							$('#levelfo').append('<option value="'+item[opt].KELOMPOK +'">'+item[opt].KELOMPOK+'</option>');
						}
						<?php 
						$kelFR = ((empty($kelFR->KELOMPOK_FR)||is_null($kelFR->KELOMPOK_FR))?"A":$kelFR->KELOMPOK_FR);
						?>			
						$('#levelfo').val("<?php echo $kelFR;?>");
						//alert($('#levelfo').val());
						$('#levelfo').change();
					}
				}
			});
		
		$('#divfo').show();
		break;
	default:
		$('#divfo').hide();
		break;
	
	}
	
}).trigger('change');

$('#stspegawai').change(function(){
	if ($(this).val()==1){
		//$('#rowtetap').show();
		$('#rowkontrak').hide();
	} else {
		//$('#rowtetap').hide();
		$('#rowkontrak').show();
	}
}).trigger('change');

$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('employee/edit/'.$row->ID);?>','<?php echo base_url('employee');?>');
	event.preventDefault();
});


$(document).ready(function(){
	//$('#myTab a:last').tab('show');
	$('#myTab a:first').tab('show');
	//$('#myTab a[href="#family"]').tab('show');
	
});

</script>