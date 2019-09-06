<?php errorHandler();?>
<!-- <?php echo form_open('lembur/edit',array('class'=>'form-horizontal','id'=>'myform'));?>
 --><div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="no_trans" class="col-sm-4 control-label">No Dokumen</label>
			<div class="col-sm-8">
				<?php
					$no_trans = array(
						'name'=>'no_trans',
						'id'=>'no_trans',
						'class'=>'form-control',
						'value'=>$row->NO_TRANS,
						'readonly'=>'readonly'
					);
					echo form_input($no_trans);
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="nama" class="col-sm-4 control-label">Nama</label>
			<div class="col-sm-8">
				<?php
					$nama = array(
						'name'=>'nama',
						'id'=>'nama',
						'class'=>'form-control',
						'value'=>$row->NAMA,
						'readonly'=>'readonly'
					);
					echo form_input($nama);
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="nik" class="col-sm-4 control-label">NIK</label>
			<div class="col-sm-8">
				<?php
					$nik = array(
						'name'=>'nik',
						'id'=>'nik',
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>$row->NIK
					);
					echo form_input($nik);
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Cabang</label>
			<div class="col-sm-8">
				<?php
					$cabang = array(
						'name'=>'cabang',
						'id'=>'cabang',
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>$rsmaster->NAMA_CABANG
					);
					echo form_input($cabang);
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="divisi" class="col-sm-4 control-label">Divisi</label>
			<div class="col-sm-8">
				<?php
					$divisi = array(
						'name'=>'divisi',
						'id'=>'divisi',
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>$rsmaster->NAMA_DIV
					);
					echo form_input($divisi);
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
<div class="table-responsive">
	<table class="table table-bordered" id="tblembur">
		<thead>
			<tr>
				<th rowspan="2" class="text-center" width="130">Tanggal Lembur</th>
				<th rowspan="2" class="text-center">Alasan Lembur</th>
				<th colspan="2" class="text-center">Waktu</th>
			</tr>
			<tr>
				<th class="text-center" width="200">Mulai</th>
				<th class="text-center" width="2q00">Selesai</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($rowd as $detail){ 
			$TANGGAL = revdate($detail->TGL_LEMBUR);
			$mulai = date("H.i",strtotime($detail->JAM_MULAI));
			$selesai = date("H.i",strtotime($detail->JAM_SELESAI));
		?>
			<tr>
				<td>
					<?php
						echo $TANGGAL;
					?>
				</td>
				<td>
					<?php
						echo $detail->KETERANGAN;
					?>
				</td>
				<td class="form-inline">
					<?php echo $mulai;?>
				</td>
				<td class="form-inline">
					<?php echo $selesai;?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
