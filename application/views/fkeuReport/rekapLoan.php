<?	
	$viewKop=$this->commonlib->tableKop('KEU-LOAN',$title, '00', '__','__');
	echo $viewKop;
	//echo $strMaster;
?>

<table class="bordered">
    <thead><tr><th >NO</th><th >NIK-NAMA</th><th >POSISI</th><th >JML PINJAMAN</th><th >KEPERLUAN</th><th >CICILAN </th><th >SUDAH DICICIL</th><th >KEKURANGAN</th><th >STATUS</th></tr></thead>
    <tbody>
<?	$jmlBayar=0;
	$jmlCicil=0;
	$i=1;
	if (sizeof($resMaster)>0){
	foreach ($resMaster as $detil){
		$rsGate=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$detil->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$detil->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$detil->ID_JAB.") NAMA_JAB ")->row();

		$kurang=$detil->JUMLAH-$detil->SDH_BAYAR;
		//$jmlCicil+=($detil->JML_BAYAR<=0?0:1);
		//$status=($detil->JML_BAYAR<=0?"Belum Lunas":"Lunas");
		echo "<tr>";
		echo "<td>$i</td>";
		echo "<td>".$detil->NIK.'-'.str_replace(" ","&nbsp;",$detil->NAMA)."</td>";
		echo "<td>".$rsGate->NAMA_CABANG.'-'.$rsGate->NAMA_DIV.'-'.$rsGate->NAMA_JAB."</td>";
		echo "<td STYLE=\"text-align:right\">Rp.&nbsp;".number_format($detil->JUMLAH,0,',','.')."</td>";
		echo "<td>".$detil->KEPERLUAN."</td>";
		echo "<td>".$detil->LAMA."&nbsp;x&nbsp;".$detil->JML_CICILAN."</td>";
		echo "<td>".$detil->JML_ANGS."&nbsp;kali<br>&nbsp;total&nbsp;bayar&nbsp;Rp.&nbsp;".number_format($detil->SDH_BAYAR,0,',','.')."</td>";
		echo "<td>".($detil->LAMA-$detil->JML_ANGS)."&nbsp;kali<br>&nbsp;sebesar&nbsp;Rp.&nbsp;".number_format($kurang,0,',','.')."</td>";
		//echo "<td>".($detil->TGL_BAYAR==""?'-':strftime('%d %B %Y',strtotime($detil->TGL_BAYAR)))."</td>";
		echo "<td >".str_replace(" ","&nbsp;",$detil->STATUS)."</td>";
		echo "</tr>";
		$i++;
	}
	}else{
		echo "<tr><td colspan=9>Data Tidak ditemukan</td></tr>";
	}
	
?>
	</tbody>
</table><br>
<? if ($display==0){
	$param=$jns_status."_1";
?>
<div class="row" style="text-align:center">
	<div class="col-md-12">	
		<a href="<?=base_url('keuReportLoan/rekapLoan/'.$param)?>" class="btn btn-success">Cetak/Download</a><br>
		<!-- <button id="btPrint_dp" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Cetak Data Pribadi">Print Data Pribadi</button> -->
	</div>
</div>	
<?}?>