<div class="panel panel-default">
  <div class="panel-heading">Data Penilaian/Prestasi</div>
  <div class="panel-body">
    
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataPrestasi" class="datatables" width="100%">
		<thead>
			<tr>
				<th>NO</th>
				<th>JENIS PENILAIAN</th>
				<th>DETIL DOKUMEN</th>
				<th>DETIL EVALUASI</th>
				<th>INFO VALIDASI</th>
				<th>TANGGAPAN</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
	
  </div>
</div>

<script>
   
	$('#dataPrestasi').dataTable().fnDestroy();
	function cetak(obj){
		var id = $(obj).attr('data-id');
		
		
	}
</script>