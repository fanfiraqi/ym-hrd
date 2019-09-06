<div class="row"><!-- HEADER -->
	<div class=".col-lg-8" >
		<div class="panel panel-default"> 
		<div class="panel-heading">Form Rekap Absensi</div>
		<div class="panel-body" > 
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">PERIODE </label>
						<div class="col-sm-8"><?=form_input(array('name'=>'strperiode','id'=>'strperiode','readonly'=>true,'class'=>'form-control','value'=>$strBulan." ".$thn));?><input type="hidden" name="periode" id="periode" value="<?=$thn.$digitBln?>"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">START DATE </label>
						<div class="col-sm-8"><?=form_input(array('name'=>'mindate','id'=>'mindate','readonly'=>true,'class'=>'myform-control','value'=>$start_date));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">END DATE </label>
						<div class="col-sm-4"><?=form_input(array('name'=>'maxdate','id'=>'maxdate','readonly'=>true,'class'=>'myform-control','value'=>$end_date));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">JUMLAH HARI EFEKTIF</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'jmlefektif','id'=>'jmlefektif','readonly'=>true,'class'=>'myform-control','value'=>$jmlhari));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">JUMLAH LIBUR NASIONAL </label>
						<div class="col-sm-8"><?=form_input(array('name'=>'jml_libnas','id'=>'jml_libnas','readonly'=>true,'class'=>'myform-control','value'=>$libnas));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">JUMLAH HARI KERJA </label>
						<div class="col-sm-8"><?=form_input(array('name'=>'jml_harikerja','id'=>'jml_harikerja','readonly'=>true,'class'=>'myform-control','value'=>$jmlHariKerja));?></div>
					</div>
				</div>
			</div>

		</div>
		</div>
	</div>
</div>
<div class="alert alert-success">
<ol><li>Jml Hari Masuk default ambil dari csv absensi atau dari rekap absensi yang sudah tersimpan
<li>Jml Hari Masuk dan Alpa editable untuk koreksi manual oleh manager jika ada karyawan yg tidak absen melalui fingerprint
<li>Jml cuti dan lembur diambil dari proses permohonan cuti/ijin yang sudah diapprove saja dan masih bisa diedit

</ol>
</div>

<div class="row"><!-- DETAIL -->
	<div class=".col-lg-12" >
	<div class="table-responsive">
		<table class="table table-striped table-bordered  table-hover" style="max-height:650px;overflow:scroll;" id="myTable">
        <thead>
        <tr >
		<th >NO</th>
		<th >NIK</th>
		<th >NAMA</th>
		<th >JML MASUK (HARI)</th>                            
		<th >CUTI(HARI)</th>                            
		<th >IJIN (HARI)</th>                            
		<th >SAKIT (HARI)</th>                            
		<th >T.10 PERTAMA</th>                            
		<th >T.10 KEDUA</th>                            
		<th >T.10 KETIGA</th>
		<th >PLG CEPAT (HARI)</th>
		<th >PLG CEPAT (MENIT)</th>
		<th >LEMBUR (JAM)</th>
        <th >JML ALPA</th>
		</tr>
		</thead>
		<tbody>
