<p>
<a href="javascrip:void()" id="btcreate" class="btn btn-primary">Tambah Data</a>
</p>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables">
		<thead>
			<tr>
				<th>Hub. Keluarga</th>
				<th>Anak Ke</th>
				<th>Nama</th>
				<th>Jenis Kelamin</th>
				<th>Tempat Lahir</th>
				<th>Tanggal Lahir</th>
				<th>Pendidikan</th>
				<th>Pekerjaan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Tambah Data Keluarga</h4>
      </div>
      <div class="modal-body">
        <!-- isi modal-->
		
		<?php echo form_open('',array('class'=>'form-horizontal','id'=>'myformkel'));?>
<div class="form-group">
	<label for="hubkel" class="col-sm-3 control-label">Hubungan Keluarga</label>
	<div class="col-sm-9">
		<?php
			echo form_dropdown('hubkel',$hubkel,'','id="hubkel" class="form-control"');
		?>
	</div>
</div>
<div class="form-group anakke no-display">
	<label for="anak" class="col-sm-3 control-label">Anak Ke</label>
	<div class="col-sm-9">
		
		<?php
			$anak = array(
				'name'=>'anak',
				'id'=>'anak',
				'class'=>'form-control'
			);
			echo form_input($anak);
		?>
	</div>
</div>
<div class="form-group">
	<label for="nama" class="col-sm-3 control-label">Nama</label>
	<div class="col-sm-9">
		<?php
			$nama = array(
				'name'=>'namakel',
				'id'=>'namakel',
				'class'=>'form-control'
			);
			echo form_input($nama);
		?>
	</div>
</div>
<div class="form-group">
	<label for="sexkel" class="col-sm-3 control-label">Jenis Kelamin</label>
	<div class="col-sm-9">
		
		<?php
			echo form_dropdown('sexkel',$sex,'','id="sexkel" class="form-control"');
		?>
	</div>
</div>
<div class="form-group">
	<label for="tempatlahir" class="col-sm-3 control-label">Tempat Lahir</label>
	<div class="col-sm-9">
		
		<?php
			$tempatlahir = array(
				'name'=>'tempatlahirkel',
				'id'=>'tempatlahirkel',
				'class'=>'form-control'
			);
			echo form_input($tempatlahir);
		?>
	</div>
</div>
<div class="form-group">
	<label for="tgllahirkel" class="col-sm-3 control-label">Tanggal Lahir</label>
	<div class="col-sm-9">
		<div class="input-group">
		<?php
			$tgllahir = array(
				'name'=>'tgllahirkel',
				'id'=>'tgllahirkel',
				'class'=>'form-control'
			);
			echo form_input($tgllahir);
		?>
		<div class="input-group-addon"><span id="bttglkel" class="fa fa-calendar"></span></div>
	</div>
	</div>
</div>
<div class="form-group">
	<label for="pendidikan" class="col-sm-3 control-label">Pendidikan</label>
	<div class="col-sm-9">
		<?php
			echo form_dropdown('pendidikankel',$pendidikan,'','id="pendidikankel" class="form-control"');
		?>
	</div>
</div>
<div class="form-group">
	<label for="pekerjaan" class="col-sm-3 control-label">Pekerjaan</label>
	<div class="col-sm-9">
		<?php
			$pekerjaan = array(
				'name'=>'pekerjaankel',
				'id'=>'pekerjaankel',
				'class'=>'form-control'
			);
			echo form_input($pekerjaan);
		?>
	</div>
</div>
<?php echo form_close();?>
		
		<!-- //isi modal-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btsimpankel">Simpan</button>
      </div>
    </div>
  </div>
</div>
<!-- /.table-responsive -->
<script>
    $(document).ready(function() {
        $('#dataTables	').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 5,
			"aoColumns": [
				{"mData": "HUBKEL" },
				{"mData": "ANAK_KE" },
				{"mData": "NAMA" },
				{"mData": "SEX" },
				{"mData": "KOTA" },
				{"mData": "TGL_LAHIR" },
				{"mData": "PENDIDIKAN" },
				{"mData": "PEKERJAAN" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('employee/json_family/'.$row->NIK);?>"
		});
    });
	
	$('#btcreate').click(function(){
		$('#myModal').modal('show');
	});
	
	$('#myModal').on('hide.bs.modal', function (e) {
		if(event.target instanceof HTMLDivElement)
		  {
			return false; 
		  }
			// alert(event.target);
		   return true; // validate before show the modal
	  })
	$('#hubkel').change(function(){
		$('#anak').val('');
		if ($(this).val()==2){			
			$('.anakke').fadeIn();
		} else {
			$('.anakke').fadeOut();
		}
	});
	
	$( "#tgllahirkel" ).datepicker({
		dateFormat: 'dd-mm-yy',
		maxDate: 'today',
		changeYear: true,
		changeMonth: true,
		yearRange:'-100:+0'
	});
	$("#bttglkel").click(function() {
		$("#tgllahirkel").datepicker("show");
	});
	
	$('#btsimpankel').click(function(){
		var nik = $('#nik').val();
		var hubkel = $('#hubkel').val();
		var anak = $('#anak').val();
		var namakel = $('#namakel').val();
		var sexkel = $('#sexkel').val();
		var tempatlahirkel = $('#tempatlahirkel').val();
		var tgllahirkel = $('#tgllahirkel').val();
		var pendidikankel = $('#pendidikankel').val();
		var pekerjaankel = $('#pekerjaankel').val();
		if(hubkel==2 && isNaN(parseInt(anak))){
			$().showMessage('Field Anak Ke belum diisi dengan benar','danger');
			return false;
		}
		
		if($.trim(namakel)==''){
			$().showMessage('Field Nama belum diisi dengan benar','danger');
			return false;
		}
		
		if($.trim(tempatlahirkel)==''){
			$().showMessage('Field Tempat Lahir belum diisi dengan benar','danger');
			return false;
		}
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url('employee/addfam');?>',
			data: {
				nik:nik,
				hubkel:hubkel,
				anak:anak,
				namakel:namakel,
				sexkel:sexkel,
				tempatlahirkel:tempatlahirkel,
				tgllahirkel:tgllahirkel,
				pendidikankel:pendidikankel,
				pekerjaankel:pekerjaankel
			},
			dataType: 'json',
			success: function(msg) {
				if(msg.status =='success'){
					$().showMessage('Data berhasil disimpan.','success',2000);
					$('#myModal').modal('hide');
					$('#dataTables').dataTable().fnReloadAjax();
				} else {
					$().showMessage('Terjadi kesalahan. Data gagal disimpan.','danger',2000);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger',2000);
			},
			cache: false
		});
		$().showMessage('Berhasil disimpan','success',1000);
	});
</script>