<p><?php echo anchor('jenisijin/jenisijinCreate','Tambah Cuti Khusus',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>&nbsp;
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-cab">
		<thead>
			<tr>
				<th>ID</th>				
				<th>KELOMPOK</th>				
				<th>JENIS</th>				
				<th>DURASI</th>
				<th>SATUAN</th>
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
				{"mData": "ID" },
				{"mData": "REFF" },
				{"mData": "VALUE1" },
				{"mData": "VALUE2" },
				{"mData": "VALUE3" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('jenisijin/json_data');?>"
		});

		

    });	
	function deljenisijin(cab, divis, jab){
		//alert(cab+divis+jab);
			var pilih=confirm('Apakah data Jenis Ijin/Sakit ini akan dihapus ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('jenisijin/deljenisijin');?>",
					data	: "id_cab="+cab+"&id_div="+divis+"&id_jab="+jab,
					timeout	: 3000,  
					success	: function(res){
						//alert(res);
						alert("data berhasil dihapus");
						window.location.reload();
						}
					
				});
			}
		}
</script>