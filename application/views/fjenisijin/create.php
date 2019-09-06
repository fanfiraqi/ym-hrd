<?php errorHandler();?>
<?php echo form_open('jenisijin/jenisijinCreate',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">	
		<label class="col-sm-4 control-label">*Hanya untuk penambahan CUTI KHUSUS</label><br>&nbsp;			
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ITEM CUTI KHUSUS</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">DURASI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'durasi','id'=>'durasi','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">SATUAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'satuan','id'=>'satuan','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-6"><?=form_submit(array('name'=>'btsubmit','id'=>'btsubmit','value'=>'Simpan','class'=>'btn btn-primary')).form_hidden('reff','CUTIKHUSUS').form_hidden('id_ref',$idref->JML) ;?> 
		<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Batal',
					'onclick'=>"backTo('".base_url('jenisijin/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>

<?php echo form_close();?>
<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('jenisijin/jenisijinCreate');?>','<?php echo base_url('jenisijin');?>');
	event.preventDefault();
});


$(document).ready(function(){
});

</script>
