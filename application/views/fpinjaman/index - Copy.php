
<p><?php echo anchor('pinjaman/create','Tambah Pinjaman',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>ID</th>
				<th>NIK</th>
				<th>NAMA</th>
				<th>TANGGAL</th>
				<th>JUMLAH </th>
				<th>LAMA</th>
				<th>KEPERLUAN</th>
				<th>STATUS</th>				
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
				{"mData": "TGL"},
				{"mData": "JUMLAH"},				
				{"mData": "LAMA" },
				{"mData": "KEPERLUAN" },
				{"mData": "STATUS" },				
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('pinjaman/json_data');?>"
		});
    });

	function delPinjaman(idx){
			var pilih=confirm('Hapus Data pinjaman = '+idx+ '?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('pinjaman/delPinjaman');?>",
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