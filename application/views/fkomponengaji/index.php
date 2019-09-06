<p><?php echo anchor('komponengaji/create','Tambah Komponen',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>ID</th>
				<th>NAMA KOMPONEN</th>				
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
			"aoColumns": [
				{"mData": "ID" },
				{"mData": "NAMA" },			
				{"mData": "KETERANGAN" },			
				{"mData": "ISACTIVE" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('komponengaji/json_data');?>"
		});

		

    });
	
	function ubahStatus(idx, sts){
			var pilih=confirm('Apakah data Komponen Gaji/Tunjangan Staff '+idx+ ' akan '+(sts=='1'?"dinon-aktifkan":"diaktifkan")+' ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('komponengaji/ubahStatus');?>",
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