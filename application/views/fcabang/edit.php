<?php if ($status!="")	errorHandler(); ?>
<?php echo form_open('cabang/edit',array('class'=>'form-horizontal','id'=>'myform'));?>
<?php echo form_hidden('id',$row->id_cabang);?>

<div class="row">
	<div class="col-md-10">
		<div class="form-group"><label class="col-sm-4 control-label">ID</label>
			<div class="col-sm-8"><?=$row->id_cabang?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-10">
		<div class="form-group"><label  class="col-sm-4 control-label">KOTA</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'kota','id'=>'kota','class'=>'form-control', 'value'=>$row->kota));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-10">
		<div class="form-group"><label  class="col-sm-4 control-label">KODE</label>
			<div class="col-sm-4"><?=form_input(array('name'=>'kode','id'=>'kode','class'=>'form-control', 'value'=>$row->kode));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-10">
		<div class="form-group"><label class="col-sm-4 control-label">ALAMAT</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'alamat','id'=>'alamat','class'=>'form-control', 'value'=>$row->alamat));?>	</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-10">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">TELEPON</label>
			<div class="col-sm-8">
				<?=form_input(array('name'=>'telepon','id'=>'telepon','class'=>'form-control', 'value'=>$row->telepon));?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-10">
		<div class="form-group"><label class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8"><?=form_dropdown('status',array('1'=>'Aktif','0'=>'Tidak Aktif'),$row->is_active,'id="status" class="form-control"');?>	</div>
		</div>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-10">
		
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
					'onclick'=>"backTo('".base_url('cabang/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>


<?php echo form_close();?>

<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('cabang/edit');?>','<?php echo base_url('cabang');?>');
	event.preventDefault();
});


$(document).ready(function(){
});


</script>