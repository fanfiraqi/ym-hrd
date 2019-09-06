<p>
<?	$disabled=""; 
	$disabledUpload="disabled"; 
if (date('d')>=19 && date('d')<=date('t')){ //21-last day && role admin/mgr pusat
		$disabled="disabled";
		$disabledUpload="href=".base_url('absensi/upload');
	}	
	echo '<a '.$disabledUpload.' id="btsubmit" class="btn btn-primary" >Upload Data Absensi</a>&nbsp;&nbsp;';
	//echo anchor('absensi/upload','Upload Data Absensi',array('id'=>'btsubmit','class'=>'btn btn-primary'));
	echo '<input type="button" class="btn btn-primary" id="btresetupload" value="Reset Data Upload" '.$disabled.'>' ?>
</p>
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
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>CABANG</th>
				<th>NIK</th>
				<th>NAMA</th>
				<th>TANGGAL</th>
				<th>JAM_MASUK</th>				
				<th>SCAN_MASUK</th>
				<th>TERLAMBAT</th>				
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
				{"mData": "KOTA"},
				{"mData": "NIK"},
				{"mData": "NAMA"},
				{"mData": "TANGGAL"},
				{"mData": "JAM_MASUK"},
				{"mData": "SCAN_MASUK"},
				{"mData": "TERLAMBAT"}

			],
			"sAjaxSource": "<?php echo base_url('absensi/json_data');?>"
		});
    });

		$('#btresetupload').click(function(){
			var pilih=confirm('Apakah proses reset data upload dilanjutkan ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('absensi/resetTableAbsen');?>",
					data	: "cabang="+$('#cabangfilter').val(),
					dataType: 'json',
					timeout	: 3000,  
					success	: function(res){
						console.log(res);
						if (res.status=='success'){
							bootbox.alert("data upload absensi berhasil dihapus");
						}						
					}
				});
			}
		});
		$('#cabangfilter').change(function(){
		$('#dataTables-example').dataTable().fnReloadAjax();

	});
    </script>