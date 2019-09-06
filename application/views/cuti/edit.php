<?php errorHandler();?>
<?php echo form_open('cuti/edit',array('class'=>'form-horizontal','id'=>'myform'));
echo form_hidden('notrans',$row->NO_TRANS);
?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="nama" class="col-sm-4 control-label">Nama</label>
			<div class="col-sm-8">
				<?php
					$nama = array(
						'name'=>'nama',
						'id'=>'nama',
						'class'=>'form-control',
						'value'=>$row->NAMA
					);
					echo form_input($nama);
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="nik" class="col-sm-4 control-label">NIK</label>
			<div class="col-sm-8">
				<?php
					$nik = array(
						'name'=>'nik',
						'id'=>'nik',
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>$row->NIK
					);
					echo form_input($nik);
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Cabang</label>
			<div class="col-sm-8">
				<?php
					$cabang = array(
						'name'=>'cabang',
						'id'=>'cabang',
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>$rsmaster->NAMA_CABANG
					);
					echo form_input($cabang);
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="divisi" class="col-sm-4 control-label">Divisi</label>
			<div class="col-sm-8">
				<?php
					$divisi = array(
						'name'=>'divisi',
						'id'=>'divisi',
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>$rsmaster->NAMA_DIV
					);
					echo form_input($divisi);
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="cuti" class="col-sm-4 control-label">Jenis Ijin</label>
			<div class="col-sm-8">
				<?php
					echo form_dropdown('cuti',$cuti,$row->JENIS_CUTI,'id="cuti" class="form-control"');
				?>
			</div>
		</div>
	</div>
	<div class="col-md-6 <?php echo ($row->JENIS_CUTI=='1'?'no-display':'')?>" id="divsubcuti">
		<div class="form-group">
			<div class="col-sm-6">
				<?php
					echo form_dropdown('subcuti',$subcuti,$row->SUB_CUTI,'id="subcuti" class="form-control"');
				?>
				
			</div>
			<div class="col-sm-6 form-text" id="limitcuti"> 0 hari</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="tglawal" class="col-sm-4 control-label">Mulai Cuti</label>
			<div class="col-sm-8">
				<div class="input-group">
				<?php
					$tglawal = array(
						'name'=>'tglawal',
						'id'=>'tglawal',
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>revdate($row->TGL_AWAL)
					);
					echo form_input($tglawal);
				?>
				<div class="input-group-addon"><span id="bttglawal" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label for="tglakhir" class="col-sm-4 control-label">Sampai Dengan</label>
			<div class="col-sm-8">
			<div class="input-group">
				<?php
					$tglakhir = array(
						'name'=>'tglakhir',
						'id'=>'tglakhir',
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>revdate($row->TGL_AKHIR)
					);
					echo form_input($tglakhir);
				?>
				<div class="input-group-addon"><span id="bttglakhir" class="fa fa-calendar"></span></div>
			</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label for="jatah" class="col-sm-2 control-label " id="lbl_column1"><?php echo ($row->JENIS_CUTI=='1'?'Sisa Cuti Aktual':'Batas Max')?></label>
			<div class="col-sm-2">
				<?php
					$jatah = array(
						'name'=>'jatah',
						'id'=>'jatah',
						'value'=>0,
						'class'=>'form-control text-right',
						'readonly'=>'readonly',
						'value'=>($row->JENIS_CUTI=='1'?$jatahcuti:'0')
					);
					echo form_input($jatah); 
					echo form_hidden('ct',$jatahcuti);
					echo form_hidden('cl',$cutilembur);
				?>
			</div>
			<label for="jmlhari" class="col-sm-2 control-label">Jumlah Hari</label>
			<div class="col-sm-2">
				<?php
					$jmlhari = array(
						'name'=>'jmlhari',
						'id'=>'jmlhari',
						'value'=>0,
						'class'=>'form-control',
						'readonly'=>'readonly',
						'value'=>$row->JML_HARI
					);
					echo form_input($jmlhari);
				?>
			</div>
			<div id="ctthn_info" class="<?php echo ($row->JENIS_CUTI=='1'?'':'no-display')?>">

			<label for="sisacuti" class="col-sm-2 control-label" id="lbl_column2">Sisa Cuti</label>
			<div class="col-sm-2">
				<?php
					$sisacuti = array(
						'name'=>'sisacuti',
						'id'=>'sisacuti',
						'value'=>($row->JENIS_CUTI=='1'?$jatahcuti - $row->JML_HARI:'0'),
						'class'=>'form-control text-right',
						'readonly'=>'readonly'
					);
					echo form_input($sisacuti);
				?>
			</div>
			</div>

		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="keterangan" class="col-sm-4 control-label">Keterangan</label>
			<div class="col-sm-8">
				<?php
					$ket = array(
						'name'=>'keterangan',
						'id'=>'keterangan',
						'class'=>'form-control',
						'value'=>$row->KETERANGAN
					);
					echo form_textarea($ket);
				?>
			</div>
		</div>
	</div>
