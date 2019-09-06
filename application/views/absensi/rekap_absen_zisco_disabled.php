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
		<th >JML IJIN (HARI)</th>  
		<th >JML SAKIT (HARI)</th>  
		<th >JML CUTI (HARI)</th> 
		<th >JML ALPA (HARI)</th>
		</tr>
		</thead>
		<tbody>
<? $i=1;
//echo "<tr><td colspan=8>".$strRes."</td></tr>";
if (sizeof($row)==0){		
	echo "<tr align=center><td colspan=20>Belum Ada Data Absensi</td></tr>";
}else{
	foreach($row_detil as $hasil){
	
	?>
	<tr >
	<td><?=$i?><input type="hidden" name="awal_jml_masuk_<?=$i?>" id="awal_jml_masuk_<?=$i?>" value="<?=$hasil->JML_MASUK?>"></td>
		<td><?=$hasil->NIK?></td>
	<td><?=str_replace(" ","&nbsp;",$hasil->NAMA)?><input type="hidden" name="nik_<?=$i?>" id="nik_<?=$i?>" value="<?=$hasil->NIK?>"></td>
	<td><?=form_input(array('name'=>'jml_masuk_'.$i,'id'=>'jml_masuk_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$hasil->JML_MASUK));?></td>
	<td><?=form_input(array('name'=>'jml_masuk_tidak_'.$i,'id'=>'jml_masuk_tidak_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$hasil->JML_TIDAK_MASUK));?></td>
	<td><?=form_input(array('name'=>'jml_sakit_'.$i,'id'=>'jml_sakit_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0, 'value'=>$hasil->JML_SAKIT));?></td>
	<td><?=form_input(array('name'=>'jml_cuti_'.$i,'id'=>'jml_cuti_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0, 'value'=>$hasil->JML_CUTI));?></td>
	<td><?=form_input(array('name'=>'jml_alpa_'.$i,'id'=>'jml_alpa_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$hasil->JML_ALPA, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	</tr>
	<?
		$i++;
	}
}	
?></tbody></table><?

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
		
	</div>
</div>
<script type="text/javascript">
$('#myTable').DataTable( {
	//"bJQueryUI": true,
	"scrollY": "500px",
	//"scrollX": true,
	"scrollCollapse": true,
	"paging": false, 
	"searching": false, 
	fixedColumns:   {
            leftColumns: 3
        },
    fixedHeader: true
} );
</script>