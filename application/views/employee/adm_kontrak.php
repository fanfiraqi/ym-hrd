<div class="panel panel-default">
  <div class="panel-heading">Data Riwayat Kerja/Mutasi/Kontrak di Yatim Mandiri</div>
  <div class="panel-body">
    
	<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataKontrak" class="datatables" width="100%">
		<thead>
			<tr>
				<th>Tanggal Penetapan</th>
				<th>Jenis Kontrak</th>
				<th>Cabang</th>
				<th>Divisi</th>
				<th>Jabatan</th>
				<th>Tanggal Awal</th>
				<th>Tanggal Akhir</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
	
  </div>
</div>

<script>
    
	$('#dataKontrak').dataTable().fnDestroy();
	function cetak(obj){
		var id = $(obj).attr('data-id');
		
		
	}
</script>