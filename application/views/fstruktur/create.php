<?php errorHandler();?>
<?php echo form_open('struktur/strukturCreate',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
			<div class="col-sm-8"><?=form_dropdown('id_cabang',$cabang,'','id="id_cabang" class="form-control"');?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">DIVISI</label>
			<div class="col-sm-8"><?=form_dropdown('id_divisi',$divisi,'','id="id_divisi" class="form-control"');?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">JABATAN</label>
			<div class="col-sm-8"><?=form_dropdown('id_jabatan',$jabatan,'','id="id_jabatan" class="form-control"');?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KETERANGAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'keterangan','id'=>'keterangan','class'=>'form-control'));?>	</div>
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
					'value'=>'Simpan',
					'class'=>'btn btn-primary'
				);
			echo form_submit($btsubmit);?>
				<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Batal',
					'onclick'=>"backTo('".base_url('struktur/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>

<?php echo form_close();?>
<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('struktur/strukturCreate');?>','<?php echo base_url('struktur');?>');
	event.preventDefault();
});

$('#id_divisi').change(function(){
	//alert($('#id_cabang').val());
	$.ajax({
		url: "<?php echo base_url('struktur/cekDivisi'); ?>",
		dataType: 'json',
		type: 'POST',
		data: {id_divisi:$(this).val(), id_cabang:$('#id_cabang').val()},
		success: function(respon){
			//alert(respon.boleh);
			$('#btsubmit').attr('disabled',false);
			if (respon.boleh==0){
				alert('Divisi "'+respon.child+'" mempunyai level induk "'+respon.parent+'" yang belum ada di master struktur pada cabang ini. Silahkan di Add terlebih dulu level induknya');
				$('#btsubmit').attr('disabled',true);
			}
			
		}
	});
	
});


$(document).ready(function(){
});

</script>
