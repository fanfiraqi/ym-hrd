<?	
	$viewKop=$this->commonlib->tableKop('HRD-DK',$title, '00', '__','__');
	echo $viewKop;
	//foreach ($arrDivisi as $divisi){
		$strMaster="select * from rekap_validasi_zisco where periode='".$thn.$bln."'  and id_cab=".$cabang;
		//echo  $strMaster;
?>
<div class="row">
	<div class="col-xs-12">
	
	<table class="bordered">


<?
		if ($this->db->query($strMaster)->num_rows()<=0){
			$master_row=0;
			echo "<tr><td colspan=2 STYLE=\"text-align:center\">Data Tidak Ditemukan</td></tr>";
		}else{	// ada data
			$master_row=1;
			$rowMaster=$this->db->query($strMaster)->row();
			?>
	<thead><tr><th colspan=2>LAPORAN REKAP ABSENSI ZISCO PER CABANG PERIODE <?=$strPeriode?></th></tr>
	</thead>
    <tbody>	
	<tr><td width="30%">TANGGAL REKAP </td><td><?=strftime('%d %B %Y',strtotime($rowMaster->MINDATE))." s.d ".strftime('%d %B %Y',strtotime($rowMaster->MAXDATE))?></td></tr>
	<tr><td>JUMLAH HARI EFEKTIF </td><td><?=$rowMaster->JML_HARI_EFEKTIF;?></td></tr>
	<tr><td>JUMLAH LIBUR NASIONAL</td><td><?=$rowMaster->JML_LIBNAS;?></td></tr>
	<tr><td>JUMLAH HARI KERJA </td><td><?=$rowMaster->JML_HARI_KERJA;?></td></tr>
			<?
		}
?>		</tbody>
		</table><!-- footer master -->
	</div>
</div>	
<?		if ($master_row>=1){	//ada detail
			$strDetil="select B.NAMA, B.NIK, A.*  from (select NIK, NAMA from pegawai where id_cabang=".$cabang."  and status_aktif=1) B left OUTER join rekap_absensi_zisco A on B.nik=A.nik where periode='".$thn.$bln."'";
			$rsDetil=$this->db->query($strDetil)->result();
			
?>
<div class="row">
	<div class="col-xs-12">	
	<table class="bordered">
	<thead><tr><th  >NO</th>
	<th  >NIK</th>
	<th  >NAMA</th>
	<th  >JML MASUK (HARI)</th>
	<th  >JML TIDAK MASUK (HARI)</th>
	</thead>
<?			$i=1;
		if (!empty($rsDetil)){
			foreach ($rsDetil as $rowDetail){
				//hitung akumulasi lembur dan terlambat s.d bln terpilih
				//$strAkm="select sum(JAM_LEMBUR) AKM_LEMBUR, SUM(MENIT_TERLAMBAT) AKM_TELAT from rekap_absensi where nik='".$rowDetail->NIK."' AND PERIODE<='".$thn.$bln."'";
				//$rsAkm=$this->db->query($strAkm)->row();

				echo "<tr>";
				echo "<td>$i</td>";
				echo "<td>".$rowDetail->NIK."</td>";
				echo "<td>".str_replace(" ","&nbsp;",$rowDetail->NAMA)."</td>";
				echo "<td>".$rowDetail->JML_MASUK."</td>";
				echo "<td>".$rowDetail->JML_TIDAK_MASUK."</td>";
				echo "</tr>";
				$i++;
			}
		}else{
			echo  "<tr><td colspan=10 style='text-align:center'> Data Rekap absensi tidak ditemukan</td></tr>";
		}
?>
</tbody>
		</table><!-- footer detil -->
	</div>
</div>	
<?	
		}

	//}

	echo "<br>";
	if ($display==0){
		  $param=$cabang."_1_".$bln."_".$thn;
	?>

	<div class="row" style="text-align:center">
		<div class="col-md-12">	
			<a href="<?=base_url('hrdReportAbsensi/rekapAbsenRes/'.$param)?>" class="btn btn-success">Print Data Rekap</a>
			
		</div>
	</div>	
<?}?>
