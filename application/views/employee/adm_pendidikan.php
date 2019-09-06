<div class="panel panel-default">
  <div class="panel-heading">Data Riwayat Pendidikan</div>
  <div class="panel-body">
    
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataPendidikan" class="datatables" width="100%">
		<thead>
			<tr>
				<th>NO</th>
				<th>PENDIDIKAN FORMAL</th>
				<th>PENDIDIKAN INFORMAL</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
	
  </div>
</div>

<script>
    
	$('#dataPendidikan').dataTable().fnDestroy();
	function cetak(obj){
		var id = $(obj).attr('data-id');
		
		
	}
</script>