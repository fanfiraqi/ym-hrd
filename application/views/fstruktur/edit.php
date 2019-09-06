<?php errorHandler();?>
<?php echo form_open('struktur/edit',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KOTA/CABANG</label>
			<div class="col-sm-8"><?=form_dropdown('id_cabang',$cabang,$row->ID_CAB,'id="id_cabang" class="form-control"');?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">DIVISI</label>
			<div class="col-sm-8"><?=form_dropdown('id_divisi',$divisi,$row->ID_DIV,'id="id_divisi" class="form-control"');?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">JABATAN</label>
			<div class="col-sm-8"><?=form_dropdown('id_jabatan',$jabatan,$row->ID_JAB,'id="id_jabatan" class="form-control"');?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KETERANGAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'keterangan','id'=>'keterangan','class'=>'form-control', 'value'=>$row->KETERANGAN));?>	</div>
		</div>
	</div>
</div>

<hr />
<div class="row">
	<div class="col-md-6">
		<INPUT TYPE="HIDDEN" name="oldCab" id="oldCab" value="<?=$row->ID_CAB?>">
		<INPUT TYPE="HIDDEN" name="oldDiv" id="oldCab" value="<?=$row->ID_DIV?>">
		<INPUT TYPE="HIDDEN" name="oldJab" id="oldCab" value="<?=$row->ID_JAB?>">
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
					'onclick'=>"backTo('".base_url('struktur/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>


<?php echo form_close();?>

<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('struktur/edit');?>','<?php echo base_url('struktur');?>');
	event.preventDefault();
});


$(document).ready(function(){
});


</script>