<? $i=1;
//echo "<tr><td colspan=8>".$strRes."</td></tr>";
if (sizeof($row)==0){		
	echo "<tr align=center><td colspan=20>Belum Ada Data Absensi</td></tr>";
}else{
	foreach($row_detil as $hasil){
		

		//hari kerja ambil dari database
		$jmlmasuk=$hasil->JML_MASUK;
		$alpa=$hasil->JML_ALPA;
		$jml_cuti=$hasil->JML_CUTI;
		$jml_lembur=$hasil->JAM_LEMBUR;
				
		//echo "<tr><td colspan=8>".$hrLembur."#".$skerja."</td></tr>";
	?>
	<tr >
	<td><?=$i?><input type="hidden" name="awal_jml_masuk_<?=$i?>" id="awal_jml_masuk_<?=$i?>" value="<?=$hasil->JML_MASUK?>"></td>
		<td><?=$hasil->NIK?><input type="hidden" name="awal_alpa_<?=$i?>" id="awal_alpa_<?=$i?>" value="<?=$hasil->JML_ALPA?>"></td>
	<td><?=str_replace(" ","&nbsp;",$hasil->NAMA)?><input type="hidden" name="nik_<?=$i?>" id="nik_<?=$i?>" value="<?=$hasil->NIK?>"></td>
	<td><?=form_input(array('name'=>'jml_masuk_'.$i,'id'=>'jml_masuk_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$hasil->JML_MASUK, 'onchange'=>"setAlpa(this, '$i')"));?></td>
	<td><?=form_input(array('name'=>'cuti_'.$i,'id'=>'cuti_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$hasil->JML_CUTI));?></td>
	<td><?=form_input(array('name'=>'ijin_'.$i,'id'=>'ijin_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$hasil->JML_IJIN));?></td>
	<td><?=form_input(array('name'=>'sakit_'.$i,'id'=>'sakit_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$hasil->JML_SAKIT));?></td>
	<td><?=form_input(array('name'=>'t101_'.$i,'id'=>'t101_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$hasil->T10_1));?></td>
	<td><?=form_input(array('name'=>'t102_'.$i,'id'=>'t102_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$hasil->T10_2));?></td>
	<td><?=form_input(array('name'=>'t103_'.$i,'id'=>'t103_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$hasil->T10_3));?></td>
	<td><?=form_input(array('name'=>'pc_hari_'.$i,'id'=>'pc_hari_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$hasil->PULANG_AWAL_JML));?></td>	
	<td><?=form_input(array('name'=>'pc_menit_'.$i,'id'=>'pc_menit_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$hasil->PULANG_AWAL_MENIT));?></td>	
	<td><?=form_input(array('name'=>'lembur_'.$i,'id'=>'lembur_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$hasil->JAM_LEMBUR));?></td>	
	<td><?=form_input(array('name'=>'alpa_'.$i,'id'=>'alpa_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$hasil->JML_ALPA, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	</tr>
	<?
		$i++;
	}
}	
?></table><?

 	if (sizeof($row_detil)>0){ ?>
								<div class="row">
									<div class="col-md-6">
										<input type="hidden" name="jmlRow" id="jmlRow" value="<?=($i-1)?>">										
										<input type="hidden" name="bln" id="bln" value="<?=$digitBln?>">										
										<input type="hidden" name="thn" id="thn" value="<?=$thn?>">		
										<input type="hidden" name="id_cabang" id="id_cabang" value="<?=$id_cabang?>">	
											
											<?php 
												$btback = array(
														'name'=>'btback',
														'id'=>'btback',
														'content'=>'Kembali',
														'onclick'=>"backTo('".base_url('absensi/rekapAbsen')."');return false;",
														'class'=>'btn btn-danger'
													);
												echo form_button($btback);?>
									</div>
								</div>
						<?}?>
		</tbody>
	</div>
</div>
<script type="text/javascript">
$('#myTable').DataTable( {
	//"bJQueryUI": true,
	"scrollY": "500px",
	"scrollX": true,
	"scrollCollapse": true,
	"paging": false, 
	"searching": false, 
	fixedColumns:   {
            leftColumns: 3
        },
    fixedHeader: true
} );
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('absensi/rekap_save');?>','<?php echo base_url('absensi/rekapAbsen');?>');
	event.preventDefault();
});

function setAlpa(obj, idk){		
	//update total
	$('#alpa_'+idk).val( parseFloat($('#jml_harikerja').val())-(parseFloat(obj.value)+parseFloat($('#cuti_'+idk).val())));
}
function setJmlMasuk(obj, idk){		
	//update total
	$('#jml_masuk_'+idk).val( parseFloat($('#jml_harikerja').val())-(parseFloat(obj.value)+parseFloat($('#cuti_'+idk).val())));
}
</script>