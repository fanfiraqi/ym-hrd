<?php errorHandler();?>

<div class="row">	
	<div class="col-md-6">
		<div class="panel panel-default"><div class="panel-heading">VIEW MUTASI SAAT INI
		</div><div class="panel-body">

			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
						<div class="col-sm-8"> : <?=$row->NIK." - ".$row->NAMA;?></div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
						<div class="col-sm-8"> : <?=$rsnew->NAMA_CABANG;?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">DIVISI</label>
						<div class="col-sm-8"> : <?=$rsnew->NAMA_DIV;?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">JABATAN</label>
						<div class="col-sm-8"> : <?=$rsnew->NAMA_JAB;?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label  class="col-sm-4 control-label">TANGGAL PENETAPAN</label>
						<div class="col-sm-8"> : <?=revdate($row->TGL_PENETAPAN);?></div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">KETERANGAN MUTASI</label>
						<div class="col-sm-8"> : <?=$row->KETERANGAN;?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENGETAHUI</label>
						<div class="col-sm-8"> : <?=$row->MENGETAHUI;?></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group"><label class="col-sm-4 control-label">MENYETUJUI</label>
						<div class="col-sm-8"> : <?=$row->MENYETUJUI;?></div>
					</div>
				</div>
			</div>

		</div></div>
	</div>


	<div class="col-md-6">
		<div class="panel panel-default"><div class="panel-heading">DARI MUTASI TERAKHIR
		</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
							<div class="col-xs-8"> : <?=$rsold->OLDCAB;?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">DIVISI</label>
							<div class="col-xs-8"> : <?=$rsold->OLDDIV;?>
							
							</div>
						</div>	
					</div>					
				</div>
				<div class="row">
					<div class="col-xs-12">
						<div class="form-group"><label class="col-sm-4 control-label">JABATAN</label>
							<div class="col-xs-8"> : <?=$rsold->OLDJAB;?>
							
							</div>
						</div>	
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row">	
	<div class="col-xs-12">
		<div class="panel panel-default"><div class="panel-heading">HISTORY MUTASI KARYAWAN : <b><?=$row->NIK." - ".$row->NAMA;?></b></div>
		<div class="panel-body">
			<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
				<tr>
					<th>NO</th>
					<th>MUTASI KE</th>
					<th>DARI </th>
					<th>TGL PENETAPAN </th>
					<th>KETERANGAN</th>
					<th>MENGETAHUI</th>
					<th>MENYETUJUI</th>
				</tr>
			</thead>
			<tbody>	
		
		<?	$i=1;
		foreach($rowHistory as $hasil){
			$rsmaster=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$hasil->OLD_ID_CAB.") OLDCAB, (SELECT nama_div FROM mst_divisi WHERE id_div=".$hasil->OLD_ID_DIV.") OLDDIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$hasil->OLD_ID_JAB.") OLDJAB ")->row();
			

			$rsmasternew=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$hasil->ID_CAB.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$hasil->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$hasil->ID_JAB.") NAMA_JAB ")->row();
			
			echo "<tr>";
			echo "<td>$i</td>";
			echo "<td>".$rsmasternew->NAMA_CABANG." - ".$rsmasternew->NAMA_DIV." - ".$rsmasternew->NAMA_JAB."</td>";
			echo "<td>".$rsmaster->OLDCAB." - ".$rsmaster->OLDDIV." - ".$rsmaster->OLDJAB."</td>";
			echo "<td>".$hasil->TGL_PENETAPAN."</td>";
			echo "<td>".($hasil->KETERANGAN=='data pertama'?"Penempatan Sbg Pegawai Baru":$hasil->KETERANGAN)."</td>";
			echo "<td>".$hasil->MENGETAHUI."</td>";
			echo "<td>".$hasil->MENYETUJUI."</td>";
			echo "</tr>";
			$i++;
		}
		
		?>
				</tbody>
			</table>
		</div>
		</div>
		</div>
	</div>
</div>
<br>	<?php 
			$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Kembali',
					'onclick'=>"backTo('".base_url('mutasi/index')."');return false;",
					'class'=>'btn btn-danger'
				);
			echo form_button($btback);?>