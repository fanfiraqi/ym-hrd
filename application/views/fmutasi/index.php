<p><?php echo anchor('mutasi/create','Tambah Data Mutasi',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>
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
</div>
<hr />
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>ID</th>
				<th>NIK</th>
				<th>NAMA</th>
				<th>DIMUTASI KE</th>
				<th>DARI</th>
				<th>TGL PENETAPAN</th>
				<th>KETERANGAN</th>
				<th>MENGETAHUI</th>
				<th>MENYETUJUI</th>
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
					aoData.push( { "name": "cabang", "value": $('#cabangfilter').val() });
				},
			"aoColumns": [
				{"mData": "ID" },
				{"mData": "NIK"},
				{"mData": "NAMA"},
				{"mData": "MUTASI"},
				{"mData": "DARI"},
				{"mData": "TANGGAL"},				
				{"mData": "KETERANGAN" },
				{"mData": "MENGETAHUI" },
				{"mData": "MENYETUJUI" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('mutasi/json_data');?>"
		});
    });

$('#cabangfilter').change(function(){
		$('#dataTables-example').dataTable().fnReloadAjax();

	});
		
function delMutasi(idx){
			var pilih=confirm('Data yang akan dihapus kode = '+idx+ '?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('mutasi/delMutasi');?>",
					data	: "idx="+idx,
					timeout	: 3000,  
					success	: function(res){
						//alert(res);
						alert("data berhasil dihapus");
						window.location.reload();
						}
					
				});
			}
		}

</script>