<?php errorHandler();?>
<?php echo form_open('divisi/divCreate',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA DIVISI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">KETERANGAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'keterangan','id'=>'keterangan','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">INDUK DIVISI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama_induk','id'=>'nama_induk','class'=>'form-control'));?><input type="hidden" name="id_induk" id="id_induk">*Ketik Nama Divisi</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KODE LAMA</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'id_lama','id'=>'id_lama','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8"><?=form_dropdown('status',array('1'=>'Aktif','0'=>'Tidak Aktif'),'','id="status" class="form-control"');?>	</div>
		</div>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-6">
		
			<?php 
			$btsubmit = array(
					'name'=>'btsubmit',
					'id'=>'btsubmit',
					'value'=>'Simpan',
					'class'=>'btn btn-primary'
				);
			echo form_submit($btsubmit);?> 
			<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Batal',
					'onclick'=>"backTo('".base_url('divisi/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>

<?php echo form_close();?>
<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('divisi/divCreate');?>','<?php echo base_url('divisi');?>');
	event.preventDefault();
});


$(document).ready(function(){
});


$("#nama_induk").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('divisi/cariDivisi'); ?>",
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
		$("#id_induk").val(ui.item.id);  		
		//$("#id_lama").val(ui.item.id);  		
		//$("#nama_induk").val(ui.item.nama_div);  		
	}
}); 

</script>
