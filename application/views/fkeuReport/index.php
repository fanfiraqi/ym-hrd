<ul class="nav nav-tabs" id="myTab">
  <li><a href="#termin1" data-toggle="tab">PINJAMAN PERORANGAN</a></li>
  <li><a href="#termin2" data-toggle="tab">REKAP ALL PINJAMAN</a></li>
</ul>

<div class="tab-content">
  <div class="tab-pane" id="termin1">
<?php echo form_open('keuReportLoan/personalLoan',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="alert alert-success">
<ol><li>Jika tidak ditemukan nama/nik yang dicari berarti Karyawan belum pernah melakukan pinjaman
<li>Data Pinjaman yang ditampilkan adalah pinjaman terakhir
</ol>
</div>

		<div class="row">
			<div class="col-md-12">

			<label for="nama" class="col-md-1"></label>	
				<div class="form-group">
				<label for="nama" class="col-md-2  control-label">Ketik NIK/NAMA</label>	
						<div class="col-sm-4">
							<?php
							$nama = array(
								'name'=>'nama',
								'id'=>'nama',
								'class'=>'form-control'
							);
							echo form_input($nama);
						?></div>
						<div class="col-sm-4">
						<?
						$btsubmit = array(
								'name'=>'btLanjut',
								'id'=>'btLanjut',
								'value'=>'Lanjutkan',					
								'class'=>'btn btn-primary'
							);
						echo form_submit($btsubmit);?> 
						</div>
					<input type="hidden" name="nik" id="nik">					
					<input type="hidden" name="display1" id="display1" value="0">					
				</div>
			</div>			
		</div>

 <?php echo form_close();?>

</div><!-- / tab termin1 -->

<div class="tab-pane" id="termin2">
<?php echo form_open('keuReportLoan/rekapLoan',array('class'=>'form-horizontal','id'=>'myform2'));?>
<div class="row">
			<div class="col-md-12">
				<label for="nama" class="col-md-1"></label>	
				<div class="form-group">
				<label for="nama" class="col-md-2  control-label">Status Pinjaman</label>	
						<div class="col-sm-4">
							<?php
							$option = array(
								'Belum Lunas'=>'Belum Lunas',
								'Lunas'=>'Lunas'
							);
							echo form_dropdown('jns_status',$option,'','id="jns_status" class="form-control"');
						?></div>
						<div class="col-sm-4">
						<?
						$btsubmit = array(
								'name'=>'btOk',
								'id'=>'btOk',
								'value'=>'Lanjutkan',					
								'class'=>'btn btn-primary'
							);
						echo form_submit($btsubmit);?> 
						</div>								
					<input type="hidden" name="display2" id="display2" value="0">					
				</div>
			</div>			
		</div>
<?php echo form_close();?>

</div> <!-- // tab 2 -->

</div>	<!-- tab head -->




<script type="text/javascript">
$(document).ready(function(){
	$('#myTab a:first').tab('show');

});
$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('keuReportLoan/getPegawai'); ?>",
			dataType: 'json',
			type: 'POST',
			data: req,
			success:   
			function(data){
				if(data.response =="true"){
					add(data.message);
				}
			}
		});
	},
	select:
	function(event, ui) {    
		//alert(ui.item.id);
		$("#nik").val(ui.item.id); 	
		
	}
}); 


</script>

