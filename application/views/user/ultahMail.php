<div class="panel panel-default">
         <div class="panel-heading">
              <h4 class="panel-title">
              <i class="fa fa-bell fa-fw"></i> Karyawan - Keluarga yang Berulang Tahun
                  </h4>
              </div>
        
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
<script>
$('#btxls_ultah').click(function(){
		window.open('<?php echo base_url('user/xlsUltah');?>');
	});
</script>	