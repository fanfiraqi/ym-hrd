<? if ($display==0){
	$viewKop=$this->commonlib->tableKop('HRD-DK','Data Karyawan', '00', 2,3);
	echo $viewKop;
}
?>
<table class="bordered">
    
    <tbody>
<?  if (sizeof($rowKel)<=0){
	echo "<tr><td style=\"text-align:center\"><b>Tidak Ada Data Keluarga</b></td></tr>";
}else{
	foreach ($rowKel as $row){
		$anakke = $row->ID_HUBKEL==2?$row->ANAK_KE:'';
		$hubkel = $row->ID_HUBKEL==1?($row->SEX==1?$row->VALUE2:$row->VALUE3):$row->VALUE1;
		if ($row->ID_HUBKEL==1){
			
	?>
	<tr><th colspan=3><?=strtoupper($hubkel);?></td></tr>      
	<tr><td>NAMA</td><td><?=$row->NAMA;?></td></tr>      
	<tr><td>TEMPAT, TANGGAL LAHIR</td><td><?=$row->TEMPAT_LAHIR.", ".strftime('%d %B %Y',strtotime($row->TGL_LAHIR));?></td></tr> 
	<tr><td>PENDIDIKAN</td><td><?=$row->PENDIDIKAN;?></td></tr>
	<tr><td>PEKERJAAN</td><td><?=$row->PEKERJAAN;?></td></tr>

	<?
		}else{
	?>
	<tr><th colspan=3><?=strtoupper($hubkel)." KE - ".strtoupper($anakke);?></td></tr>      
	<tr><td>NAMA</td><td><?=$row->NAMA;?></td></tr>      
	<tr><td>TEMPAT, TANGGAL LAHIR</td><td><?=$row->TEMPAT_LAHIR.", ".strftime('%d %B %Y',strtotime($row->TGL_LAHIR));?></td></tr> 
	<tr><td>PENDIDIKAN</td><td><?=$row->PENDIDIKAN;?></td></tr>
	<tr><td>PEKERJAAN</td><td><?=$row->PEKERJAAN;?></td></tr>

	<?
	
		}
	
	}
}?>
</tbody>
</table><br>
<? if ($display==0){
	$param=$nik."_keluarga_1";
?>
<div class="row" style="text-align:center">
	<div class="col-md-12">		
		<a href="<?=base_url('hrdReportPersonal/personalData/'.$param)?>" class="btn btn-success">Print Data Keluarga</a>
	</div>
</div>	
<?
}
?>
