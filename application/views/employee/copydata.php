<?php errorHandler();?>
<?php echo form_open('employee/copydata',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="nama" class="col-sm-4 control-label">Nama Lengkap</label>
			<div class="col-sm-8">
				<?php
					$nama = array(
						'name'=>'nama',
						'id'=>'nama',
						'class'=>'form-control'
					);
					echo form_input($nama);
					echo form_hidden('nikasal');
				?>
				<span class="help-block">Ketik nama pegawai yang akan disalin</span>
			</div>
		</div>
	</div>
	<div class="col-md-6">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Nama Panggilan</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'nama_panggilan','id'=>'nama_panggilan','class'=>'form-control'));?></div>
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
						'readonly'=>'readonly'
					);
					echo form_input($tglaktif);
				?>
				<div class="input-group-addon"><span id="bttglaktif" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
				<div class="form-group"><label  class="col-sm-4 control-label">NIK  Baru</label>
				<div class="col-sm-8"><?=form_input(array('name'=>'nik','id'=>'nik','class'=>'form-control'));?></div>				
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
						'class'=>'form-control'
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
						'readonly'=>'readonly'
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
					<div class="col-sm-8"><?=form_input(array('name'=>'no_ktp','id'=>'no_ktp','class'=>'form-control'));?></div>
				</div>
			</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">Jenis Kelamin</label>
			<div class="col-sm-8">
				<?php
					echo form_dropdown('sex',$sex,'','id="sex" class="form-control"');
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
						'class'=>'form-control'
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
			<label for="alamat" class="col-sm-2 control-label">Alamat Sekarang</label>
			<div class="col-sm-6">
				<?php
					$alamat = array(
						'name'=>'alamat',
						'id'=>'alamat',
						'class'=>'form-control'
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
						'class'=>'form-control'
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
						'class'=>'form-control'
					);
					echo form_input($email);
				?>
			</div>
		</div>
	</div>
</div>
<div class="row no-display">
	<div class="col-md-12">
		<div class="form-group">
			<label for="pendidikan" class="col-sm-2 control-label">Pendidikan Terakhir</label>
			<div class="col-sm-4">
				<?php
					echo form_dropdown('pendidikan',$pendidikan,'','id="pendidikan" class="form-control"');
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="nikah" class="col-sm-2 control-label">Status Pernikahan</label>
			<div class="col-sm-4">
				<?php
					echo form_dropdown('nikah',$nikah,'','id="nikah" class="form-control"');
				?>
			</div>
		</div>
	</div>
</div>
<div class="row no-display" id="row_sts_nikah">
		<div class="col-md-6">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Nama Kontak Keluarga</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'nama_kontak_keluarga','id'=>'nama_kontak_keluarga','class'=>'form-control'));?></div>
				</div>
		</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Jumlah Anak</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'jml_anak','id'=>'jml_anak','class'=>'form-control'));?></div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Nomer Telepon</label>
					<div class="col-sm-8"><?=form_input(array('name'=>'no_telp','id'=>'no_telp','class'=>'form-control'));?></div>
				</div>
			</div>
	
	</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="rekening" class="col-sm-2 control-label">No. Rekening</label>
			<div class="col-sm-4">
				<?php
					$rekening = array(
						'name'=>'rekening',
						'id'=>'rekening',
						'class'=>'form-control'
					);
					echo form_input($rekening);
				?>
			</div>
		</div>
	</div>
</div>

<hr />

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Cabang</label>
			<div class="col-sm-8">
				<?php
					echo form_dropdown('cabang',$cabang,'','id="cabang" class="form-control"');
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="divisi" class="col-sm-4 control-label">Divisi</label>
			<div class="col-sm-8">
				<?php echo form_dropdown('divisi',$divisi,'','id="divisi" class="form-control"');?>
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
					echo form_dropdown('jabatan',$options,'','id="jabatan" class="form-control"');
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
					echo form_dropdown('stspegawai',$stspegawai,'','id="stspegawai" class="form-control"');
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="stspegawai" class="col-sm-4 control-label">Program JHT</label>
			<div class="col-sm-8">
				<?php
					$program_jht= array( '0'=>"TIDAK IKUT", '1'=>"IKUT");
					echo form_dropdown('program_jht',$program_jht,'','id="program_jht" class="form-control"');
				?>
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
						'readonly'=>'readonly'
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
						'readonly'=>'readonly'
					);
					echo form_input($tglakhir);
				?>
				<div class="input-group-addon"><span id="bttglakhir" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
</div>
<hr />
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


<script>
$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('employee/lookupemp'); ?>",
			dataType: 'json',
			type: 'POST',
			data: req,
			success:   
			function(data){
				if(data.response =="true"){
					add(data.message);
				} else {
					add();
					$("#nikasal").val('');
				}
			}
		});
	},
	select:
	function(event, ui) {
		$("#nikasal").val(ui.item.id);  
		if(ui.item.id!=''){
			$('#kotalahir').val(ui.item.pegawai.TEMPAT_LAHIR);
			$('#tgllahir').val(ui.item.pegawai.TGLLAHIR);
			$('#alamat').val(ui.item.pegawai.ALAMAT);
			$('#alamatktp').val(ui.item.pegawai.ALAMATKTP);
			$('#telepon').val(ui.item.pegawai.TELEPON);
			$('#email').val(ui.item.pegawai.EMAIL);
			$('#pendidikan').val(ui.item.pegawai.PENDIDIKAN);
			$('#sex').val(ui.item.pegawai.SEX);
			$('#rekening').val(ui.item.pegawai.REKENING);
		} else {
			console.log('reset');
		}
	}
});

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
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			
		},		
		onClose:function( selectedDate ){ 		
			
			$.ajax({
			type: 'POST',
			url: '<?php echo base_url('employee/genNik');?>',
			data: "tgl="+$(this).val(),
			dataType: 'json',
			success: function(msg) {
				if(msg.status =='success'){
					$('#nik').val(msg.nik);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger',2000);
			},
			cache: false
		});
		}
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
				console.log('respon.data',respon.data.ID_DIV);
				for (opt=0;opt<item.length;opt++){
					$('#divisi').append('<option value="'+item[opt].ID_DIV+'">'+item[opt].NAMA_DIV+'</option>');
				}
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
					$('#jabatan').append('<option value="'+item[opt].ID_JAB+'">'+item[opt].NAMA_JAB+'</option>');
				}
			}
		}
	});
}).trigger('change');

$('#nikah').change(function(){
	
	if ($(this).val()==1){
		$('#row_sts_nikah').fadeSlide("hide");
	} else {
		$('#row_sts_nikah').fadeSlide("show");
	}
}).trigger('change');


$('#stspegawai').change(function(){
	if ($(this).val()==6){
		//$('#rowtetap').show();
		$('#rowkontrak').hide();
	} else {
		//$('#rowtetap').hide();
		$('#rowkontrak').show();
	}
}).trigger('change');

$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('employee/copydata');?>','<?php echo base_url('employee');?>');
	event.preventDefault();
});


$(document).ready(function(){
});


</script>