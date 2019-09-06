<?php echo form_open('absensi/rekap_save',array('class'=>'form-horizontal','id'=>'myform'));?>
<div class="row"><!-- HEADER -->
	<div class="col-lg-8" >
		<div class="panel panel-default"> 
		<div class="panel-heading">Form Rekap Absensi</div>

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
<div class="alert alert-success">
<ol><li>Form ini untuk entri absensi rekap sebulan untuk cabang yang tidak memakai fingerprint</li>
<ol><li>Entrian/edit di kolom Jumlah masuk dan jumlah alpa akan saling menghitung/otomatis (menyesuaikan dengan inputan lainnya)</li>

</ol>
</div>
<div class="row"><!-- DETAIL -->
	<div class="col-lg-12">
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
//echo "<tr><td colspan=8>".$sCek."%%".$cek->CEK."</td></tr>";
if (sizeof($row)==0){		
	echo "<tr align=center><td colspan=20>Belum Ada Data Absensi</td></tr>";
}else{
	foreach($row as $hasil){
		//lembur
		$strlembur="SELECT NIK, SUM( JML_JAM ) J_JAM , substr( l.no_trans, 1, 6 ) FROM `lembur` l, lembur_d d WHERE l.approved=1 and l.no_trans=d.no_trans and nik = '".$hasil->NIK."' AND d.tgl_lembur like '".$thn.'-'.$digitBln."%' GROUP BY nik";
		$jml_lembur=0;
		if ($this->db->query($strlembur)->num_rows()){
			$rsLembur=$this->db->query($strlembur)->row();
			$jml_lembur=$rsLembur->J_JAM;
		}else{
			$jml_lembur=0;
		}
		//$hrLembur=floor($jml_lembur>=7?$jml_lembur/7:0);
		
		//GET ABSEN VALUE
		//hari kerja ambil dari database
			$jml_ijin=0;
			$jml_sakit=0;
			
			//$scuti="select jml_hari jml_cuti from cuti where approved=1 and '".$thn.$digitBln."' and nik='".$hasil->NIK."' and jenis_cuti = 1";	//cuti tahunan	//tidak dihitung 
			$sijin="select ifnull(jml_hari,0) jml_ijin from cuti where approved=1 and '".$thn.$digitBln."' and nik='".$hasil->NIK."' and jenis_cuti = 2 and sub_cuti >4";	//ijin  khusus yg jml hari < 10	
			if ($this->db->query($sijin)->num_rows()>0){
				$rsIjin=$this->db->query($sijin)->row();				
				$jml_ijin=$rsIjin->jml_ijin;
			}
			$ssakit="select ifnull(jml_hari,0) jml_sakit from cuti where approved=1 and '".$thn.$digitBln."' and nik='".$hasil->NIK."' and jenis_cuti = 3";	//sakit
			$rsSakit=$this->db->query($ssakit)->row();
			if ($this->db->query($ssakit)->num_rows()>0){
				$rsSakit=$this->db->query($ssakit)->row();				
				$jml_sakit=$rsSakit->jml_sakit;
			}
			
	?>
	<tr >
	<td><?=$i?><input type="hidden" name="awal_jml_masuk_<?=$i?>" id="awal_jml_masuk_<?=$i?>" value="<?=$jmlHariKerja?>" readonly></td>
	<td><?=$hasil->NIK?><input type="hidden" name="awal_alpa_<?=$i?>" id="awal_alpa_<?=$i?>" value="0"></td>
	<td><?=str_replace(" ","&nbsp;",$hasil->NAMA)?><input type="hidden" name="nik_<?=$i?>" id="nik_<?=$i?>" value="<?=$hasil->NIK?>"></td>
	<td><?=form_input(array('name'=>'jml_masuk_'.$i,'id'=>'jml_masuk_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$jmlHariKerja, "readonly"=>true));?></td>
	<td><?=form_input(array('name'=>'cuti_'.$i,'id'=>'cuti_'.$i,'class'=>'myform-control','size'=>10,  'value'=>0, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	<td><?=form_input(array('name'=>'ijin_'.$i,'id'=>'ijin_'.$i,'class'=>'myform-control','size'=>10,  'value'=>$jml_ijin, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	<td><?=form_input(array('name'=>'sakit_'.$i,'id'=>'sakit_'.$i,'class'=>'myform-control','size'=>10,  'value'=>$jml_sakit, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	<td><?=form_input(array('name'=>'t101_'.$i,'id'=>'t101_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0));?></td>
	<td><?=form_input(array('name'=>'t102_'.$i,'id'=>'t102_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0));?></td>
	<td><?=form_input(array('name'=>'t103_'.$i,'id'=>'t103_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0));?></td>
	<td><?=form_input(array('name'=>'pc_hari_'.$i,'id'=>'pc_hari_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0));?></td>	
	<td><?=form_input(array('name'=>'pc_menit_'.$i,'id'=>'pc_menit_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0));?></td>	
	<td><?=form_input(array('name'=>'lembur_'.$i,'id'=>'lembur_'.$i,'class'=>'myform-control','size'=>10,  'value'=>$jml_lembur));?></td>	
	<td><?=form_input(array('name'=>'alpa_'.$i,'id'=>'alpa_'.$i,'class'=>'myform-control','size'=>10, 'value'=>0, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	</tr>
	<?
		$i++;
	}
}	
?>
</tbody>
</table>
	
	</div>

	</div>
</div>
<?

 	if (sizeof($row)>0){ ?>
								<div class="row">
									<div class="col-md-12">
										<input type="hidden" name="jmlRow" id="jmlRow" value="<?=($i-1)?>">										
										<input type="hidden" name="bln" id="bln" value="<?=$digitBln?>">										
										<input type="hidden" name="thn" id="thn" value="<?=$thn?>">		
										<input type="hidden" name="id_cabang" id="id_cabang" value="<?=$id_cabang?>">	
										
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

<?php echo form_close();?>
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
    var jmlmasuk=parseFloat($('#jml_harikerja').val())-(parseFloat(obj.value)+parseFloat($('#cuti_'+idk).val())+parseFloat($('#ijin_'+idk).val())+parseFloat($('#sakit_'+idk).val() ) );
	//update total
		$('#jml_masuk_'+idk).val(jmlmasuk);
	//setJmlMasuk(obj, idk);

}
function setJmlMasuk(obj, idk){		
	//update total
	$('#jml_masuk_'+idk).val( parseFloat($('#jml_harikerja').val())-(parseFloat($('#alpa_'+idk).val())+parseFloat($('#cuti_'+idk).val())+parseFloat($('#ijin_'+idk).val())+parseFloat($('#sakit_'+idk).val())) );
	//setAlpa(obj, idk);

}
</script>