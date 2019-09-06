
<div class="panel-group" id="accordion">     

<?php 
//$therole==$this->config->item('myrole');
if ( in_array($therole, [1,3,11,26, 66])){?>
	 <div class="panel panel-default"><!-- PERMOHONAN CUTI -->
         <div class="panel-heading">
              <h4 class="panel-title">
              <i class="fa fa-warning fa-fw"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Persetujuan Permohonan Cuti</a>
              </h4>
              </div>
			<div id="collapseOne" class="panel-collapse collapse out">
             <div class="panel-body">

              <div class="table-responsive" style="overflow:scroll; height:300px">
					<table class="table table-striped table-bordered table-hover" id="dataTables1">
						<thead>
							<tr>
								<th>NO</th>
								<th>NIK</th>
								<th>NAMA</th>
								<th>POSISI</th>
								<th>TGL IJIN</th>
								<th>KETERANGAN</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody>
						<?	//echo "<tr><td colspan=20>".sizeof($row)."</td></tr>";
							if ($cekCuti<=0){
								$j=1;
								$i=1;
								echo "<tr align=center><td colspan=7>Data Belum Ada</td></tr>";
							}else{
							$i=1;
							foreach($rowCuti as $hasil){ 
							$rsname=$this->gate_db->query("SELECT (SELECT kota FROM mst_cabang WHERE id_cabang=".$hasil->ID_CABANG.") NAMA_CABANG, (SELECT nama_div FROM mst_divisi WHERE id_div=".$hasil->ID_DIV.") NAMA_DIV ,(SELECT nama_jab FROM mst_jabatan WHERE id_jab=".$hasil->ID_JAB.") NAMA_JAB ")->row();
								?>	
							<tr>
							<td><?=$i?></td>
							<td><?=$hasil->NIK?></td>
							<td><?=$hasil->NAMA?></td>
							<td><?=$rsname->NAMA_CABANG."/".$rsname->NAMA_DIV."/".$rsname->NAMA_JAB?></td>
							<td><?=$hasil->TGL_AWAL."-".$hasil->TGL_AKHIR?></td>
							<td><?=$hasil->JENISCUTI1."-".$hasil->JENISCUTI2?></td>						
							<td><a href="javascript:void(0)" data-url="<?=base_url('cuti/approve/'.$hasil->ID)?>" data-id="<?=$hasil->ID?>" onclick="detail(this)" class="btn btn-act btn-success"><i class="fa fa-gear" title="Validasi"></i></a></td>
							<? $i++; }		
								}?>
						</tbody>
					</table>
				</div> 
				&nbsp;<br><div class="row" style="text-align:center">
				<button class="btn btn-success" id="btxls_cuti" <?=($cekCuti<=0?"disabled":"")?>><i class="fa fa-printer"></i> Cetak XLS</button></div>

             </div>
              </div>
          </div>	  <!-- PERMOHONAN CUTI-->

		  
		  
		  <!-- PERMOHONAN LEMBUR -->
     <div class="panel panel-default">
         <div class="panel-heading">
              <h4 class="panel-title">
              <i class="fa fa-warning fa-fw"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Persetujuan Permohonan Lembur</a>
                  </h4>
              </div>
         <div id="collapseTwo" class="panel-collapse collapse">
             <div class="panel-body">
            <div class="table-responsive" style="overflow:scroll; height:300px">
					<table class="table table-striped table-bordered table-hover" id="dataTables2">
						<thead>
							<tr>
								<th>NO</th>
								<th>NIK</th>
								<th>NAMA</th>
								<th>TGL LEMBUR</th>
								<th>MULAI</th>
								<th>SELESAI</th>
								<th>JML JAM</th>
								<th>ACTION</th>
							</tr>
						</thead>
						<tbody>
						<?	//echo "<tr><td colspan=20>".sizeof($row)."</td></tr>";
							if ($cekLembur<=0){
								$j=1;
								$i=1;
								echo "<tr align=center><td colspan=8>Data Belum Ada</td></tr>";
							}else{
							$i=1;
							foreach($rowLembur as $hasil){ ?>	
							<tr>
							<td><?=$i?></td>
							<td><?=$hasil->NIK?></td>
							<td><?=$hasil->NAMA?></td>
							<td><?=$hasil->TGL_LEMBUR?></td>
							<td><?=$hasil->MULAI?></td>
							<td><?=$hasil->SELESAI?></td>
							<td><?=$hasil->JML_JAM;?></td>
							<td>
							<? if ( in_array($therole, [1,3,11,26, 66])) {?> 
							<a href="javascript:void(0)" data-url="<?=base_url('lembur/view/'.$hasil->NO_TRANS)?>" data-id="<?=$hasil->NO_TRANS?>" onclick="view(this)" class="btn btn-act btn-success"><i class="fa fa-gear" title="Validasi"></i></a>
							<? }
							$i++; }		
								}?>
						</tbody>
					</table>
				</div>  
				&nbsp;<br><div class="row" style="text-align:center">
				<button class="btn btn-success" id="btxls_lembur" <?=($cekLembur<=0?"disabled":"")?>><i class="fa fa-printer"></i> Cetak XLS</button></div>


			</div>
        </div>
   

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mnotrans" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="mnotrans">Modal title</h4>
      </div>
      <div class="modal-body" id="mcontent">
        ...
      </div>
      <div class="modal-footer">       
		<a href="javascript:void(0)" data-url="<?php echo base_url('lembur/approve');?>" data-id="" onclick="approve(this)" class="btn btn-success" id="mbtappv"><i class="fa fa-check" title="Setuju"></i> Setuju</a>
		<a href="javascript:void(0)" data-url="<?php echo base_url('lembur/approve');?>" data-id="" onclick="denied(this)" class="btn btn-danger" id="mbtden"><i class="fa fa-check" title="Tolak"></i> Tolak</a>
		 <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

 </div>





<div class="panel panel-default">
         <div class="panel-heading">
              <h4 class="panel-title">
              <i class="fa fa-bell fa-fw"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"> Karyawan - Keluarga yang Berulang Tahun</a>
                  </h4>
              </div>
         <div id="collapseFour" class="panel-collapse collapse">
             <div class="panel-body">

              <div class="table-responsive" style="overflow:scroll; height:300px">
					<table class="table table-striped table-bordered table-hover" id="dataTables1">
						<thead>
							<tr>
								<th>NO</th>
								<th>NIK</th>
								<th>NAMA</th>
								<th>TGL LAHIR</th>
								<th>KETERANGAN</th>
								<th>EMAIL</th>
							</tr>
						</thead>
						<tbody>
						<?	//echo "<tr><td colspan=20>".sizeof($row)."</td></tr>";
							if ($cekUltah<=0){
								$j=1;
								$i=1;
								echo "<tr align=center><td colspan=6>Data Belum Ada</td></tr>";
							}else{
							$i=1;
							foreach($rowUltah as $hasil){ ?>	
							<tr>
							<td><?=$i?></td>
							<td><?=$hasil->COL1?></td>
							<td><?=$hasil->COL2?></td>
							<td><?=$hasil->TGL_LAHIR?></td>
							<td><?=$hasil->KET?></td>
							<td><a href="javascript:void(0)" data-url="<?=base_url('employee/sendEmail/')?>" data-id="<?=$hasil->COL1?>" onclick="singleEmail(this, 'ultah')"><i class="fa fa-envelope" title="Send Email"></i></a></td>
							<? $i++; }		
								}?>
						</tbody>
					</table>
				</div>
					&nbsp;<br><div class="row" style="text-align:center">
				<button class="btn btn-success" id="btxls_ultah" <?=($cekUltah<=0?"disabled":"")?>><i class="fa fa-printer"></i> Cetak XLS</button></div>

                  </div>
              </div>
          </div>
<!-- JATAH CUTI -->
<div class="panel panel-default">
         <div class="panel-heading">
              <h4 class="panel-title">
              <i class="fa fa-tasks fa-fw"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">Karyawan Mulai Dapat Jatah Cuti (15 bln dari tgl masuk)</a>
                  </h4>
              </div>
         <div id="collapseFive" class="panel-collapse collapse">
             <div class="panel-body">

<div class="table-responsive" style="overflow:scroll; height:300px">
					<table class="table table-striped table-bordered table-hover" id="dataTables1">
						<thead>
							<tr>
								<th>NO</th>
								<th>NIK</th>
								<th>NAMA</th>
								<th>POSISI</th>
								<th>TGL MULAI KERJA</th>
								<th>MASA KERJA</th>								
							</tr>
						</thead>
						<tbody>
						<?	//echo "<tr><td colspan=20>".sizeof($row)."</td></tr>";
							if ($cekJatahCuti<=0){
								$i=1;
								echo "<tr align=center><td colspan=6>Data Belum Ada</td></tr>";
							}else{
							$i=1;
							foreach($rowJatahCuti as $hasil){ 
								$interval = date_diff(date_create(), date_create($hasil->TGL_AKTIF));
								$masaKerja= $interval->format("  %Y Tahun, %M Bulan, %d Hari");
								?>	
							<tr>
							<td><?=$i?></td>
							<td><?=$hasil->NIK?></td>
							<td><?=$hasil->NAMA?></td>
							<td><?=$hasil->KET?></td>
							<td><?=$hasil->TGL_AKTIF?></td>
							<td><?=$masaKerja?></td>
							
							<? $i++; }		
								}?>
						</tbody>
					</table>
				</div> 

					&nbsp;<br><div class="row" style="text-align:center">
				<button class="btn btn-success" id="btxls_dapatJatah" <?=($cekJatahCuti<=0?"disabled":"")?>><i class="fa fa-printer"></i> Cetak XLS</button></div>


                  </div>
              </div>
          </div>  <!-- JATAH CUTI -->


<div class="panel panel-default"><!--  JATUH TEMPO & UPGRADE MASA KONTRAK -->
         <div class="panel-heading">
              <h4 class="panel-title">
              <i class="fa fa-warning fa-fw"></i><a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">  Jatuh Tempo & Upgrade Masa Kontrak Karyawan</a>
                  </h4>
              </div>
         <div id="collapseThree" class="panel-collapse collapse">
             <div class="panel-body">
		
			<div class="table-responsive" style="overflow:scroll; height:300px">
					<table class="table table-striped table-bordered table-hover" id="dataTables1">
						<thead>
							<tr>
								<th>NO</th>
								<th>NIK</th>
								<th>NAMA</th>
								<th>JENIS KONTRAK</th>
								<th>TGL AKHIR</th>
								<th>SISA HARI</th>
								<th>UPGRADE ? </th>
							</tr>
						</thead>
						<tbody>
						<?	//echo "<tr><td colspan=20>$strKontrak</td></tr>";
							if ($cekKontrak<=0){
								$j=1;
								$i=1;
								echo "<tr align=center><td colspan='7'>Data Belum Ada</td></tr>";
							}else{
							$i=1;
							foreach($rowKontrak as $hasil){ ?>	
							<tr>
							<td><?=$i?></td>
							<td><?=$hasil->NIK?></td>
							<td><?=$hasil->NAMA?></td>
							<td><?=$hasil->VALUE1?></td>
							<td><?=$hasil->TGL_AKHIR?></td>
							<td><?=$hasil->SISA?></td>
							<td><a href="javascript:void(0)" data-url="<?=base_url('employee/upgradeKontrak')?>" data-id="<?php echo$hasil->NIK;?>" onclick="updKontrak(this,'dataTables1')"><i class="fa fa-check" title="Setuju"></i></a></td>
							<? $i++; }		
								}?>
						</tbody>
					</table>
				</div>    
					
					&nbsp;<br><div class="row" style="text-align:center">
				<button class="btn btn-success" id="btxls_kontrak" <?=($cekKontrak<=0?"disabled":"")?>><i class="fa fa-printer"></i> Cetak XLS</button></div>


                  </div>
              </div>
          </div>
	 
	 <!--  JATUH TEMPO & UPGRADE MASA KONTRAK -->
      </div>


<?php }?>

