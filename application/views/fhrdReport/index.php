<?php echo form_open('hrdReportPersonal/personalData',array('class'=>'form-horizontal','id'=>'myform'));?>
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
				<label for="nama" class="col-md-3  control-label">Ketik NIK/NAMA</label>	
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
					<input type="hidden" name="display" id="display" value="0">					
				</div>
			</div>			
		</div>

 <?php echo form_close();?>

<script type="text/javascript">

$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('employee_data/getPeg'); ?>",
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

