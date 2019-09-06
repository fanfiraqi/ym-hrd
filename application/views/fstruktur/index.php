<p><?php echo anchor('struktur/strukturCreate','Tambah Struktur',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>&nbsp;
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-cab">
		<thead>
			<tr>
				<th>KOTA</th>				
				<th>DIVISI</th>				
				<th>JABATAN</th>
				<th>KETERANGAN</th>
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
				{"mData": "KOTA" },
				{"mData": "DIVISI" },
				{"mData": "JABATAN" },
				{"mData": "KETERANGAN" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('struktur/json_data');?>"
		});

		

    });	
	function delStruktur(cab, divis, jab){
		//alert(cab+divis+jab);
			var pilih=confirm('Apakah data struktur ini akan dihapus ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('struktur/delStruktur');?>",
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