<script type="text/javascript" src="<?php echo base_url('assets/js/ajaxfileupload.js');?>"></script>

<?php errorHandler();?>
<?php echo form_open('absensi/doupload',array('class'=>'form-horizontal','id'=>'myform','enctype'=>'multipart/form-data','accept-charset'=>'utf-8'));?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Cabang</label>
			<div class="col-sm-8">
				<?php
				if ($this->session->userdata('auth')->id_cabang=="1"){
					echo form_dropdown('cabang',$cabang,'','id="cabang" class="form-control" ');
				}else{
					echo '<input type="hidden" name="cabang" id ="cabang" value="'.$cabang->id_cabang.'"/>';
					echo '<label  class="col-sm-4 control-label">'.$cabang->kota.'</label>';
				}
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">BULAN</label>
					<div class="col-sm-8"><?=form_dropdown('cbBulan',$arrBulan,date('m'),'id="cbBulan" class="form-control"');?>
					</div>
				</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TAHUN</label>
					<div class="col-sm-8"><?=form_dropdown('cbTahun',$arrThn, date('Y'),'id="cbTahun" class="form-control"');?>
					</div>
				</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="xlsfile" class="col-sm-4 control-label">File Absensi</label>
			<div class="col-sm-8">
				<?php
					$xlsfile = array(
						'name'=>'xlsfile',
						'id'=>'xlsfile',
						//'class'=>'form-control',
						'type'=>'file'
					);
					echo form_input($xlsfile);
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<p>Pilih file CSV absensi dalam  <?php echo anchor('assets/files/template/templateAbsensi.csv','format','class="btn btn-primary btn-outline"');?>  yang telah ditentukan</p>
		<!-- <p>Pilih file CSV absensi dalam  <?php echo anchor('assets/files/template/absensi.csv','format','class="btn btn-primary btn-outline"');?>  yang telah ditentukan</p> -->
	</div>
</div><br><br>
<!-- <div id="output"></div> -->
<div class="row">
	<div class="col-md-6">
		
			<?php 
			$btsubmit = array(
					'name'=>'btsubmit',
					'id'=>'btsubmit',
					'value'=>'Upload',
					//'disabled'=>true,	//sementara tidak dipakai, edit-9 feb 2015
					'class'=>'btn btn-primary'
				);
			echo form_submit($btsubmit);?> 
			<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Batal',
					'onclick'=>"backTo('".base_url('absensi/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>
<?php echo form_close();?>
<script type="text/javascript">
$(function() {
    $('#myform').submit(function(e) {
        e.preventDefault();
		$().showMessage('Sedang diproses.. Harap tunggu..');
        $.ajaxFileUpload({
            url             :'<?php echo base_url('absensi/doupload');?>', 
            secureuri       :false,
            fileElementId   :'xlsfile',
            dataType        :'json',
            data            : {cabang:$('#cabang').val(), cbBulan:$('#cbBulan').val(), cbTahun:$('#cbTahun').val()},
            success : function (data)
            {	console.log(data);
				if(data.status == 'success')
                {	//$("#output").html(data);
                    $().showMessage('File berhasil di upload','success',2000);
                } else {
					$().showMessage(data.msg,'danger',2000);
				}
            }
        });
        return false;
    });
});
</script>