<div class="panel panel-default card-view">
								<div class="panel-heading">
									<div class="pull-left">
										<h6 class="panel-title txt-dark">View Data Cuti</h6>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="nama" class="col-sm-4 control-label">Nama</label>
			<div class="col-sm-8">&nbsp;:&nbsp;<?=$row->NAMA?></div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label for="nik" class="col-sm-4 control-label">NIK</label>
			<div class="col-sm-8">&nbsp;:&nbsp;<?=$row->NIK?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Cabang</label>
			<div class="col-sm-8">&nbsp;:&nbsp;<?=$rsmaster->NAMA_CABANG?>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label for="divisi" class="col-sm-4 control-label">Divisi</label>
			<div class="col-sm-8">&nbsp;:&nbsp;<?=$rsmaster->NAMA_DIV?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="cuti" class="col-sm-4 control-label">Jenis Ijin</label>
			<div class="col-sm-8">&nbsp;:&nbsp;<?=$row->JENISCUTI1." - ".$row->JENISCUTI2?>
			</div>
		</div>
	</div>
	<div class="col-md-12 no-display" id="divsubcuti">
		<div class="form-group">
			<div class="col-sm-6">&nbsp;:&nbsp;<?=$row->SUB_CUTI?></div>
			<div class="col-sm-6 form-text" id="limitcuti"> 3 hari</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="tglawal" class="col-sm-4 control-label">Mulai Cuti</label>
			<div class="col-sm-8">
				<div class="input-group">&nbsp;:&nbsp;<?=revdate($row->TGL_AWAL)?>				
			</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="form-group">
			<label for="tglakhir" class="col-sm-4 control-label">Sampai Dengan</label>
			<div class="col-sm-8">
			<div class="input-group">&nbsp;:&nbsp;<?=revdate($row->TGL_AKHIR)?>				
			</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">			
			<label for="jmlhari" class="col-sm-4 control-label">Jumlah Hari</label>
			<div class="col-sm-2">&nbsp;:&nbsp;<?=$row->JML_HARI?>
			</div>			
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
			<div class="col-sm-8">&nbsp;:&nbsp;<?=$row->KETERANGAN?>
			</div>
		</div>
	</div>
</div>
	</div>
	</div>
</div>
