<?php if ($status!="")	errorHandler(); ?>
<?php echo form_open('pengguna/userCreate',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">USERNAME</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'username','id'=>'username','class'=>'form-control'));?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">PASSWORD</label>
			<div class="col-sm-8"><?=form_password(array('name'=>'password','id'=>'password','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NIK</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nik','id'=>'nik','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">ROLE AKSES</label>
			<div class="col-sm-8">
				<?php $data = array('Operator HRD'=>'Operator HRD', 'Manager HRD'=>'Manager HRD','Direktur HRD'=>'Direktur HRD','Operator ZIS'=>'Operator ZIS','Manager Keuangan'=>' Manager Keuangan','Direktur Keuangan'=>'Direktur Keuangan','Admin'=>'Admin Program');
					echo form_dropdown('role',$data,'','id="role" class="form-control"');
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8">
				<?php $data = array('1'=>'Aktif', '0'=>'Tidak Aktif');
					echo form_dropdown('status',$data,'','id="status" class="form-control"');
				?>
			</div>
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
					'onclick'=>"backTo('".base_url('pengguna/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>

<?php echo form_close();?>
<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('pengguna/userCreate');?>','<?php echo base_url('pengguna');?>');
	event.preventDefault();
});


$(document).ready(function(){
});

</script>