</div>
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
					'onclick'=>"backTo('".base_url('cuti/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>
	</div>
</div>
<?php echo form_close();?>
<script type="text/javascript">
 $(document).ready(function() {  
		 $("#btsubmit").attr("disabled", "disabled");
    });
	function calcday(){
		var jmlhari=0;
		if($( "#tglawal" ).val()=='' || $( "#tglakhir" ).val()=='') return false;
		
			$.ajax({
				url: "<?php echo base_url('cuti/calcday'); ?>",
				dataType: 'json',
				type: 'POST',
				data: {startdate:$( "#tglawal" ).val(),enddate:$( "#tglakhir" ).val(),nik:$( "#nik" ).val()},
				success:
				function(data){
					if(data.response =="true"){
						var jmlhari = parseInt(data.jmlhari);
						//alert(jmlhari);
						$('#jmlhari').val(jmlhari);		
						$('#jmlhari').trigger('change');
					}
				}
			});
		//}
	}
	
    $( "#tglawal" ).datepicker({
		minDate: 'today',
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			$( "#tglakhir" ).datepicker( "option", "minDate", selectedDate);
			$( "#tglaktif" ).datepicker( "setDate",selectedDate);
			calcday();
		}
	});
	$("#bttglawal").click(function() {
		$("#tglawal").datepicker("show");
	});
	
	$( "#tglakhir" ).datepicker({
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			//$( "#tglawal" ).datepicker( "option", "maxDate", selectedDate );
			calcday();
		}
	});
	$("#bttglakhir").click(function() {
		$("#tglakhir").datepicker("show");
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
				console.log(data);
				if(data.response =="true"){
					add(data.message);
					//$('#pesan').text('');
				}else{
					//$('#pesan').text(data.pesan);
				}
			}
		});
	},
	select:
	function(event, ui) {                   
		$("#nik").val(ui.item.id);  
		$("#jatah").val(ui.item.jatahcuti);
		$("#ct").val(ui.item.jatahcuti);
		$('#jmlhari').trigger('change');
		//$("#cl").val(ui.item.cutilembur);
		$("#pesan").text(ui.item.pesanTeks);

		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('employee_data/getLabelMaster');?>",
			data: { id_cabang: ui.item.id_cabang, id_div: ui.item.id_div, id_jab:ui.item.id_jab},				
			dataType: 'json',
			success: function(msg) {
				 console.log(msg);
				if(msg.status =='success'){
					$("#cabang").val(msg.data.NAMA_CABANG);
					$("#divisi").val(msg.data.NAMA_DIV);
					$("#jabatan").val(msg.data.NAMA_JAB);
									
				} else{
					bootbox.alert("Terjadi kesalahan. "+ msg.errormsg+". Gagal ambil data");				
					
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				bootbox.alert("Terjadi kesalahan. error."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});

		//calcday();
		if (ui.item.stsCutiOk=='FALSE')	{
			bootbox.alert("Jatah Cuti Tahunan Habis/Belum dapat jatah cuti tahunan");
			
			setJenisCuti();
		}else{
			$('#cuti').find('option').remove().end();
			$('#cuti').append('<option value="1" selected>CUTI TAHUNAN</option>');
			$('#cuti').append('<option value="2" >CUTI KHUSUS/IJIN</option>');
			$('#cuti').append('<option value="3" >SAKIT</option>');
			$('#cuti').trigger('change');
			//$('#subcuti').trigger('change');
			
		}
		
	}
}); 

function setJenisCuti(){
	$('#cuti').find('option').remove().end();
	$('#cuti').append('<option value="2" selected>CUTI KHUSUS/IJIN</option>');
	$('#cuti').append('<option value="3" >SAKIT</option>');
	$('#cuti').trigger('change');	
	$("#subcuti option[value='10']").attr('selected', 'selected');
	$('#jatah').val($('#jmlhari').val());
	

}
$('#jmlhari').change(function(){
	//alert(jQuery.type($("#jatah").val())=="undefined");
	var sisa=0;
	if (parseInt($("#jatah").val()) <=0 ||jQuery.type($("#jatah").val())=="undefined" ){
		sisa=0;
		$("#btsubmit").removeAttr("disabled");
	}else{
		if ( parseInt($(this).val()) > parseInt($("#jatah").val()) ){	
			bootbox.alert("Jumlah hari melewati sisa cuti aktual atau batas maximal "); 
			$("#btsubmit").attr("disabled", "disabled");
		}else{
			if ($('#cuti').val()==1){
				sisa=parseInt($("#jatah").val()) - parseInt($(this).val());
			}else{
				sisa=0;
			}
			
			$("#btsubmit").removeAttr("disabled");
		}
	}
	
	$('#sisacuti').val(sisa);
});

$('#cuti').change(function(){
	
	if ($(this).val()==2){
		$('#divsubcuti').removeClass('no-display');
		$('#ctthn_info').addClass('no-display');
		$('#lbl_column1').html('Batas Max ');
		$('#subcuti').trigger('change');
	} else {
		
		$('#divsubcuti').addClass('no-display');
		if ($(this).val()==1){
			$('#ctthn_info').removeClass('no-display');
			$("#jatah").val($('#ct').val());
			$('#lbl_column1').html('Sisa Cuti Aktual');
		} else {
			$('#ctthn_info').addClass('no-display');
			$('#lbl_column1').html('Jatah Max Ijin');
		}
	}
	calcday();
});



$('#subcuti').change(function(){
	var id = $(this).val();
	var value = 0;
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('cuti/getCutiVal');?>",
			data: { id: id},				
			dataType: 'json',
			success: function(msg) {
				 console.log(msg);
				if(msg.status =='success'){
					value=msg.value;						
					//vallimit=value;
					$('#limitcuti').html('Limit : '+value+' hari');
					$("#jatah").val(value);
					calcday();
					
				} else{
					//bootbox.alert("Terjadi kesalahan. "+ msg.errormsg+". Gagal ambil data");				
					value=0;					
				}

				$('#jmlhari').trigger('change');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				bootbox.alert("Terjadi kesalahan. error."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});
	
});

$('#myform').submit(function(event) {
	if ($('#sisacuti').val()<0 && $('#cuti').val()==1){
		bootbox.alert("SISA CUTI harus lebih besar dari 0"); return false;
	}
	$(this).saveForm('<?php echo base_url('cuti/edit');?>','<?php echo base_url('cuti');?>');
	event.preventDefault();
});


</script>