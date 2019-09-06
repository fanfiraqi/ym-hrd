<p><?php echo anchor('cabang/cabangCreate','Tambah Cabang',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>&nbsp;
 <div class="row" >
	<div class="col-xs-12">
	<table class="table table-striped table-bordered table-hover" id="dataTables-cab">
		<thead>
			<tr>
				<th>ID</th>
				<th>KOTA</th>				
				<th>KODE</th>				
				<th>ALAMAT</th>
				<th>TELEPON</th>
				<th>STATUS</th>
				<th>ACTION</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
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
				{"mData": "ID_CABANG" },
				{"mData": "KOTA" },
				{"mData": "KODE" },
				{"mData": "ALAMAT" },
				{"mData": "TELEPON" },
				{"mData": "IS_ACTIVE" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('cabang/json_data');?>"
		});

		

    });	
	function ubahStatus(idx, sts){
			var pilih=confirm('Apakah data cabang '+idx+ ' akan '+(sts=='1'?"dinon-aktifkan":"diaktifkan")+' ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('cabang/ubahStatus');?>",
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