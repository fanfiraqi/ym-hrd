<?php errorHandler();?>
<?php echo form_open('jenisijin/edit',array('class'=>'form-horizontal','id'=>'myform'));
	$valDurasi=($row->REFF=="JATAHCUTI"?$row->VALUE1:$row->VALUE2);	//cek cuti tahunan
	$valNama=($row->REFF=="JATAHCUTI"?'CUTI TAHUNAN':$row->VALUE1);	//cek cuti tahunan
	$valReff=($row->REFF=="JATAHCUTI"?'JATAHCUTI':'CUTIKHUSUS');	//cek cuti tahunan
	$style=($row->REFF=="JATAHCUTI"?' disabled':'');	//cek cuti tahunan

?>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ITEM CUTI <?=($row->REFF=="JATAHCUTI"?"TAHUNAN":"KHUSUS")?></label>
			<div class="col-sm-8"><input type="text" name="nama" id="nama" class="form-control" <?=$style?> value="<?=$valNama?>"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">DURASI</label>

			<div class="col-sm-8"><?=form_input(array('name'=>'durasi','id'=>'durasi','class'=>'form-control', 'value'=>$valDurasi));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">SATUAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'satuan','id'=>'satuan','class'=>'form-control', 'value'=>$row->VALUE3));?></div>
		</div>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-6"><?=form_submit(array('name'=>'btsubmit','id'=>'btsubmit','value'=>'Simpan','class'=>'btn btn-primary')).form_hidden('id',$row->ID).form_hidden('reff',$valReff).form_hidden('id_ref',$row->ID_REFF) ;?> 
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
	$(this).saveForm('<?php echo base_url('jenisijin/edit');?>','<?php echo base_url('jenisijin');?>');
	event.preventDefault();
});


$(document).ready(function(){
});


</script>