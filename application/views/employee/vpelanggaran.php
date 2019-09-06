<div class="control-group"><a href="javascript:void(0)" id="btcreate" class="btn btn-primary">Entri Pelanggaran</a></div>
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
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL PELANGGARAN</label>
			<div class="col-sm-8">
			<div class="input-group">
			<?=form_input(array('name'=>'tanggal','id'=>'tanggal','class'=>'form-control'));?>
			<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">NAMA PELANGGARAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'pelanggaran','id'=>'pelanggaran','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KETERANGAN</label>
			<div class="col-sm-8"><?=form_textarea(array('name'=>'keterangan','id'=>'keterangan','class'=>'form-control'));?>	</div>
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
<br>
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
				<th>PELANGGARAN</th>
				<th>TANGGAL</th>
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
				{"mData": "PELANGGARAN"},				
				{"mData": "TANGGAL"},				
				{"mData": "CABANG" },
				{"mData": "DIVISI" },
				{"mData": "JABATAN" },						
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('pelanggaran/json_data');?>"
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
				bootbox.alert("Terjadi kesalahan. error ."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});
	}
});

$( "#tanggal" ).datepicker({
		//minDate: 'today',
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			
		}
	});
	$("#bttglawal").click(function() {
		$("#tanggal").datepicker("show");
	});
	

	function delThis(idx,  str){	//nik, nama
			var pilih=confirm('Apakah data pelanggaran  '+str+ ' akan dihapus ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('pelanggaran/delThis');?>",
					data	: "idx="+idx+"&proses=pelanggaran"+"&field=id",
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
			url: '<?php echo base_url('pelanggaran/editThis');?>',
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
					$('#tanggal').val(msg.data.TANGGAL);
					$('#pelanggaran').val(msg.data.NAMA_PELANGGARAN);
					$('#keterangan').val(msg.data.KETERANGAN);					
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
			url: "<?php echo base_url('pelanggaran/saveData');?>",
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