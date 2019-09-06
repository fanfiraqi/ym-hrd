<p><?php echo anchor('libur/liburCreate','Tambah libur',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>&nbsp;
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-cab">
		<thead>
			<tr>
				<th>ID</th>
				<th>TANGGAL</th>				
				<th>NAMA HARI LIBUR</th>				
				<th>STATUS</th>				
				<th>ACTION</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
<!-- /.table-responsive -->
<script>
    $(document).ready(function() {
        $('#dataTables-cab').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 25,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "ID_LIBUR" },
				{"mData": "TGL_AWAL" },
				{"mData": "NAMA_LIBUR" },			
				{"mData": "ISACTIVE" },			
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('libur/json_data');?>"
		});

		

    });	
	function ubahStatus(idx, sts){
			var pilih=confirm('Apakah data libur '+idx+ ' akan '+(sts=='1'?"dinon-aktifkan":"diaktifkan")+' ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('libur/ubahStatus');?>",
					data	: "idx="+idx+"&status="+sts,
					timeout	: 3000,  
					success	: function(res){
						//alert(res);
						alert("data berhasil "+(sts=='1'?"dinon-aktifkan":"diaktifkan"));
						window.location.reload();
						}
					
				});
			}
		}
</script>