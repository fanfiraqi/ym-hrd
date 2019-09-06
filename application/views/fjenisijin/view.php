<?php errorHandler();
	$valDurasi=($row->REFF=="JATAHCUTI"?$row->VALUE1:$row->VALUE2);	//cek cuti tahunan
	$valNama=($row->REFF=="JATAHCUTI"?'CUTI TAHUNAN':$row->VALUE1);	//cek cuti tahunan
?>
<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">View Jenis Cuti</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ITEM CUTI </label>
			<div class="col-sm-8"> : <?=$valNama;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">DURASI</label>
			<div class="col-sm-8"> : <?=$valDurasi;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">SATUAN</label>
			<div class="col-sm-8"> : <?=$row->VALUE3;?></div>
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
					'onclick'=>"backTo('".base_url('jenisijin/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>