<!-- <p><?php echo anchor('cuti/create','Buat Permohonan',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p> -->
<hr />
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

	<div class="col-sm-6">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Status</label>
			<div class="col-sm-8">
			<?php echo form_dropdown('status',array('0'=>'Tolak/Belum diproses', '1'=>'Disetujui'),'','id="status" class="form-control" ');?>
				
			</div>
		</div>
	</div>

</div>
<hr />
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables">
		<thead>
			<tr>
				<th>No Permohonan</th>
				<th>Tanggal Pemohonan</th>
				<th>NIK</th>
				<th>Nama</th>
				<th>Cabang/Div/Jab</th>
				<th>Tanggal Ijin</th>
				<th>Keterangan</th>
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
        $('#dataTables').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 25,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"fnServerParams": function ( aoData ) {
					aoData.push( { "name": "cabang", "value": $('#cabangfilter').val() },  { "name": "status", "value": $('#status').val() });
				},
			"aoColumns": [
				{"mData": "NO_TRANS" },
				{"mData": "TGL_TRANS" },
				{"mData": "NIK" },
				{"mData": "NAMA" },
				{"mData": "CABANG", "sortable":false },
				{"mData": "TGL_IJIN", "sortable":false},
				{"mData": "KETERANGAN", "sortable":false},
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('cuti/appv_data');?>"
		});
    });
	$('#cabangfilter').change(function(){
		$('#dataTables').dataTable().fnReloadAjax();

	});
	$('#status').change(function(){
		$('#dataTables').dataTable().fnReloadAjax();

	});
	function detail(obj){
		var id = $(obj).attr('data-id');
		var sts = $(obj).attr('data-sts');
		var isactive = $(obj).attr('data-isactive');
		$.ajax({
			url: "<?php echo base_url('cuti/view/'); ?>/"+id,
			dataType: 'html',
			type: 'POST',
			data: {ajax:'true'},
			success:
				function(data){
					if (isactive==0)	{
						bootbox.dialog({
						  message: data,
						  title: "Persetujuan Data",
						  buttons: {							
							main: {
							  label: "Kembali",
							  className: "btn-warning",
							  callback: function() {
								console.log("Primary button");
							  }
							}
						  }
						});
					}else{
					
						bootbox.dialog({
						  message: data,
						  title: "Persetujuan Data",
						  buttons: {
							success: {
							  label: "Setuju",
							  className: "btn-success",
							  callback: function() {
								approve(obj);
							  }
							},
							button: {
							  label: "Tolak",
							  className: "btn-danger",
							  callback: function() {
								denied(obj);
							  }
							},
							main: {
							  label: "Kembali",
							  className: "btn-warning",
							  callback: function() {
								console.log("Primary button");
							  }
							}
						  }
						});
					}
				}
		});
		
	}
</script>