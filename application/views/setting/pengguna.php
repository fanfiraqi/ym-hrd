<p><?php echo anchor('pengguna/addUser','Tambah Pengguna',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>ID</th>
				<th>Username</th>				
				<th>Password</th>
				<th>NIK</th>
				<th>Status</th>
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
				{"mData": "ISACTIVE" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('pengguna/json_data');?>"
		});
    });
    </script>