<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">View Data Tanggal Libur</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ID</label>
			<div class="col-sm-8"><?=$row->ID_LIBUR?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA HARI LIBUR</label>
			<div class="col-sm-8"> : <?=$row->NAMA_LIBUR;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL LIBUR</label>
			<div class="col-sm-8">: <?=revdate($row->TGL_AWAL);?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8"> : <?=($row->ISACTIVE=="1"?"Aktif":"Tidak Aktif");?></div>
		</div>
	</div>
</div>
		</div>
	</div>
</div><br>
	<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Kembali',
					'onclick'=>"backTo('".base_url('libur/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
