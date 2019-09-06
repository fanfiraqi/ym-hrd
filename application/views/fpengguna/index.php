<p><?php echo anchor('pengguna/userCreate','Tambah Pengguna',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>ID</th>
				<th>USERNAME</th>				
				<th>PASSWORD</th>
				<th>NIK</th>
				<th>ROLE AKSES</th>
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
				{"mData": "USERNAME" },
				{"mData": "PASSWORD" },
				{"mData": "NIK" },
				{"mData": "ROLE_AKSES" },
				{"mData": "ISACTIVE" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('pengguna/json_data');?>"
		});

		

    });
	
	function delUser(idx){
			var pilih=confirm('Data yang akan dihapus kode = '+idx+ '?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('pengguna/delUser');?>",
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