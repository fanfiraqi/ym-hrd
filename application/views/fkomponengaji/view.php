<?php errorHandler();?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ID</label>
			<div class="col-sm-8"> : <?=$row->ID;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA KOMPONEN</label>
			<div class="col-sm-8"> : <?=$row->NAMA;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">KETERANGAN</label>
			<div class="col-sm-8"> : <?=$row->KETERANGAN;?>	</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8"> : <?=($row->ISACTIVE=="1"?"Aktif":"Tidak Aktif");?>	</div>
		</div>
	</div>
</div><br><?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Kembali',
					'onclick'=>"backTo('".base_url('komponengaji/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
