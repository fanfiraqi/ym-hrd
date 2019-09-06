<?php errorHandler();?>
<?php echo form_open('prestasi/edit',array('class'=>'form-horizontal','id'=>'myform'));?>
<?php echo form_hidden('id',$row->ID);?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control', 'value'=>$row->NAMA));?><input type="hidden" name="nik" id="nik" value="<?=$row->NIK?>"></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'cabang','id'=>'cabang','readonly'=>'true','class'=>'form-control', 'value'=>$row->KOTA));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">DIVISI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'divisi','id'=>'divisi','readonly'=>'true','class'=>'form-control', 'value'=>$row->NAMA_DIV));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">JABATAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'jabatan','id'=>'jabatan','readonly'=>'true','class'=>'form-control', 'value'=>$row->NAMA_JAB));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL PRESTASI</label>
			<div class="col-sm-8">
			<div class="input-group">
			<?=form_input(array('name'=>'tanggal','id'=>'tanggal','class'=>'form-control', 'value'=>$row->TANGGAL));?>
			<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">PRESTASI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'prestasi','id'=>'prestasi','class'=>'form-control', 'value'=>$row->NAMA_PRESTASI));?>	</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KETERANGAN</label>
			<div class="col-sm-8"><?=form_textarea(array('name'=>'keterangan','id'=>'keterangan','class'=>'form-control', 'value'=>$row->KETERANGAN));?>	</div>
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
					'onclick'=>"backTo('".base_url('prestasi/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>


<?php echo form_close();?>

<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('prestasi/edit');?>','<?php echo base_url('prestasi');?>');
	event.preventDefault();
});


$(document).ready(function(){
});
  
$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('cuti/lookupemp'); ?>",
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
		$("#cabang").val(ui.item.cabang);
		$("#divisi").val(ui.item.divisi);
		$("#jabatan").val(ui.item.jabatan);
		
	}
}); 
$( "#tanggal" ).datepicker({
		minDate: 'today',
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			
		}
	});
	$("#bttglawal").click(function() {
		$("#tanggal").datepicker("show");
	});

</script>