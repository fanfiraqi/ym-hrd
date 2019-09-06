<!-- <p><?php echo anchor('pinjaman/create','Pembayaran Angsuran',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>
 -->
 <div class="panel panel-default"><div class="panel-heading">DATA PINJAMAN KARYAWAN
  </div><div class="panel-body form-horizontal">
 <!-- <?php echo form_open(null,array('class'=>'form-horizontal','id'=>'myform'));?> -->
 <div class="alert alert-success alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Bayar Angsuran disini hanya jika karyawan resign atau bayar diluar pemotongan gaji bulanan 
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NAMA KARYAWAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nama','id'=>'nama','class'=>'form-control'));?><input type="hidden" name="nik" id="nik"></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">JUMLAH PINJAMAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'jumlah','id'=>'jumlah','readonly'=>'true','class'=>'form-control'));?><input type="hidden" name="nik" id="nik"></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">KOTA CABANG</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'cabang','id'=>'cabang','readonly'=>'true','class'=>'form-control'));?></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">ANGSURAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'lama','id'=>'lama','readonly'=>'true','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">DIVISI</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'divisi','id'=>'divisi','readonly'=>'true','class'=>'form-control'));?></div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">STATUS ANGSURAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'status','id'=>'status','readonly'=>'true','class'=>'form-control'));?></div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">JABATAN</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'jabatan','id'=>'jabatan','readonly'=>'true','class'=>'form-control'));?></div>
		</div>
	</div>
	<div class="col-md-6">
	<div class="form-group"><label  class="col-sm-4 control-label"></label>
			<div class="col-sm-8"><button name="btnbayar" id="btnbayar" data-base="" data-url="" data-id="" onclick="detail(this)" class="btn btn-act btn-success"  disabled>Bayar Angsuran <i class="fa fa-gear" data-toggle="tooltip" title="Bayar Angsuran disini hanya jika karyawan resign atau bayar diluar pemotongan gaji bulanan"></i></button>			
			</div>
		</div>
	</div>
</div>
<!-- <?php echo form_close();?>
 --></div>
 </div>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables-example">
		<thead>
			<tr>
				<th>ID</th>
				<th>CICILAN KE</th>
				<th>TGL BAYAR</th>
				<th>JUMLAH</th>
				<th>STATUS</th>
				<!-- <th>Action</th> -->
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
<!-- /.table-responsive -->
<script>
    $(document).ready(function() {      
    });

	$("#nama").autocomplete({
	minLength: 2,
	source:
	function(req, add){
		$.ajax({
			url: "<?php echo base_url('angsuran/getView'); ?>",
			dataType: 'json',
			type: 'POST',
			data: req,
			success:   
			function(data){
				if(data.response =="true"){
					add(data.message);
				}
			}
		});
	},
	select:
	function(event, ui) {
		var angs=parseFloat(ui.item.jumlah)/parseFloat(ui.item.lama);
		$("#nik").val(ui.item.id);  		
		$("#jumlah").val(ui.item.jumlah);	
		$("#lama").val(angs + ' x '+ui.item.lama + ' Kali');	
		$("#status").val(ui.item.status);	
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('employee_data/getLabelMaster');?>",
			data: { id_cabang: ui.item.id_cabang, id_div: ui.item.id_div, id_jab:ui.item.id_jab},				
			dataType: 'json',
			success: function(msg) {
				 console.log(msg);
				if(msg.status =='success'){
					$("#cabang").val(msg.data.NAMA_CABANG);
					$("#divisi").val(msg.data.NAMA_DIV);
					$("#jabatan").val(msg.data.NAMA_JAB);
									
				} else{
					bootbox.alert("Terjadi kesalahan. "+ msg.errormsg+". Gagal ambil data");				
					
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				bootbox.alert("Terjadi kesalahan. error."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});
		if (ui.item.status=='Belum Lunas'){
			$("#btnbayar").prop('disabled', false);
		}else{
			$("#btnbayar").prop('disabled', true);
		}
		$("#btnbayar").attr('data-id', ui.item.pid);
		$("#btnbayar").attr('data-url', "<?php echo base_url('angsuran/saveAngsuran');?>/"+ui.item.pid);
		$("#btnbayar").attr('data-base', "<?php echo base_url()?>");
		loadList(ui.item.pid);
		//load list tampilkan jumlah baris cicilan, krn bayar lgs dari penggajian jd ditampilkan saja
	}
});


function loadList(pid){
	 $('#dataTables-example').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 25,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"aoColumns": [
				{"mData": "ID" },
				{"mData": "CICILAN"},
				{"mData": "TGL"},
				{"mData": "JUMLAH"},				
				{"mData": "STATUS" }
				//{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('angsuran/json_data');?>/"+pid
		});
}
function detail(obj){
		var id = $(obj).attr('data-id');
		$.ajax({
			url: "<?php echo base_url('angsuran/view/'); ?>/"+id,
			dataType: 'html',
			type: 'POST',
			data: {ajax:'true'},
			success:
				function(data){
					bootbox.dialog({
					  message: data,
					  title: "Bayar Cicilan/Angsuran",
					  buttons: {
						success: {
						  label: "Bayar",
						  className: "btn-success",
						  callback: function() {
							bayarAngsuran(obj);
						  }
						},
						main: {
						  label: "Cancel",
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

function lunasi(idH, idC, jmlB){
			var pilih=confirm('Angsuran = '+idH+ ' cicilan ke = '+idC+' dilunasi ?');
			if (pilih==true) {
					$.ajax({
					type	: "POST",
					url		: "<?php echo base_url('angsuran/setLunasAngsuran');?>",
					data	: "idH="+idH+"&idC="+idC+"&jmlB="+jmlB,
					timeout	: 3000,  
					success	: function(res){
						alert("Angsuran berhasil diupdate");
						window.location.reload();
						}
					
				});
			}
		}

function bayarAngsuran(obj){
	var base_url=$(obj).attr('data-base');
	var form_data = $('#myform').serialize();
	//alert(base_url);
	//alert($(obj).attr('data-url'));
	bootbox.confirm("Anda yakin meneruskan pembayaran ini?", function(result) {
		if (result==true){
			if($('#myModal').hasClass('in')){
				$('#myModal').modal('hide');
			}
			$().showMessage('Sedang diproses.. Harap tunggu..','info');
			$.ajax({
				type: 'POST',
				url: $(obj).attr('data-url'),
				data: form_data,
				dataType: 'json',
				success: function(msg) {
					if(msg.status =='success'){
						$("#loading").fadeOut();
						$().showMessage('Data berhasil disimpan.','success',1000);
						$('#loading').on('hidden.bs.modal', function () {
							//alert(msg.sts);
							//window.location.reload();
							$('#dataTables-example').dataTable().fnReloadAjax();
							//ceknotif(base_url);
						});
					} else {
						$().showMessage('Terjadi kesalahan. Data gagal disimpan.','danger',2000);
					}
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
	});
}
</script>