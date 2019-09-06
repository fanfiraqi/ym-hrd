<?php errorHandler();?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
			<div class="col-sm-8"> : <?=$row->NAMA;?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">JUMLAH PINJAMAN</label>
			<div class="col-sm-8"> : Rp. <?=number_format($row->JUMLAH,2,',','.');?> </div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">LAMA PINJAMAN</label>
			<div class="col-sm-8"> : <?=$row->LAMA;?> x ANGSURAN</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL PINJAMAN</label>
			<div class="col-sm-8"> : <?=$row->TGL;?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KEPERLUAN</label>
			<div class="col-sm-8"> : <?=$row->KEPERLUAN;?>	</div>
		</div>
	</div>
</div><br><?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Kembali',
					'onclick'=>"backTo('".base_url('pinjaman/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
