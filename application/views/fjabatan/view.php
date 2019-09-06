<?php errorHandler();?>
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
		<div class="form-group"><label class="col-sm-4 control-label">ID JABATAN</label>
			<div class="col-sm-8"> : <?=$row->id_jab;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA JABATAN</label>
			<div class="col-sm-8"> : <?=$row->nama_jab ;?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">INDUK JABATAN</label>
			<div class="col-sm-8"> : <?=$row->id_jab_parent." - ".$row->parentname;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">LAZ ATAU TASHARUF</label>
			<div class="col-sm-4"><?php echo $row->laz_tasharuf;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KELOMPOK GAJI</label>
			<div class="col-sm-8"><?php echo $row->kelompok_gaji;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">BOBOT JABATAN</label>
			<div class="col-sm-8">: <?=$row->bobot_jabatan;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">GOLONGAN</label>
			<div class="col-sm-8">: <?=$row->golongan ?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KLASTER JABATAN</label>
			<div class="col-sm-8">: <?=$row->klaster;?>	</div>
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
					'onclick'=>"backTo('".base_url('jabatan/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>