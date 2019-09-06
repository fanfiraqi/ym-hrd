<?php errorHandler();?>
<?php echo form_open('resign/create',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA/NIK KARYAWAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control'));?><input type="hidden" name="nik" id="nik"></div>
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
							<div class="col-xs-8"><input type="hidden" name="id_cabang" id="id_cabang"><?=form_input(array('name'=>'cabang','id'=>'cabang','readonly'=>'true','class'=>'form-control'));?></div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">DIVISI TERAKHIR</label>
							<div class="col-xs-8"><?=form_input(array('name'=>'divisi','id'=>'divisi','readonly'=>'true','class'=>'form-control'));?></div>
						</div>	
					</div>					
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">JABATAN TERAKHIR</label>
							<div class="col-xs-8"><?=form_input(array('name'=>'jabatan','id'=>'jabatan','readonly'=>'true','class'=>'form-control'));?></div>
						</div>	
					</div>	
				</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL RESIGN</label>
						<div class="col-sm-8">
						<div class="input-group">
						<?=form_input(array('name'=>'tanggal','id'=>'tanggal','class'=>'form-control'));?>
						<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">ALASAN RESIGN/PHK</label>
						<div class="col-sm-8"><?=form_textarea(array('name'=>'keterangan','id'=>'keterangan','class'=>'form-control'));?></div>
					</div>
				</div>
			</div>
		<!-- 	<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENGETAHUI</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'mengetahui','id'=>'mengetahui','class'=>'form-control'));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENYETUJUI</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'menyetujui','id'=>'menyetujui','class'=>'form-control'));?></div>
					</div>
				</div>
			</div> -->

		</div></div>
	</div>
	
</div>
<hr />
<div class="row">
	<div class="col-xs-12">		
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
	$(this).saveForm('<?php echo base_url('resign/create');?>','<?php echo base_url('resign');?>');
	event.preventDefault();
});


$(document).ready(function(){
});
  
$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('resign/getPosition'); ?>",
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
		$("#nik").val(ui.item.id);  
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('employee_data/getLabelMaster');?>",
			data: { id_cabang: ui.item.id_cabang, id_div: ui.item.id_div, id_jab:ui.item.id_jab},				
			dataType: 'json',
			success: function(msg) {
				 console.log(msg);
				if(msg.status =='success'){
					$("#cabang").val(msg.data.NAMA_CABANG);
					$("#id_cabang").val(ui.item.id_cabang);
					$("#divisi").val(msg.data.NAMA_DIV);
					$("#jabatan").val(msg.data.NAMA_JAB);
					//alert($("#id_cabang").val());
				} else{
					bootbox.alert("Terjadi kesalahan. "+ msg.errormsg+". Gagal ambil data");				
					
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				bootbox.alert("Terjadi kesalahan. error."+	textStatus + " - " + errorThrown );
			},
			cache: false
		}); 
			
	}
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
