<?php errorHandler();?>
<?php echo form_open('jabatan/jabCreate',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA JABATAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">INDUK JABATAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama_induk','id'=>'nama_induk','class'=>'typeahead form-control'));?><input type="hidden" name="id_induk" id="id_induk">*Ketik Nama JABATAN</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">LAZ ATAU TASHARUF</label>
			<div class="col-sm-4"><?=form_dropdown('laz_tasharuf',array("LAZ"=>"LAZ/AMIL", "TASHARUF"=>"TASHARUF"),'','id="laz_tasharuf" class="form-control"');?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KELOMPOK GAJI</label>
			<div class="col-sm-4"><?=form_dropdown('kelompok_gaji',array("S"=>"S", "M"=>"M", "GM"=>"GM"),'','id="kelompok_gaji" class="form-control"');?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">BOBOT JABATAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'bobot','id'=>'bobot','class'=>'typeahead form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">GOLONGAN</label>
			<div class="col-sm-8"><?=form_dropdown('golongan',$golongan,'','id="golongan" class="form-control"');?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KLASTER JABATAN</label>
			<div class="col-sm-8"><?=form_dropdown('klaster',$klaster,'','id="klaster" class="form-control"');?>	</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-4"><?=form_dropdown('status',array('1'=>'Aktif','0'=>'Tidak Aktif'),'','id="status" class="form-control"');?>	</div>
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
					'onclick'=>"backTo('".base_url('jabatan/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>

<?php echo form_close();?>
<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('jabatan/jabCreate');?>','<?php echo base_url('jabatan');?>');
	event.preventDefault();
});


$(document).ready(function(){
});


$("#nama_induk").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('jabatan/cariJabatan'); ?>",
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
