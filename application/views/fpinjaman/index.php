<!-- <p><?php echo anchor('pinjaman/create','Tambah Pinjaman',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p> -->

<div class="control-group"><a href="javascript:void(0)" id="btcreate" class="btn btn-primary">Tambah Data Pinjaman</a></div>
<div id="errorHandler" class="alert alert-danger no-display"></div>
<br>
<div id="divformkel" class="no-display">
<?php echo form_open('',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control'));?><input type="hidden" name="nik" id="nik">*Jika tidak ditemukan nama/nik yang dicari berarti status masih ada pinjaman belum lunas</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">JUMLAH PINJAMAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'jumlah','id'=>'jumlah','class'=>'form-control','onkeypress'=>"return numericVal(this,event)", 'onblur'=>"blurObj(this)",'onclick'=>"clickObj(this)", "value"=>0));?> *Angka saja</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">LAMA PINJAMAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'lama','id'=>'lama','class'=>'form-control'));?> x ANGSURAN</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL PINJAMAN</label>
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
		<div class="form-group"><label class="col-sm-4 control-label">KEPERLUAN</label>
			<div class="col-sm-8"><?=form_textarea(array('name'=>'keperluan','id'=>'keperluan','class'=>'form-control'));?>	</div>
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
</div>
<hr/>
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
<hr/>

<div class="alert alert-success" style="padding:10px;">
Informasi : <br>
	- Data pinjaman yang sudah ada angsuran/cicilan tidak bisa dihapus (tombol hapus tidak muncul)<br>
	- Jika edit data pinjaman (khususnya pada bagian jumlah dan lama), maka data cicilan/angsuran akan di reset sesuai perubahan. Untuk memperbaiki Per cicilannya silahkan diedit di menu <b>Pembayaran Angsuran</b>
</div>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>ID</th>
				<th>NIK</th>
				<th>NAMA</th>
				<th>TANGGAL</th>
				<th>JUMLAH </th>
				<th>LAMA</th>
				<th>KEPERLUAN</th>
				<th>STATUS</th>				
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
        $('#dataTables-example').dataTable({
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
				{"mData": "TGL"},
				{"mData": "JUMLAH"},				
				{"mData": "LAMA" },
				{"mData": "KEPERLUAN" },
				{"mData": "STATUS" },				
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('pinjaman/json_data');?>"
		});
    });
$('#cabangfilter').change(function(){
		$('#dataTables-example').dataTable().fnReloadAjax();

	});
$('#btcreate').click(function(){
		$("#divformkel").fadeSlide("show");
		$('#state').val('add');
		$('#myform').reset();
		
		
	});
$('#btcancel').click(function(){
		$("#divformkel").fadeSlide("hide");
	});
function delThis(idx,  str){	//nik, nama
			var pilih=confirm('Apakah data pelatihan  '+str+ ' akan dihapus ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('pinjaman/delThis');?>",
					data	: "idx="+idx+"&proses=pinjaman"+"&field=id",
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
		var id = $(obj).attr('data-id');	//id 
		$('#myform input[name="state"]').val(id);		
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url('pinjaman/editThis');?>',
			data: {
				id:id
			},
			dataType: 'json',
			success: function(msg) {				
				if(msg.status =='success'){
					console.log(msg.data);					
					$('#nik').val(msg.data.NIK);
					$('#nama').val(msg.data.NAMA);
					$('#jumlah').val(msg.data.JUMLAH);
					$('#lama').val(msg.data.LAMA);
					$('#tanggal').val(msg.data.TGL);
					$('#keperluan').val(msg.data.KEPERLUAN);
					$("#divformkel").fadeSlide("show");					
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger',2000);
			},
			cache: false
		});
	}
	

$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('pinjaman/create');?>','<?php echo base_url('pinjaman');?>');
	event.preventDefault();
});



  
$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('pinjaman/getPegawai'); ?>",
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

	$('#btsimpan').click(function(){		
		var form_data = $('#myform').serialize();
		
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('pinjaman/saveData');?>",
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