<?php errorHandler();?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
			<div class="col-sm-8"> : <?=$row->NIK." - ".$row->NAMA;?></div>
		</div>
	</div>
</div>
<div class="row">	
	<div class="col-md-6">
		<div class="panel panel-default"><div class="panel-heading">DETIL INFORMASI PENGAJUAN RESIGN/PHK
		</div><div class="panel-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
						<div class="col-sm-8"> : <?=$rsmaster->NAMA_CABANG;?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">DIVISI TERAKHIR</label>
						<div class="col-sm-8"> : <?=$rsmaster->NAMA_DIV;?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">JABATAN TERAKHIR</label>
						<div class="col-sm-8"> : <?=$rsmaster->NAMA_JAB;?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL RESIGN</label>
						<div class="col-sm-8"> : <?=revdate($row->TGL);?></div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">ALASAN RESIGN</label>
						<div class="col-sm-8"> : <?=$row->ALASAN;?></div>
					</div>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENGETAHUI</label>
						<div class="col-sm-8"> : <?=$row->MENGETAHUI;?></div>
					</div>
				</div>
			</div> -->
			

		</div></div>
	</div>
</div><br>	<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Kembali',
					'onclick'=>"backTo('".base_url('resign/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>