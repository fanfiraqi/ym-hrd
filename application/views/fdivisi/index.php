<p><?php echo anchor('divisi/divCreate','Tambah Divisi',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>&nbsp;
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
			<th>ID INDUK</th>
				<th>NAMA_PARENT</th>
				<th>ID</th>
				<th>NAMA DIVISI</th>				
				<th>KETERANGAN</th>				
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
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "ID_DIV_PARENT" },
				{"mData": "NAMA_PARENT" },
				{"mData": "ID_DIV" },
				{"mData": "NAMA_DIV" },
				{"mData": "KETERANGAN" },				
				{"mData": "ISACTIVE" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('divisi/json_data');?>"
		});

		

    });
	
	function ubahStatus(idx, sts){
			var pilih=confirm('Apakah data divisi '+idx+ ' akan '+(sts=='1'?"dinon-aktifkan":"diaktifkan")+' ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('divisi/ubahStatus');?>",
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