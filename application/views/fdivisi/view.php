<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">View Divisi</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ID DIVISI</label>
			<div class="col-sm-8"> : <?=$row->ID_DIV;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA DIVISI</label>
			<div class="col-sm-8"> : <?=$row->NAMA_DIV ;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">KETERANGAN</label>
			<div class="col-sm-8"> : <?=$row->KETERANGAN ;?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">INDUK DIVISI</label>
			<div class="col-sm-8"> : <?=$row->ID_DIV_PARENT." - ".$row->PARENTNAME;?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KODE LAMA</label>
			<div class="col-sm-8"> : <?=$row->ID_OLD ;?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8"> : <?=($row->IS_ACTIVE=="1"?"Aktif":"Tidak Aktif");?>
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
					'onclick'=>"backTo('".base_url('divisi/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>