<div class="panel panel-default">
  <div class="panel-heading">Data Pelatihan</div>
  <div class="panel-body">
    
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataPelatihan" class="datatables" width="100%">
		<thead>
			<tr>
				<th>NO</th>
				<th>NAMA PELATIHAN</th>
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
   
	$('#dataPelatihan').dataTable().fnDestroy();
	function cetak(obj){
		var id = $(obj).attr('data-id');
		
		
	}
</script>