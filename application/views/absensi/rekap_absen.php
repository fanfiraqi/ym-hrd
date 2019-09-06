<?php echo form_open('absensi/rekap_save',array('class'=>'form-horizontal','id'=>'myform'));?>
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
<li>Jml Hari Masuk dan Alpa editable untuk koreksi manual oleh manager jika ada karyawan yangg tidak absen melalui fingerprint
<li>Jml cuti dan lembur diambil dari proses permohonan cuti/ijin yang sudah diapprove saja dan masih bisa diedit

</ol>
</div>

<div class="row" ><!-- DETAIL -->
	<div class="col-lg-12" >
	<div class="table-responsive" >
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
		
		//cuti tahunan 
		$strcuti="SELECT NIK, SUM( JML_HARI ) HR_CUTI , SUBSTR( no_trans, 1, 6 ), jenis_cuti, tgl_awal, tgl_akhir, jml_hari
					FROM `cuti`
					WHERE jenis_cuti=1 and tgl_awal BETWEEN '$start_date' AND '$end_date' and tgl_akhir BETWEEN '$start_date' AND '$end_date'
				and  nik = '".$hasil->NIK."' GROUP BY nik";
		$jml_cuti=0;
		//echo "<tr><td colspan=8>".$strcuti."</td></tr>";
		if ($this->db->query($strcuti)->num_rows()){
			$rsCuti=$this->db->query($strcuti)->row();
			if ($rsCuti->jenis_cuti!='2'){	//cuti khusus tidak memotong
				$jml_cuti=$rsCuti->HR_CUTI;
			}
		}
		
		//ijin
		$strijin="SELECT NIK, SUM( JML_HARI ) HR_IJIN , SUBSTR( no_trans, 1, 6 ), jenis_cuti, sub_cuti, tgl_awal, tgl_akhir
					FROM `cuti`
					WHERE jenis_cuti=2 and tgl_awal BETWEEN '$start_date' AND '$end_date' and tgl_akhir BETWEEN '$start_date' AND '$end_date'
				and  nik = '".$hasil->NIK."' GROUP BY nik";
		$jml_ijin=0;
		$sub_cuti="";	//melahirkan 1(gapok dpt, U.makan+kehadiran hilang), umroh (u.makan+gapok dpt, kehadiran hilang) 4, haji 3(gapok dpt, , 
			if ($this->db->query($strijin)->num_rows()>0){
				$rsIjin=$this->db->query($strijin)->row();
				$jml_ijin=$rsIjin->HR_IJIN;				
				$sub_cuti=$rsIjin->sub_cuti;
				if (in_array($sub_cuti, [1,2,3,4])){
					$jml_ijin=0;
				}
				//$jml_cuti+=$rsIjin->ALPA_IJIN;
			}
		//sakit
		$strsakit="SELECT NIK, SUM( JML_HARI ) HR_SAKIT , SUBSTR( no_trans, 1, 6 ), jenis_cuti, sub_cuti, tgl_awal, tgl_akhir
					FROM `cuti`
					WHERE jenis_cuti=3 and tgl_awal BETWEEN '$start_date' AND '$end_date' and tgl_akhir BETWEEN '$start_date' AND '$end_date'
				and  nik = '".$hasil->NIK."' GROUP BY nik";
		$jml_sakit=0;
			if ($this->db->query($strsakit)->num_rows()>0){
				$rsSakit=$this->db->query($strsakit)->row();
				$jml_sakit=$rsSakit->HR_SAKIT;
				
			}
		//lembur
		//$strlembur="SELECT NIK, SUM( JML_JAM ) J_JAM , substr( l.no_trans, 1, 6 ) FROM `lembur` l, lembur_d d WHERE l.approved=1 and l.no_trans=d.no_trans and nik = '".$hasil->NIK."' AND substr( l.no_trans, 1, 6 ) = '".$thn.$digitBln."' GROUP BY nik";
		$strlembur="SELECT NIK, SUM( JML_JAM ) J_JAM , substr( l.no_trans, 1, 6 ) FROM `lembur` l, lembur_d d WHERE l.approved=1 and l.no_trans=d.no_trans and nik = '".$hasil->NIK."' AND d.tgl_lembur like '".$thn.'-'.$digitBln."%' GROUP BY nik";
		$jml_lembur=0;
		if ($this->db->query($strlembur)->num_rows()){
			$rsLembur=$this->db->query($strlembur)->row();
			$jml_lembur=$rsLembur->J_JAM;
		}else{
			$jml_lembur=0;
		}
		//$hrLembur=floor($jml_lembur>=7?$jml_lembur/7:0);
		
		$t10_1=0;
		$t10_2=0;
		$t10_3=0;
		//ijin
		$st10_1="SELECT  NIK,   COUNT(*) jml_terlambat FROM `absensi` WHERE nik='".$hasil->NIK."' and terlambat IS NOT NULL AND ((HOUR(terlambat)*60+ MINUTE(terlambat))<=10)";
		$st10_2="SELECT  NIK,   COUNT(*) jml_terlambat FROM `absensi` WHERE nik='".$hasil->NIK."' and terlambat IS NOT NULL AND ((HOUR(terlambat)*60+ MINUTE(terlambat)) BETWEEN 11 AND 20)";
		$st10_3="SELECT  NIK,   COUNT(*) jml_terlambat FROM `absensi` WHERE nik='".$hasil->NIK."' and terlambat IS NOT NULL AND ((HOUR(terlambat)*60+ MINUTE(terlambat)) >21)";

		if ($this->db->query($st10_1)->num_rows()>0){
				$rst10_1=$this->db->query($st10_1)->row();
				$t10_1=$rst10_1->jml_terlambat;			
			}
		if ($this->db->query($st10_2)->num_rows()>0){
				$rst10_2=$this->db->query($st10_2)->row();
				$t10_2=$rst10_2->jml_terlambat;			
			}
		if ($this->db->query($st10_3)->num_rows()>0){
				$rst10_3=$this->db->query($st10_3)->row();
				$t10_3=$rst10_3->jml_terlambat;			
			}
		//pulang cepat
		$pc_jmlhari=0;
		$pc_jmlmenit=0;
		//ijin
		$spc="SELECT  NIK,   COUNT(*) jml_hari, ifnull(SUM((HOUR(PULANG_CEPAT)*60+ MINUTE(PULANG_CEPAT))),0)  jml_menit FROM `absensi` WHERE nik='".$hasil->NIK."' and PULANG_CEPAT IS NOT NULL AND ((HOUR(PULANG_CEPAT)*60+ MINUTE(PULANG_CEPAT))> 1)	GROUP BY nik";
		//$spc="SELECT  NIK,   COUNT(*) jml_pc FROM `absensi` WHERE nik='".$hasil->NIK."' and PULANG_CEPAT IS NOT NULL AND ((HOUR(PULANG_CEPAT)*60+ MINUTE(PULANG_CEPAT))> 1)";
		if ($this->db->query($spc)->num_rows()>0){
				$rspc=$this->db->query($spc)->row();
				$pc_jmlhari=$rspc->jml_hari;			
				$pc_jmlmenit=$rspc->jml_menit;			
			}

		//$alpa=$jmlHariKerja-($hasil->J_MASUK+$jml_cuti);
		//$jml_masuk=$jmlHariKerja - ($jml_cuti+$jml_ijin+$jml_sakit);
		$alpa=$jmlHariKerja-($hasil->J_MASUK+$jml_cuti+$jml_ijin+$jml_sakit);
		$alpa=($alpa<0?0:$alpa);
		//echo "<tr><td colspan=8>".$hrLembur."#".$hrTerlambat."#".$strlembur."</td></tr>";
	?>
	<tr >
	<td><?=$i?><input type="hidden" name="awal_jml_masuk_<?=$i?>" id="awal_jml_masuk_<?=$i?>" value="<?=$hasil->J_MASUK?>"></td>
	<td><?=$hasil->NIK?><input type="hidden" name="awal_alpa_<?=$i?>" id="awal_alpa_<?=$i?>" value="<?=$alpa?>"></td>
	<td><?=str_replace(" ","&nbsp;",$hasil->NAMA)?><input type="hidden" name="nik_<?=$i?>" id="nik_<?=$i?>" value="<?=$hasil->NIK?>"></td>
	<td><?=form_input(array('name'=>'jml_masuk_'.$i,'id'=>'jml_masuk_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$hasil->J_MASUK, 'onchange'=>"setAlpa(this, '$i')"));?></td>
	<td><?=form_input(array('name'=>'cuti_'.$i,'id'=>'cuti_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$jml_cuti));?></td>
	<td><?=form_input(array('name'=>'ijin_'.$i,'id'=>'ijin_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$jml_ijin));?></td>
	<td><?=form_input(array('name'=>'sakit_'.$i,'id'=>'sakit_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$jml_sakit));?></td>
	<td><?=form_input(array('name'=>'t101_'.$i,'id'=>'t101_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$t10_1));?></td>
	<td><?=form_input(array('name'=>'t102_'.$i,'id'=>'t102_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$t10_2));?></td>
	<td><?=form_input(array('name'=>'t103_'.$i,'id'=>'t103_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$t10_3));?></td>
	<td><?=form_input(array('name'=>'pc_hari_'.$i,'id'=>'pc_hari_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$pc_jmlhari));?></td>	
	<td><?=form_input(array('name'=>'pc_menit_'.$i,'id'=>'pc_menit_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$pc_jmlmenit));?></td>	
	<td><?=form_input(array('name'=>'lembur_'.$i,'id'=>'lembur_'.$i,'class'=>'myform-control','size'=>10,'readonly'=>true, 'value'=>$jml_lembur));?></td>	
	<td><?=form_input(array('name'=>'alpa_'.$i,'id'=>'alpa_'.$i,'class'=>'myform-control','size'=>10, 'value'=>$alpa, 'onchange'=>"setJmlMasuk(this, '$i')"));?></td>
	</tr>
	<?
		$i++;
	}
}	
?></table><?

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
		</tbody>
	</div>
</div>
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
	//update total
	$('#alpa_'+idk).val( parseFloat($('#jml_harikerja').val())-(parseFloat(obj.value)+parseFloat($('#cuti_'+idk).val())+parseFloat($('#ijin_'+idk).val())+parseFloat($('#sakit_'+idk).val() ) ) );
}
function setJmlMasuk(obj, idk){		
	//update total
	$('#jml_masuk_'+idk).val( parseFloat($('#jml_harikerja').val())-(parseFloat(obj.value)+parseFloat($('#cuti_'+idk).val())+parseFloat($('#ijin_'+idk).val())+parseFloat($('#sakit_'+idk).val() ) ) );
}
</script>