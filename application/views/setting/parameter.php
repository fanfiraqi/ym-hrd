<div class="table-responsive">
	<table  class="table table-striped table-bordered table-hover display mb-30" id="dataTables-example">
		<thead>
			<tr>
				<th>Deskripsi</th>
				<th>Shortcode</th>
				<th>Nama</th>
				<th>No. Rekening</th>
				<!-- <th>Action</th> -->
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
<!-- /.table-responsive -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "<?php echo base_url('setting/json');?>"
		});
    });
    </script>