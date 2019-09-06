<?php errorHandler();?>
<?php echo form_open('mutasi/edit',array('class'=>'form-horizontal','id'=>'myform'));?>
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
		<div class="panel panel-default"><div class="panel-heading">PROSES MUTASI EDIT
		</div><div class="panel-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
						<div class="col-sm-8"><?=form_dropdown('id_cabang',$cabang,$row->ID_CAB,'id="id_cabang" class="form-control"');?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">DIVISI</label>
						<div class="col-sm-8"><?=form_dropdown('id_divisi',$divisi,$row->ID_DIV,'id="id_divisi" class="form-control"');?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">JABATAN</label>
						<div class="col-sm-8"><?=form_dropdown('id_jabatan',$jabatan,$row->ID_JAB,'id="id_jabatan" class="form-control"');?></div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL PENETAPAN</label>
						<div class="col-sm-8">
						<div class="input-group">
						<?=form_input(array('name'=>'tanggal','id'=>'tanggal','class'=>'form-control', 'value'=>$row->TGL_PENETAPAN));?>
						<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">KETERANGAN MUTASI</label>
						<div class="col-sm-8"><?=form_textarea(array('name'=>'keterangan','id'=>'keterangan','class'=>'form-control','value'=>$row->KETERANGAN));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENGETAHUI</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'mengetahui','id'=>'mengetahui','class'=>'form-control','value'=>$row->MENGETAHUI));?>
						<input type="hidden" name="nik_mengetahui" id="nik_mengetahui" value="<?php echo $row->NIK_MENGETAHUI?>"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENYETUJUI</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'menyetujui','id'=>'menyetujui','class'=>'form-control','value'=>$row->MENYETUJUI));?>
						<input type="hidden" name="nik_mengetahui" id="nik_mengetahui" value="<?php echo $row->NIK_MENYETUJUI?>">
						</div>
					</div>
				</div>
			</div>			
		</div></div><!-- panel body panel -->

	</div> 

	<div class="col-md-6">
		<div class="panel panel-default"><div class="panel-heading">POSISI LAMA
		</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
							<div class="col-xs-8"><?=form_input(array('name'=>'cabang','id'=>'cabang','readonly'=>'true','class'=>'form-control','value'=>$rsold->OLDCAB));?>
							<input type="hidden" name="old_id_cab" id="old_id_cab" VALUE="<?=$row->OLD_ID_CAB?>"></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">DIVISI</label>
							<div class="col-xs-8"><?=form_input(array('name'=>'divisi','id'=>'divisi','readonly'=>'true','class'=>'form-control','value'=>$rsold->OLDDIV));?>
							<input type="hidden" name="old_id_div" id="old_id_div" VALUE="<?=$row->OLD_ID_DIV?>">
							</div>
						</div>	
					</div>					
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">JABATAN</label>
							<div class="col-xs-8"><?=form_input(array('name'=>'jabatan','id'=>'jabatan','readonly'=>'true','class'=>'form-control','value'=>$rsold->OLDJAB));?>
							<input type="hidden" name="old_id_jab" id="old_id_jab" VALUE="<?=$row->OLD_ID_JAB?>">
							</div>
						</div>	
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
					'value'=>'Simpan',
					'class'=>'btn btn-primary'
				);
			echo form_submit($btsubmit);?>  
				<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Batal',
					'onclick'=>"backTo('".base_url('mutasi/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>


<?php echo form_close();?>

<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('mutasi/edit');?>','<?php echo base_url('mutasi');?>');
	event.preventDefault();
});


$(document).ready(function(){

	$('#id_cabang').change(function(){
	$.ajax({
		url: "<?php echo base_url('employee/comboDivByCab'); ?>",
		dataType: 'json',
		type: 'POST',
		data: {cabang:$(this).val()},
		success: function(respon){
			$('#id_divisi').find('option').remove().end();
			if (respon.status==1){
				var item = respon.data;
				console.log('respon.data',respon.data.ID_DIV);
				for (opt=0;opt<item.length;opt++){
					$('#id_divisi').append('<option value="'+item[opt].ID_DIV+'" '+(item[opt].ID_DIV==<?=$row->ID_DIV?>?' selected':'')+'>'+item[opt].NAMA_DIV+'</option>');
				}
				}
				$('#id_divisi').trigger('change');
			}
		});
	}).trigger('change');

	$('#id_divisi').change(function(){
		$.ajax({
			url: "<?php echo base_url('employee/comboJabByDiv'); ?>",
			dataType: 'json',
			type: 'POST',
			data: {cabang:$('#id_cabang').val(),divisi:$(this).val()},
			success: function(respon){
				$('#id_jabatan').find('option').remove().end();
				if (respon.status==1){
					var item = respon.data;
					for (opt=0;opt<item.length;opt++){
						$('#id_jabatan').append('<option value="'+item[opt].ID_JAB+'"  '+(item[opt].ID_JAB==<?=$row->ID_JAB?>?' selected':'')+'>'+item[opt].NAMA_JAB+'</option>');
					}
				}
			}
		});
	}).trigger('change');


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


$("#menyetujui").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('mutasi/getPegawai'); ?>",
			dataType: 'json',
			type: 'POST',
			data: req,
			success:   
			function(data){
				if(data.response =="true"){
					add(data.message);
				}
			}
		});
	},
	select:
	function(event, ui) {                   
		$("#nik_menyetujui").val(ui.item.id);  
		 
			
	}
}); 
$("#mengetahui").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('mutasi/getPegawai'); ?>",
			dataType: 'json',
			type: 'POST',
			data: req,
			success:   
			function(data){
				if(data.response =="true"){
					add(data.message);
				}
			}
		});
	},
	select:
	function(event, ui) {                   
		$("#nik_mengetahui").val(ui.item.id);  
		 
			
	}
}); 

</script>