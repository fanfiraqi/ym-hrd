
<p><?php echo anchor('prestasi/create','Entri Prestasi',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>ID</th>
				<th>NIK</th>
				<th>NAMA</th>
				<th>PRESTASI</th>
				<th>CABANG</th>
				<th>DIVISI</th>
				<th>JABATAN</th>				
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
			"aoColumns": [
				{"mData": "ID" },
				{"mData": "NIK"},
				{"mData": "NAMA"},
				{"mData": "PRESTASI"},				
				{"mData": "CABANG" },
				{"mData": "DIVISI" },
				{"mData": "JABATAN" },				
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('prestasi/json_data');?>"
		});
    });

	function delPrestasi(idx){
			var pilih=confirm('Hapus Data Prestasi = '+idx+ '?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('prestasi/delPrestasi');?>",
					data	: "idx="+idx,
					timeout	: 3000,  
					success	: function(res){
						alert("data berhasil dihapus");
						window.location.reload();
						}
					
				});
			}
		}
    </script>