<?php echo form_open('resign/'.$myurl,array('class'=>'form-horizontal','id'=>"myform"));?>
<div class="row">	
	<div class="col-md-12">
		<div class="panel panel-default card-view"><div class="panel-heading">DETIL INFORMASI PENGAJUAN RESIGN/PHK</div>
		<div class="panel-wrapper collapse in">
		<div class="panel-body">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
					<div class="col-sm-8"> : <?=$row->NIK." - ".$row->NAMA;?></div>
				</div>
			</div>
		</div>
			<div class="row">
				<div class="col-xs-12"> 
					<div class="form-group"><label class="col-sm-4 control-label">CABANG</label>
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
<?	if ($role==20 || $role==33) {?>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">REKOMENDATOR</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'rekomendator','id'=>'rekomendator','class'=>'form-control', 'value'=>$this->session->userdata('auth')->name));?></div>
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">CATATAN REKOMENDATOR</label>
						<div class="col-sm-8"><?=form_textarea(array('name'=>'rekom_note','id'=>'rekom_note','class'=>'form-control', 'value'=>$myurl));?>
						
						</div>
					</div>
				</div>
			</div>
<?	}else{ ?>
	<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENYETUJUI</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'rekomendator','id'=>'rekomendator','class'=>'form-control', 'value'=>$this->session->userdata('auth')->name));?></div>
					</div>
				</div>
			</div>
	<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">NO. SK</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'no_sk','id'=>'no_sk','class'=>'form-control'));?></div>
					</div>
				</div>
			</div>

<?	}	?>
	
		<div class="row">
				<div class="col-xs-12">
				<input type="hidden" name="id" id="id" value="<?php echo $id?>">
							<input type="hidden" name="role" id="role" value="<?php echo $role?>">
							<input type="hidden" name="stsR" id="stsR" value="<?php echo $stsR?>">
							<input type="hidden" name="stsApp" id="stsApp" value="<?php echo $stsApp?>">
							<input type="hidden" name="sts_rekom" id="sts_rekom" value="<?php echo $sts_rekom?>">
							<input type="hidden" name="sts_approve" id="sts_approve" value="<?php echo $sts_approve?>">
							<input type="hidden" name="myurl" id="myurl" value="<?php echo $myurl?>">
			</div>
		</div>

		</div>

		</div>
	</div>
	</div>
</div><?php echo form_close();?>
