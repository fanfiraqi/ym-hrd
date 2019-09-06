<?php errorHandler();?>
<?php echo form_open('jabatan/edit',array('class'=>'form-horizontal','id'=>'myform'));?>
<?php echo form_hidden('id',$row->id_jab);?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ID JABATAN</label>
			<div class="col-sm-8"><?=$row->id_jab;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA JABATAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control', 'value'=>$row->nama_jab ));?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">INDUK JABATAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama_induk','id'=>'nama_induk','class'=>'form-control', 'value'=>$row->parentname));?><input type="hidden" name="id_induk" id="id_induk" value="<?=$row->id_jab_parent?>"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">LAZ ATAU TASHARUF</label>
			<div class="col-sm-4"><?=form_dropdown('laz_tasharuf',array("LAZ"=>"LAZ/AMIL", "TASHARUF"=>"TASHARUF"),$row->laz_tasharuf,'id="laz_tasharuf" class="form-control"');?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KELOMPOK GAJI</label>
			<div class="col-sm-4"><?=form_dropdown('kelompok_gaji',array("S"=>"S", "M"=>"M", "GM"=>"GM"),$row->kelompok_gaji,'id="kelompok_gaji" class="form-control"');?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">BOBOT JABATAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'bobot','id'=>'bobot','class'=>'form-control', 'value'=>$row->bobot_jabatan));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">GOLONGAN</label>
			<div class="col-sm-8"><?=form_dropdown('golongan',$golongan,$row->golongan,'id="golongan" class="form-control"');?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KLASTER JABATAN</label>
			<div class="col-sm-8"><?=form_dropdown('klaster',$klaster,$row->klaster,'id="klaster" class="form-control"');?>	</div>
		</div>
	</div>
</div>



<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8"><?=form_dropdown('status',array('1'=>'Aktif','0'=>'Tidak Aktif'),$row->is_active,'id="status" class="form-control"');?>	</div>
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
	$(this).saveForm('<?php echo base_url('jabatan/edit');?>','<?php echo base_url('jabatan');?>');
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
		  		
	}
}); 

</script>