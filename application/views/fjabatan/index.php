<p><?php echo anchor('jabatan/jabCreate','Tambah jabatan',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>&nbsp;
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				
				<th>ID</th>
				<th>NAMA JABATAN</th>								
				<th>GOLONGAN</th>
				<th>KLASTER</th>
				<th>BOBOT</th>
				<th>ID INDUK</th>
				<th>NAMA INDUK</th>
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
        $('#dataTables-example').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 25,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [				
				{"mData": "ID_JAB" },
				{"mData": "NAMA_JAB" },		
				{"mData": "GOLONGAN" },
				{"mData": "KLASTER" },
				{"mData": "BOBOT_JABATAN" },
				{"mData": "ID_JAB_PARENT" },
				{"mData": "NAMA_PARENT" },
				{"mData": "IS_ACTIVE" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('jabatan/json_data');?>"
		});

		

    });
	
	function ubahStatus(idx, sts){
			var pilih=confirm('Apakah data jabatan '+idx+ ' akan '+(sts=='1'?"dinon-aktifkan":"diaktifkan")+' ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('jabatan/ubahStatus');?>",
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