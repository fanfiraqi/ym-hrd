<?php errorHandler();?>
<?php echo form_open('pinjaman/create',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control'));?><input type="hidden" name="nik" id="nik">*Jika tidak ditemukan nama/nik yang dicari berarti status masih ada pinjaman belum lunas</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">JUMLAH PINJAMAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'jumlah','id'=>'jumlah','class'=>'form-control','onkeypress'=>"return numericVal(this,event)", 'onblur'=>"blurObj(this)",'onclick'=>"clickObj(this)", "value"=>0));?> *Angka saja</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">LAMA PINJAMAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'lama','id'=>'lama','class'=>'form-control'));?> x ANGSURAN</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL PINJAMAN</label>
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
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KEPERLUAN</label>
			<div class="col-sm-8"><?=form_textarea(array('name'=>'keperluan','id'=>'keperluan','class'=>'form-control'));?>	</div>
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
			echo form_submit($btsubmit)."&nbsp;";
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Batal',
					'onclick'=>"backTo('".base_url('pinjaman/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?> 

	</div>
</div>

<?php echo form_close();?>
<script type="text/javascript">
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('pinjaman/create');?>','<?php echo base_url('pinjaman');?>');
	event.preventDefault();
});


$(document).ready(function(){
});
  
$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('pinjaman/getPegawai'); ?>",
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
			
	}
}); 
$( "#tanggal" ).datepicker({
		//minDate: 'today',
		dateFormat: 'yy-mm-dd',
		onSelect: function( selectedDate ) {
			
		}
	});
	$("#bttglawal").click(function() {
		$("#tanggal").datepicker("show");
	});
</script>
