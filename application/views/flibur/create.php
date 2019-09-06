<?php errorHandler();?>
<?php echo form_open('libur/liburCreate',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="alert alert-success">
Untuk Hari libur yang lebih dari satu, ditambahkan satu persatu tanggal liburnya dengan Memakai Nama Hari Libur yang sama
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA HARI LIBUR</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL LIBUR</label>
			<div class="col-sm-8">
			<div class="input-group">
			<?=form_input(array('name'=>'tgl_awal','id'=>'tgl_awal','class'=>'form-control'));?>
			<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8"><?=form_dropdown('status',array('1'=>'Aktif','0'=>'Tidak Aktif'),'','id="status" class="form-control"');?>	</div>
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
					'onclick'=>"backTo('".base_url('libur/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>

<?php echo form_close();?>
<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('libur/liburCreate');?>','<?php echo base_url('libur');?>');
	event.preventDefault();
});
$( "#tgl_awal" ).datepicker({
		/*minDate: 'today',*/
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {			
			//calcday();
		}
	});
	$("#bttglawal").click(function() {
		$("#tgl_awal").datepicker("show");
	});
	


$(document).ready(function(){
});

</script>
