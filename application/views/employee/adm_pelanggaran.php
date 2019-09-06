<div class="panel panel-default">
  <div class="panel-heading">Data Pelanggaran</div>
  <div class="panel-body">
    
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataPelanggaran" class="datatables" width="100%">
		<thead>
			<tr>
				<th>NO</th>
				<th>JENIS PELANGGARAN</th>
				<th>TANGGAL</th>
				<th>KETERANGAN</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
	
  </div>
</div>

<script>
    
	$('#dataPelanggaran').dataTable().fnDestroy();
	function cetak(obj){
		var id = $(obj).attr('data-id');
		
		
	}
</script>