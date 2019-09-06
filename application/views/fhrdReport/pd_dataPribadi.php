<? if ($display==0){
	$viewKop=$this->commonlib->tableKop('HRD-DK','Data Karyawan', '00', 1,3);
	echo $viewKop;
}
?>
<table class="bordered">
    <thead>
    <tr>
        <th colspan=2>DATA PERSONAL</th>        
    </tr>
    </thead>
    <tbody>
	<tr><td>NAMA KARYAWAN</td><td><?=$row->NAMA;?></td></tr>      
	<tr><td>NIK</td><td><?=$row->NIK;?></td></tr>      
	<tr><td>JENIS KELAMIN</td><td><?=$row->NAMA_SEX;?></td></tr>      
	<tr><td>JABATAN/DIVISI/CABANG</td><td><?=$rowMaster->NAMA_JAB." / ".$rowMaster->NAMA_DIV." / ".$rowMaster->NAMA_CABANG;?></td></tr>      
	<tr><td>TANGGAL AKTIF KERJA</td><td><?=strftime('%d %B %Y',strtotime($row->TGL_AKTIF));?></td></tr>      
	<tr><td>ALAMAT</td><td><?=$row->ALAMAT;?></td></tr>      
	<tr><td>TEMPAT, TANGGAL LAHIR</td><td><?=$row->TEMPAT_LAHIR.", ".strftime('%d %B %Y',strtotime($row->TGL_LAHIR));?></td></tr> 
	<tr><td>NO. HP</td><td><?=$row->TELEPON;?></td></tr>
	<tr><td>ALAMAT E-MAIL</td><td><?=$row->EMAIL;?></td></tr>
	<tr><td>NO. REKENING/PAYROLL</td><td><?=$row->REKENING;?></td></tr>
	<tr><td>STATUS KARYAWAN</td><td><?=$row->STS_PEGAWAI;?></td></tr>	
	<tr><td>STATUS PERNIKAHAN</td><td><?=$row->NIKAH;?></td></tr>
	<? if ($row->NIKAH=='MENIKAH') {?>
	<tr><td>JUMLAH ANAK</td><td><?=$row->JUMLAH_ANAK;?></td></tr>
	<tr><td>NAMA KONTAK KELUARGA</td><td><?=$row->NAMA_KONTAK_KELUARGA;?></td></tr>
	<tr><td>NOMER TELP KELUARGA</td><td><?=$row->TELP_KELUARGA;?></td></tr>
	<?}?>
	
</tbody>
</table>
<br>
 <table class="bordered"><thead><tr><th colspan=3>RIWAYAT PENDIDIKAN</th> </tr></thead><tbody>
<?  if (sizeof($rowPendidikan)<=0){
	echo "<tr><td style=\"text-align:center\" colspan=3>DATA RIWAYAT PENDIDIKAN TIDAK DITEMUKAN</td></tr>";
}else{
	$i=1;
	?><tr><th width="5%">NO</th><th >PENDIDIKAN FORMAL</th><th>PENDIDIKAN INFORMAL</th></tr><?
	foreach ($rowPendidikan as $rsPendidikan){?>
 
<?
	echo "<tr>";
	echo "<td>$i</td>";
	echo "<td>Pendidikan Terakhir : ".$rsPendidikan->pf_terakhir."<br>Jurusan/Universitas : ".$rsPendidikan->pf_jur_univ."<br>Nilai/IPK : ".$rsPendidikan->pf_ipk."</td>";
	echo "<td>I : ".$rsPendidikan->pinf_1."<br>II : ".$rsPendidikan->pinf_2."<br>III : ".$rsPendidikan->pinf_3."<br>IV : ".$rsPendidikan->pinf_4."</td>";
	echo "</tr>";
	$i++;
	}
}
	?>
  </tbody></table><br>
 <table class="bordered"><thead><tr><th colspan=2>PENGALAMAN KERJA</th> </tr></thead><tbody>
<?  if (sizeof($rowKerja)<=0){
	echo "<tr><td style=\"text-align:center\" colspan=2>DATA PENGALAMAN KERJA TIDAK DITEMUKAN</td></tr>";
}else{
	$i=1;
	?><tr><th width="5%">NO</th><th>PENGALAMAN KERJA</th></tr><?
	foreach ($rowKerja as $rsKerja){?>
 
<?
	echo "<tr>";
	echo "<td>$i</td>";
	echo "<td>".$rsKerja->KETERANGAN."</td>";
	echo "</tr>";
	$i++;
	}
}
	?>
  </tbody></table><br>
 <table class="bordered"><thead><tr><th colspan=2>PENGALAMAN ORGANISASI</th> </tr></thead><tbody>
<?  if (sizeof($rowOrganisasi)<=0){
	echo "<tr><td style=\"text-align:center\" colspan=2>DATA PENGALAMAN ORGANISASI TIDAK DITEMUKAN</td></tr>";
}else{
	$i=1;
	?><tr><th width="5%">NO</th><th>PENGALAMAN KERJA</th></tr><?
	foreach ($rowOrganisasi as $rsOrg){?>
 
<?
	echo "<tr>";
	echo "<td>$i</td>";
	echo "<td>".$rsOrg->KETERANGAN."</td>";
	echo "</tr>";
	$i++;
	}
}
	?>
  </tbody></table><br>
<? if ($display==0){
	$param=$nik."_pribadi_1";
?>
<div class="row" style="text-align:center">
	<div class="col-md-12">	
		<a href="<?=base_url('hrdReportPersonal/personalData/'.$param)?>" class="btn btn-success">Print Data Pribadi</a><br>
		<!-- <button id="btPrint_dp" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Cetak Data Pribadi">Print Data Pribadi</button> -->
	</div>
</div>	
<script type="text/javascript">

$('#btPrint_dp').click(function() {		
	//	var pilih=confirm('Cetak Data Ini?');		
	//	if (pilih==true) {
			$.ajax({
				url: "<?php echo base_url('hrdReportPersonal/personalData'); ?>",
				dataType: 'json',
				type: 'GET',
				data: "nik="+<?=$nik?>+"&sub=pribadi"+"&display=1&kunci=1",				
				success: function(data,  textStatus, jqXHR){					
					//data				
				} 
			});			
	//	}
		
	});
</script>

<?
}
?>
