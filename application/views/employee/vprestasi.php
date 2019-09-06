<div class="control-group"><a href="javascript:void(0)" id="btcreate" class="btn btn-primary">Tambah Data</a></div>
<div id="errorHandler" class="alert alert-danger no-display"></div>
<br>
<div id="divformkel" class="no-display">
<?php echo form_open(null,array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control'));?><input type="hidden" name="nik" id="nik"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'cabang','id'=>'cabang','readonly'=>'true','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">DIVISI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'divisi','id'=>'divisi','readonly'=>'true','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">JABATAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'jabatan','id'=>'jabatan','readonly'=>'true','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">NAMA/JENIS PENILAIAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama_penilaian','id'=>'nama_penilaian','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL DIBUAT</label>
			<div class="col-sm-8">
			<div class="input-group">
			<?=form_input(array('name'=>'tgl_dibuat','id'=>'tgl_dibuat','class'=>'form-control'));?>
			<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">NO. DOKUMEN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'no_dokumen','id'=>'no_dokumen','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">PERIODE PENILAIAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'periode_penilaian','id'=>'periode_penilaian','class'=>'form-control'));?>	</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">REVISI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'revisi','id'=>'revisi','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KEUNGGULAN</label>
			<div class="col-sm-8"><?=form_textarea(array('name'=>'keunggulan','id'=>'keunggulan','class'=>'form-control'));?>	</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">HAL YANG PERLU DIPERBAIKI</label>
			<div class="col-sm-8"><?=form_textarea(array('name'=>'diperbaiki','id'=>'diperbaiki','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">SARAN</label>
			<div class="col-sm-8"><?=form_textarea(array('name'=>'saran','id'=>'saran','class'=>'form-control'));?>	</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">USULAN PELATIHAN</label>
			<div class="col-sm-8"><?=form_textarea(array('name'=>'usulan','id'=>'usulan','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NILAI PRESTASI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nilai','id'=>'nilai','class'=>'form-control'));?></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">TANGGAPAN DARI YANG DINILAI</label>
			<div class="col-sm-8"><?=form_textarea(array('name'=>'tanggapan','id'=>'tanggapan','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL EVALUASI</label>
			<div class="col-sm-8">
			<div class="input-group">
			<?=form_input(array('name'=>'tgl_evaluasi','id'=>'tgl_evaluasi','class'=>'form-control'));?>
			<div class="input-group-addon"><span id="bttglawal2" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">PETUGAS EVALUASI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'petugas_eval','id'=>'petugas_eval','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL TERIMA</label>
			<div class="col-sm-8">
			<div class="input-group">
			<?=form_input(array('name'=>'tgl_terima','id'=>'tgl_terima','class'=>'form-control'));?>
			<div class="input-group-addon"><span id="bttglawal3" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">DITERIMA OLEH</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'petugas_terima','id'=>'petugas_terima','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<input type="hidden" name="id" id="id">
		<input type="hidden" name="state" id="state" value="add">
		<input type="button" class="btn btn-primary" id="btsimpan" value="Simpan">
		<button type="button" class="btn btn-default" id="btcancel">Batal</button>
	</div>
</div>

<?php echo form_close();?>
<hr/>
</div> <!-- divformkel -->
&nbsp;<br>
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Cabang</label>
			<div class="col-sm-8">
				<?php
				if ($this->session->userdata('auth')->id_cabang=="1"){
					echo form_dropdown('cabangfilter',$cabang,'','id="cabangfilter" class="form-control" ');
				}else{
					echo '<input type="hidden" name="cabangfilter" id ="cabangfilter" value="'.$cabang->id_cabang.'"/>';
					echo '<label  class="col-sm-4 control-label">'.$cabang->kota.'</label>';
				}
				?>
			</div>
		</div>
	</div>	
</div>

<br>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-list">
		<thead>
			<tr>
				<th>ID</th>
				<th>NIK</th>
				<th>NAMA</th>
				<th>JENIS PENILAIAN</th>
				<th>CABANG</th>
				<th>DIVISI</th>
				<th>JABATAN</th>				
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
<!-- /.table-responsive -->
<script>
    $(document).ready(function() {
        $('#dataTables-list').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 25,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"fnServerParams": function ( aoData ) {
				aoData.push({ "name": "cabang", "value": $('#cabangfilter').val()} 
				);
			},
			"aoColumns": [
				{"mData": "ID" },
				{"mData": "NIK"},
				{"mData": "NAMA"},
				{"mData": "NAMA_PENILAIAN"},				
				{"mData": "CABANG" },
				{"mData": "DIVISI" },
				{"mData": "JABATAN" },				
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('prestasi/json_data');?>"
		});
    });

	$('#cabangfilter').change(function(){
		$('#dataTables-list').dataTable().fnReloadAjax();

	});

	$('#btcreate').click(function(){
		$("#divformkel").fadeSlide("show");
		$('#state').val('add');
		$('#myform').reset();
		
		
	});
	$('#btcancel').click(function(){
		$("#divformkel").fadeSlide("hide");
	});


$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('employee_data/getPeg'); ?>",
			dataType: 'json',
			type: 'POST',
			data: req,
			success:   
			function(data){
				if(data.response =="true"){
					add(data.message);
				}
			}
		});
	},
	select:
	function(event, ui) {                   
		$("#nik").val(ui.item.id);  
		//get label & status entry, if 1 then alert klik tombol edit
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('employee_data/getLabelMaster');?>",
			data: { id_cabang: ui.item.id_cabang, id_div: ui.item.id_div, id_jab:ui.item.id_jab},				
			dataType: 'json',
			success: function(msg) {
				 console.log(msg);
				if(msg.status =='success'){
					$("#cabang").val(msg.data.NAMA_CABANG);
					$("#divisi").val(msg.data.NAMA_DIV);
					$("#jabatan").val(msg.data.NAMA_JAB);
									
				} else{
					bootbox.alert("Terjadi kesalahan. "+ msg.errormsg+". Gagal ambil data");				
					
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				bootbox.alert("Terjadi kesalahan. error."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});
	}
});

