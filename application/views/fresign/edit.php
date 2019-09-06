<?php errorHandler();?>
<?php echo form_open('resign/edit',array('class'=>'form-horizontal','id'=>'myform'));?>
<?php echo form_hidden('id',$row->ID);?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control', 'value'=>$row->NAMA, 'readonly'=>true));?><input type="hidden" name="nik" id="nik" value="<?=$row->NIK?>"></div>
		</div>
	</div>
</div>
<div class="row">	
	<div class="col-md-6">
		<div class="panel panel-default"><div class="panel-heading">DETIL INFORMASI RESIGN
		</div><div class="panel-body">
			<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
							<div class="col-xs-8"> : <?=$rsmaster->NAMA_CABANG?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">DIVISI TERAKHIR</label>
							<div class="col-xs-8"> : <?=$rsmaster->NAMA_DIV?></div>
						</div>	
					</div>					
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">JABATAN TERAKHIR</label>
							<div class="col-xs-8"> : <?=$rsmaster->NAMA_JAB?></div>
						</div>	
					</div>	
				</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL RESIGN</label>
						<div class="col-sm-8">
						<div class="input-group">
						<?=form_input(array('name'=>'tanggal','id'=>'tanggal','class'=>'form-control', 'value'=>$row->TGL));?>
						<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">ALASAN RESIGN</label>
						<div class="col-sm-8"><?=form_textarea(array('name'=>'keterangan','id'=>'keterangan','class'=>'form-control','value'=>$row->ALASAN));?></div>
					</div>
				</div>
			</div>
			<!-- <div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENGETAHUI</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'mengetahui','id'=>'mengetahui','class'=>'form-control','value'=>$row->MENGETAHUI));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENYETUJUI</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'menyetujui','id'=>'menyetujui','class'=>'form-control','value'=>$row->MENYETUJUI));?></div>
					</div>
				</div>
			</div>
 -->
		</div></div>
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
					'onclick'=>"backTo('".base_url('resign/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>


<?php echo form_close();?>

<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('resign/edit');?>','<?php echo base_url('resign');?>');
	event.preventDefault();
});


$(document).ready(function(){
});
  
$( "#tanggal" ).datepicker({
		/*minDate: 'today',*/
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			
		}
	});
	$("#bttglawal").click(function() {
		$("#tanggal").datepicker("show");
	});

$('#id_divisi').change(function(){
	$.ajax({
		url: "<?php echo base_url('employee/comboJabByDiv'); ?>",
		dataType: 'json',
		type: 'POST',
		data: {divisi:$(this).val()},
		success: function(respon){
			$('#id_jabatan').find('option').remove().end();
			if (respon.status==1){
				var item = respon.data;
				for (opt=0;opt<item.length;opt++){
					$('#id_jabatan').append('<option value="'+item[opt].ID_JAB+'">'+item[opt].NAMA_JAB+'</option>');
				}
			}
		}
	});
}).trigger('change');

</script>