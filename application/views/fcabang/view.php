<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">View Cabang</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ID</label>
			<div class="col-sm-8"> : <?=$row->id_cabang;?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">KOTA</label>
			<div class="col-sm-8"> : <?=$row->kota?> </div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">KODE</label>
			<div class="col-sm-8"> : <?=$row->kode;?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ALAMAT</label>
			<div class="col-sm-8"> : <?=$row->alamat;?>	</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">TELEPON</label>
			<div class="col-sm-8"> : <?=$row->telepon;?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8"> : <?=($row->is_active=="1"?"Aktif":"Tidak Aktif");?>
			</div>
		</div>
	</div>
</div>
</div>
								</div>
							</div>
<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Kembali',
					'onclick'=>"backTo('".base_url('cabang/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>