</div>

<script>
  
	
	function detail(obj){
		var id = $(obj).attr('data-id');
		$.ajax({
			url: "<?php echo base_url('cuti/view/'); ?>/"+id,
			dataType: 'html',
			type: 'POST',
			data: {ajax:'true'},
			success:
				function(data){
					bootbox.dialog({
					  message: data,
					  title: "Persetujuan Data",
					  buttons: {
						success: {
						  label: "Setuju",
						  className: "btn-success",
						  callback: function() {
							approve(obj);
						  }
						},
						button: {
						  label: "Tolak",
						  className: "btn-danger",
						  callback: function() {
							denied(obj);
						  }
						},
						main: {
						  label: "Kembali",
						  className: "btn-warning",
						  callback: function() {
							console.log("Primary button");
						  }
						}
					  }
					});
				}
		});
		
	}

	function view(obj){
	var notrans = $(obj).attr('data-id');
			$.ajax({
				type: 'GET',
				url: $(obj).attr('data-url'),
				data: {view:'true',notrans:notrans},
				dataType: 'html',
				success: function(msg) {
					$('#mnotrans').html('No. Dokumen Lembur : '+ notrans);
					$('#mcontent').html(msg);
					$('#mbtappv').attr('data-id',notrans);
					$('#mbtden').attr('data-id',notrans);
					$('#myModal').modal({'show':true,backdrop: 'static'});
				},
				complete: function(msg){
					$('html').animate({
						scrollTop: $('#page-wrapper').offset().top
					}, 500);
					
					return false;
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger',2000);
				},
				cache: false
			});
	}



	$('#btxls_cuti').click(function(){
		window.open('<?php echo base_url('user/xlsCuti');?>');
	});

	$('#btxls_lembur').click(function(){
		window.open('<?php echo base_url('user/xlsLembur');?>');
	});

	$('#btxls_ultah').click(function(){
		window.open('<?php echo base_url('user/xlsUltah');?>');
	});

	$('#btxls_dapatJatah').click(function(){
		window.open('<?php echo base_url('user/xlsJatahCuti');?>');
	});
	
	$('#btxls_kontrak').click(function(){
		window.open('<?php echo base_url('user/xlsKontrak');?>');
	});
</script>