<?php errorHandler();?>
<?php echo form_open(null,array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<label for="nama" class="col-sm-6 control-label">Jumlah Per Angsuran</label>
			<div class="col-sm-6">&nbsp;:&nbsp;Rp. <?=number_format(($rowHead->JUMLAH)/($rowHead->LAMA),2,',','.')?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			<label for="nama" class="col-sm-6 control-label">Angsuran Ke</label>
			<div class="col-sm-3">&nbsp;:&nbsp;<?=$rowAngs->jml_ke?></div>
		</div>
	</div>
</div>
<!-- <div class="row" >
	<div class="col-md-8">
		<div class="form-group"><label class="col-sm-6 control-label">Pelunasan Via</label>
			<div class="col-sm-6"><?php	echo form_dropdown('accvia',$accvia,'','id="accvia" class="form-control"');
				?></div>
		</div>
	</div>
</div> -->
<div class="row">
	<div class="col-md-8">
		<div class="form-group"><label  class="col-sm-6 control-label">TANGGAL PINJAMAN</label>
			<div class="col-sm-6">
			<div class="input-group">
			<?=form_input(array('name'=>'tanggal','id'=>'tanggal','class'=>'form-control', 'value'=>$rowHead->TGL));?>
			<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
			<input type="hidden" name="data-id" id="data-id" value="<?=$rowHead->ID?>">
			<input type="hidden" name="data-url" id="data-url" value="<?=base_url('angsuran/saveAngsuran').'/'.$rowHead->ID?>">
			<input type="hidden" name="data-base" id="data-base" value="<?=base_url()?>">
			<input type="hidden" name="cicil_ke" id="cicil_ke" value="<?=$rowAngs->jml_ke?>">
			</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close();?>

