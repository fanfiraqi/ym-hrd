<?php echo form_open('absensi/rekap_list',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">	
	<div class="col-xs-12">
		<div class="panel panel-default"><div class="panel-heading">Pilih Kategori Cabang & Divisi
		</div><div class="panel-body">
		
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
					<div class="col-sm-8"><?php
						//form_dropdown('id_cabang',$cabang,'','id="id_cabang" class="form-control"');
						if ($this->session->userdata('auth')->id_cabang=="1"){
							echo form_dropdown('id_cabang',$cabang,'','id="id_cabang" class="form-control" ');
						}else{
							echo '<input type="hidden" name="id_cabang" id ="id_cabang" value="'.$cabang->id_cabang.'"/>';
							echo '<label  class="col-sm-4 control-label">'.$cabang->kota.'</label>';
						}
						?></div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group"><label  class="col-sm-4 control-label">BULAN</label>
					<div class="col-sm-8"><?=form_dropdown('cbBulan',$arrBulan,date('m'),'id="cbBulan" class="form-control"');?>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group"><label  class="col-sm-4 control-label">TAHUN</label>
					<div class="col-sm-8"><?=form_dropdown('cbTahun',$arrThn, date('Y'),'id="cbTahun" class="form-control"');?></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group"><label  class="col-sm-4 control-label">Pilihan Data</label>
					<div class="col-sm-8"><?=form_dropdown('opsi',array("Fingerprint"=>"Fingerprint", "Entri"=>"Entri Form"), '','id="opsi" class="form-control"');?></div>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-6">
		
			<?php 
			$btsubmit = array(
					'name'=>'btsubmit',
					'id'=>'btsubmit',
					'value'=>'Lanjutkan',
					'class'=>'btn btn-primary'
				);
			echo form_submit($btsubmit);?> 
			

	</div>
</div>
<?php echo form_close();?>
<script type="text/javascript">


</script>

