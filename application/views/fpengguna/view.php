<?php errorHandler();?>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">USERNAME</label>
			<div class="col-sm-8"> : <?=$row->USERNAME?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">PASSWORD</label>
			<div class="col-sm-8"> : *** </div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NIK</label>
			<div class="col-sm-8"> : <?=$row->NIK;?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ROLE AKSES</label>
			<div class="col-sm-8"> : <?=$row->ROLE;?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8"> : <?=($row->ISACTIVE=="1"?"Aktif":"Tidak Aktif");?>
			</div>
		</div>
	</div>
</div>
<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Kembali',
					'onclick'=>"backTo('".base_url('pengguna/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>