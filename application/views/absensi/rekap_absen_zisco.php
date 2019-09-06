<?php echo form_open('absensi/rekap_save_zisco',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row"><!-- HEADER -->
	<div class=".col-lg-8" >
		<div class="panel panel-default"> 
		<div class="panel-heading">Form Rekap Absensi Zisco</div>
		<div class="panel-body" > 
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">PERIODE </label>
						<div class="col-sm-8"><?=form_input(array('name'=>'strperiode','id'=>'strperiode', 'class'=>'form-control','value'=>$strBulan." ".$thn));?><input type="hidden" name="periode" id="periode" value="<?=$thn.$digitBln?>"></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">START DATE </label>
						<div class="col-sm-8"><?=form_input(array('name'=>'mindate','id'=>'mindate', 'class'=>'myform-control','value'=>$start_date));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">END DATE </label>
						<div class="col-sm-4"><?=form_input(array('name'=>'maxdate','id'=>'maxdate', 'class'=>'myform-control','value'=>$end_date));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">JUMLAH HARI EFEKTIF</label>
						<div class="col-sm-8"><?=form_input(array('name'=>'jmlefektif','id'=>'jmlefektif', 'class'=>'myform-control','value'=>$jmlhari));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">JUMLAH LIBUR NASIONAL </label>
						<div class="col-sm-8"><?=form_input(array('name'=>'jml_libnas','id'=>'jml_libnas', 'class'=>'myform-control','value'=>$libnas));?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="form-group"><label class="col-sm-4 control-label">JUMLAH HARI KERJA </label>
						<div class="col-sm-8"><?=form_input(array('name'=>'jml_harikerja','id'=>'jml_harikerja', 'class'=>'myform-control','value'=>$jmlHariKerja));?></div>
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
//echo "<tr><td colspan=8>".$sCek."%%".$cek->CEK."</td></tr>";
if (sizeof($row)==0){		
	echo "<tr align=center><td colspan=20>Belum Ada Data Absensi</td></tr>";
}else{
	foreach($row as $hasil){
		
		
	?>
	<tr >
	<td><?=$i?><input type="hidden" name="awal_jml_masuk_<?=$i?>" id="awal_jml_masuk_<?=$i?>" value="<?=$jmlHariKerja?>"></td>
	<td><?=$hasil->NIK?></td>
	<td><?=str_replace(" ","&nbsp;",$hasil->NAMA)?><input type="hidden" name="nik_<?=$i?>" id="nik_<?=$i?>" value="<?=$hasil->NIK?>"></td>
	<td><?=form_input(array('name'=>'jml_masuk_'.$i,'id'=>'jml_masuk_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$jmlHariKerja));?></td>
	<td><?=form_input(array('name'=>'jml_masuk_tidak_'.$i,'id'=>'jml_masuk_tidak_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	<td><?=form_input(array('name'=>'jml_sakit_'.$i,'id'=>'jml_sakit_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	<td><?=form_input(array('name'=>'jml_cuti_'.$i,'id'=>'jml_cuti_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	<td><?=form_input(array('name'=>'jml_alpa_'.$i,'id'=>'jml_alpa_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	
	</tr>
	<?
		$i++;
	}
}	
?></tbody></table><?

 	if (sizeof($row)>0){ ?>
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="jmlRow" id="jmlRow" value="<?=($i-1)?>">										
										<input type="hidden" name="bln" id="bln" value="<?=$digitBln?>">										
										<input type="hidden" name="thn" id="thn" value="<?=$thn?>">		
										<input type="hidden" name="id_cabang" id="id_cabang" value="<?=$id_cabang?>">	
										<!-- <input type="hidden" name="id_divisi" id="id_divisi" value="<?=$id_divisi?>"> -->	
											<?php 
											$btsubmit = array(
													'name'=>'btsubmit',
													'id'=>'btsubmit',
													'value'=>'Simpan',
													'class'=>'btn btn-primary'
												);
											echo form_submit($btsubmit);
										

								?> 
									</div>
								</div>
						<?}else{
								$btback = array(
												'name'=>'btback',
												'id'=>'btback',
												'content'=>'Kembali',
												'onclick'=>"backTo('".base_url('absensi/rekapAbsen')."');return false;",
												'class'=>'btn btn-danger'
											);
										echo "<div style=\"text-align:center\">".form_button($btback)."</div>";			
											
						}
						
						
						
						?>
		
	</div>
</div>
<?php echo form_close();?>
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
$('#myform').submit(function(event) {
	$(this).saveForm('<?php echo base_url('absensi/rekap_save_zisco');?>','<?php echo base_url('absensi/rekapAbsenzisco');?>');
	event.preventDefault();
});

function setJmlMasuk(obj, idk){		
	//update total
	$('#jml_masuk_'+idk).val( parseFloat($('#jml_harikerja').val())-( parseFloat( $('#jml_masuk_tidak_'+idk).val() ) + parseFloat( $('#jml_alpa_'+idk).val() )  + parseFloat( $('#jml_sakit_'+idk).val() )  + parseFloat( $('#jml_cuti_'+idk).val() ) ));
}
</script>