<?php echo form_open('hrdReportRekapHRD/rekapResultMap',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
			<div class="col-md-8">
				<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
					<div class="col-sm-8"><?php
				if ($this->session->userdata('auth')->id_cabang=="1"){
					echo form_dropdown('cabang',$cabang,'','id="cabang" class="form-control" ');
				}else{
					echo '<input type="hidden" name="cabang" id ="cabang" value="'.$cabang->id_cabang.'"/>';
					echo '<label  class="col-sm-4 control-label">'.$cabang->kota.'</label>';
				}
				?></div>
				</div>
			</div>
		</div>
	<div class="row">
			<div class="col-md-8">
				<div class="form-group"><label  class="col-sm-4 control-label">JENIS DATA</label>
					<div class="col-sm-8"><?=form_dropdown('cbJenis',$options, '','id="cbJenis" class="form-control"');?></div>
				</div>
			</div>
	</div>
	<div class="row">
			<div class="col-md-8">
				<div class="form-group"><label  class="col-sm-4 control-label">BULAN</label>
					<div class="col-sm-8"><?=form_dropdown('cbBulan',$arrBulan,date('m'),'id="cbBulan" class="form-control"');?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="form-group"><label  class="col-sm-4 control-label">TAHUN</label>
					<div class="col-sm-8"><?=form_dropdown('cbTahun',$arrThn, date('Y'),'id="cbTahun" class="form-control"');?>
					<input type="hidden" name="display" id="display" value="0">	
					</div>
				</div>
			</div>
		</div>
<div class="row">
	<div class="col-md-8">
	<div class="form-group"><label  class="col-sm-4 control-label">&nbsp;</label><div class="col-sm-8">
		<?
		$btsubmit = array(
			'name'=>'btLanjut',
			'id'=>'btLanjut',
			'value'=>'Lanjutkan',					
			'class'=>'btn btn-primary'
			);
		echo form_submit($btsubmit);?> </div>
		</div>
	</div>
</div>
 <?php echo form_close();?>