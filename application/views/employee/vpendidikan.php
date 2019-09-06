<div class="control-group"><a href="javascript:void(0)" id="btcreate" class="btn btn-primary">Tambah Data</a></div>
<div id="errorHandler" class="alert alert-danger no-display"></div>

<div id="divformkel" class="no-display">
<?php echo form_open('',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row" >
	<div class="col-xs-12">
	<div class="panel panel-default card-view">
        <div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">TAMBAH/EDIT DATA PENDIDIKAN</h6>
									</div>
									
									<div class="clearfix"></div>
								</div>
	<div class="panel-wrapper collapse in">
	<div  class="panel-body row pa-0">
	<br>
	<div class="row">
			<div class="col-md-6">
				<div class="form-group"><label class="col-sm-4 control-label">KETIK NAMA PEGAWAI</label>
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

</div><!-- panel-body -->


<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
							<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Pendidikan Formal</h6>
									</div>
									
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div  class="panel-body row pa-0">
										<table class="table table-hover mb-0">
											<thead>
												<tr>
													<th>Pendidikan Terakhir</th>
													<th>Jurusan/Universitas</th>
													<th>IPK</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?=form_input(array('name'=>'pddk_terakhir','id'=>'pddk_terakhir','class'=>'form-control'));?></td>
													<td><?=form_input(array('name'=>'jur_univ','id'=>'jur_univ','class'=>'form-control'));?></td>
													<td><?=form_input(array('name'=>'ipk','id'=>'ipk','class'=>'form-control'));?></td>
												</tr>
												
											</tbody>
										</table>
									</div> <!-- panel-body -->
								</div> <!-- panel-wrapper -->

								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">Pendidikan Informal</h6>
									</div>
									
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div  class="panel-body row pa-0">
										<table class="table table-hover mb-0">
											<thead>
												<tr>
													<th>I</th>
													<th>II</th>
													<th>III</th>
													<th>IV</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><?=form_textarea(array('name'=>'pddk_inf1','id'=>'pddk_inf1','class'=>'form-control', 'rows'=>3));?></td>
													<td><?=form_textarea(array('name'=>'pddk_inf2','id'=>'pddk_inf2','class'=>'form-control', 'rows'=>3));?></td>
													<td><?=form_textarea(array('name'=>'pddk_inf3','id'=>'pddk_inf3','class'=>'form-control', 'rows'=>3));?></td>
													<td><?=form_textarea(array('name'=>'pddk_inf4','id'=>'pddk_inf4','class'=>'form-control', 'rows'=>3));?></td>
												
												</tr>
												
											</tbody>
										</table>
									</div>
								</div><!-- panel-wrapper -->
					</div> <!-- panel-default -->
</div><!-- col-lg-10 -->

	<div class="row">
		<div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
			<input type="hidden" name="id" id="id">
			<input type="hidden" name="state" id="state" value="add">
			<input type="button" class="btn btn-primary" id="btsimpankel" value="Simpan">
			<button type="button" class="btn btn-default" id="btcancelkel">Batal</button>
		</div>
	</div>

</div> <!-- panel-wrapper top -->
<br>

</div> <!-- panel-default -->
</div> <!-- col-xs-12 -->
</div> <!-- row-fluid -->
<?php echo form_close();?>
<br>
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
 <div class="row" >
	<div class="col-xs-12">

					<table class="table table-bordered data-table  " id="dataTables-cab">
						<thead>
							<tr>
								<th>NIK</th>
								<th>Nama</th>				
								<th>Cabang</th>	
								<th>Divisi</th>	
								<th>Jabatan</th>	
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
			
</div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables-cab').dataTable({
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
				{"mData": "nik" },
				{"mData": "nama" },
				{"mData": "cabang" },
				{"mData": "divisi" },
				{"mData": "jabatan" },
				{"mData": "action", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('employee_data/json_data_pendidikan');?>"
		});
    });	

	$('#cabangfilter').change(function(){
		$('#dataTables-cab').dataTable().fnReloadAjax();

	});
	
	$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('employee_data/getPegToEdu'); ?>",
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
				bootbox.alert("Terjadi kesalahan. Data gagal disimpan."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});
	}
});

	$('#btcreate').click(function(){
		$("#divformkel").fadeSlide("show");
		$('#state').val('add');
		$('#myform').reset();
		
		
	});
	$('#btcancelkel').click(function(){
		$("#divformkel").fadeSlide("hide");
	});

	
	$('#btsimpankel').click(function(){		
		var form_data = $('#myform').serialize();
		
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('employee_data/savePendidikan');?>",
			data: form_data,				
			dataType: 'json',
			success: function(msg) {
				 $("#errorHandler").html('&nbsp;').hide();
				 console.log(msg);
				if(msg.status =='success'){
					$().showMessage('Data berhasil disimpan.','success',1000);
					$("#divformkel").fadeSlide("hide");
					$('#dataTables-cab').dataTable().fnReloadAjax();
					window.location.reload();				
				} else{
					bootbox.alert("Terjadi kesalahan. "+ msg.errormsg+". Data gagal disimpan.");				
					$("#errorHandler").html(msg.errormsg).show();
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				//$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger');
				bootbox.alert("Terjadi kesalahan. Data gagal disimpan."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});
		//$().showMessage('Data pembelian berhasil disimpan, data order akan dikirim melalui sms','success',1000);
	});

	function delThis(idx,  str){	//nik, nama
			var pilih=confirm('Apakah data   '+str+ ' akan dihapus ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('employee_data/delThis');?>",
					data	: "idx="+idx+"&proses=peg_pendidikan"+"&field=nik",
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
			url: '<?php echo base_url('employee_data/editThis');?>',
			data: "id="+id+"&tabel=peg_pendidikan"+"&field=nik",
			dataType: 'json',
			success: function(msg) {
				
				if(msg.status =='success'){
					console.log(msg.data);
					
					$('#nik').val(msg.data.nik);
					$('#nama').val(msg.data.NAMA);
					$('#cabang').val(msg.master.NAMA_CABANG);
					$('#jabatan').val(msg.master.NAMA_DIV);
					$('#divisi').val(msg.master.NAMA_JAB);
					$('#pddk_terakhir').val(msg.data.pf_terakhir);
					$('#jur_univ').val(msg.data.pf_jur_univ);
					$('#ipk').val(msg.data.pf_ipk);
					$('#pddk_inf1').val(msg.data.pinf_1);
					$('#pddk_inf2').val(msg.data.pinf_2);
					$('#pddk_inf3').val(msg.data.pinf_3);
					$('#pddk_inf4').val(msg.data.pinf_4);
					$("#divformkel").fadeSlide("show");
					
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger',2000);
			},
			cache: false
		});
	}

	
</script>