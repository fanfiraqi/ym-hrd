<?	
	$viewKop=$this->commonlib->tableKop('KEU-LOAN',$title, '00', '__','__');
	echo $viewKop;
?>
<table class="bordered">
    <thead><tr><th colspan=2>DATA PERSONAL</th></tr></thead>
    <tbody>
	<tr><td width="35%">NAMA KARYAWAN</td><td><?=$resMaster->NAMA;?></td></tr>      
	<tr><td>NIK</td><td><?=$resMaster->NIK;?></td></tr>      
	<tr><td>CABANG-DIVISI-JABATAN</td><td><?=$rsGate->NAMA_CABANG." - ".$rsGate->NAMA_DIV." - ".$rsGate->NAMA_JAB;?></td></tr>      
	<tr><td>JUMLAH PINJAMAN</td><td>Rp.&nbsp;<?=number_format($resMaster->JUMLAH,0,',','.')?></td></tr>      
	<tr><td>LAMA ANGSURAN</td><td><?=$resMaster->LAMA;?></td></tr>      
	<tr><td>TANGGAL MEMINJAM</td><td><?=strftime('%d %B %Y',strtotime($resMaster->TGL));?></td></tr>      
	<tr><td>STATUS PINJAMAN</td><td><?=$resMaster->STATUS;?></td></tr>    
</tbody>
</table>
<table class="bordered">
    <thead><tr><th >NO</th><th >ANGS. KE</th><th >TGL BAYAR</th><th >JML BAYAR</th><th >STATUS</th></tr></thead>
    <tbody>
<?	$jmlBayar=0;
	$jmlCicil=0;
	$i=1;
	foreach ($resDetil as $detil){
		$jmlBayar+=$detil->JML_BAYAR;
		$jmlCicil+=($detil->JML_BAYAR<=0?0:1);
		$status=($detil->JML_BAYAR<=0?"Belum Lunas":"Lunas");
		echo "<tr>";
		echo "<td>$i</td>";
		echo "<td>".$detil->CICILAN_KE."</td>";
		echo "<td>".($detil->TGL_BAYAR==""?'-':strftime('%d %B %Y',strtotime($detil->TGL_BAYAR)))."</td>";
		echo "<td STYLE=\"text-align:right\">Rp. ".number_format($detil->JML_BAYAR,0,',','.')."</td>";
		echo "<td>".$status."</td>";
		echo "</tr>";
		$i++;
	}
	echo "<tr><th>&nbsp;</th><th colspan=2>Jumlah Bayar</th><th STYLE=\"text-align:right\">Rp. ".number_format($jmlBayar,0,',','.')."</th><th>&nbsp;</th></tr>";
	echo "<tr><th>&nbsp;</th><th colspan=2>Sudah Dicicil </th><th colspan=2>".$jmlCicil." Kali"."</th></tr>";
	echo "<tr><th>&nbsp;</th><th colspan=2>Kekurangan </th><th colspan=2>".($resMaster->LAMA-$jmlCicil)." Kali, Sebesar : Rp.".number_format(($resMaster->JUMLAH-$jmlBayar),0,',','.')."</th></tr>";
?>
	</tbody>
</table><br>
<? if ($display==0){
	$param=$nik."_1";
?>
<div class="row" style="text-align:center">
	<div class="col-md-12">	
		<a href="<?=base_url('keuReportLoan/personalLoan/'.$param)?>" class="btn btn-success">Print</a><br>
		<!-- <button id="btPrint_dp" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Cetak Data Pribadi">Print Data Pribadi</button> -->
	</div>
</div>	
<?}?>