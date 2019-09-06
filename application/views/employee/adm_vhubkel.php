<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables">
		<thead>
			<tr>
				<th>Hub. Keluarga</th>
				<th>Anak Ke</th>
				<th>Nama</th>
				<th>Jenis Kelamin</th>
				<th>Tempat Lahir</th>
				<th>Tanggal Lahir</th>
				<th>Pendidikan</th>
				<th>Pekerjaan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>

<!-- Modal -->
      
</div>
<!-- /.table-responsive -->
<script>
    $(document).ready(function() {
        $('#dataTables	').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 10,
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "state", "value": "read" } );
			},
			"aoColumns": [
				{"mData": "HUBKEL" },
				{"mData": "ANAK_KE" },
				{"mData": "NAMA" },
				{"mData": "SEX" },
				{"mData": "KOTA" },
				{"mData": "TGL_LAHIR" },
				{"mData": "PENDIDIKAN" },
				{"mData": "PEKERJAAN" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('employee/json_family/'.$row->NIK);?>"
		});
    });
</script>