$( "#tgl_dibuat" ).datepicker({
		//minDate: 'today',
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			
		}
	});
$("#bttglawal").click(function() {
		$("#tgl_dibuat").datepicker("show");
	});
	
$( "#tgl_evaluasi" ).datepicker({
		//minDate: 'today',
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			
		}
	});
$("#bttglawal2").click(function() {
		$("#tgl_evaluasi").datepicker("show");
	});
$( "#tgl_terima" ).datepicker({
		//minDate: 'today',
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			
		}
	});
$("#bttglawal3").click(function() {
		$("#tgl_terima").datepicker("show");
	});
	
	function delThis(idx,  str){	//nik, nama
			var pilih=confirm('Apakah data penilaian prestasi  '+str+ ' akan dihapus ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('prestasi/delThis');?>",
					data	: "idx="+idx+"&proses=prestasi"+"&field=id",
					timeout	: 3000,  
					success	: function(res){
						//alert(res);
						alert("data berhasil dihapus");
						window.location.reload();
						}
				});
			}
		}

	function editThis(obj){
		var id = $(obj).attr('data-id');	//id as nik
		$('#myform input[name="state"]').val(id);		
		$('#lbltitle').text('Edit Data');
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url('prestasi/editThis');?>',
			data: {
				id:id
			},
			dataType: 'json',
			success: function(msg) {
				
				if(msg.status =='success'){
					console.log(msg.data);
					
					$('#nik').val(msg.data.NIK);
					$('#nama').val(msg.data.NAMA);
					$('#cabang').val(msg.master.NAMA_CABANG);
					$('#jabatan').val(msg.master.NAMA_DIV);
					$('#divisi').val(msg.master.NAMA_JAB);
					$('#tgl_dibuat').val(msg.data.TANGGAL_DIBUAT);
					$('#nama_penilaian').val(msg.data.NAMA_PENILAIAN);
					$('#no_dokumen').val(msg.data.NO_DOKUMEN);					
					$('#revisi').val(msg.data.REVISI);					
					$('#periode_penilaian').val(msg.data.PERIODE_PENILAIAN);					
					$('#nilai').val(msg.data.NILAI_PRESTASI);					
					$('#keunggulan').val(msg.data.EV_KEUNGGULAN);					
					$('#diperbaiki').val(msg.data.EV_PERBAIKAN);					
					$('#saran').val(msg.data.EV_SARAN);					
					$('#usulan').val(msg.data.EV_USULAN_PELATIHAN);					
					$('#tgl_evaluasi').val(msg.data.TGL_EVALUASI);					
					$('#tanggapan').val(msg.data.TANGGAPAN);					
					$('#petugas_eval').val(msg.data.PETUGAS_EVALUASI);					
					$('#tgl_terima').val(msg.data.TGL_TERIMA);					
					$('#petugas_terima').val(msg.data.TERIMA_OLEH);					
					$("#divformkel").fadeSlide("show");
					
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger',2000);
			},
			cache: false
		});
	}
	

	$('#btsimpan').click(function(){		
		var form_data = $('#myform').serialize();
		
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('prestasi/saveData');?>",
			data: form_data,				
			dataType: 'json',
			success: function(msg) {
				 $("#errorHandler").html('&nbsp;').hide();
				 console.log(msg);
				if(msg.status =='success'){
					$().showMessage('Data berhasil disimpan.','success',1000);
					$("#divformkel").fadeSlide("hide");
					$('#dataTables-list').dataTable().fnReloadAjax();
					window.location.reload();				
				} else{
					bootbox.alert("Terjadi kesalahan. "+ msg.errormsg+". Data gagal disimpan.");				
					$("#errorHandler").html(msg.errormsg).show();
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				bootbox.alert("Terjadi kesalahan. Data gagal disimpan."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});
	});

    </script>