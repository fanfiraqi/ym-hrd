<hr />
<div class="row">
	<div class="col-sm-6">
		<div class="form-group">
			<label for="cabang" class="col-sm-4 control-label">Cabang</label>
			<div class="col-sm-8">
			<?php
				if ($this->session->userdata('auth')->id_cabang=="1"){
					echo form_dropdown('cabangfilter',$cabang,'','id="cabangfilter" class="form-control" ');
				}else{
					echo '<input type="hidden" name="cabangfilter" id ="cabangfilter" value="'.$cabang->id_cabang.'"/>';
					echo '<label  class="col-sm-4 control-label">'.$cabang->kota.'</label>';
				}
				?>
				
			</div>
		</div>
	</div>	
</div>
<hr />
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover" id="dataTables">
		<thead>
			<tr>
				<th>No </th>
				<th>Tanggal Surat</th>
				<th>NIK</th>
				<th>Nama</th>
				<th>Cabang/Div/Jab</th>
				<th>Rekomendasi RO</th>
				<th>Persetujuan HRD </th>
				<th>Proses</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
<!-- /.table-responsive -->


<script>
    $(document).ready(function() {
        $('#dataTables').dataTable({
			"bProcessing": true,
			"bServerSide": true,
			"iDisplayLength": 25,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"fnServerParams": function ( aoData ) {
					aoData.push( { "name": "cabang", "value": $('#cabangfilter').val() });
				},
			"aoColumns": [
				{"mData": "ID" },
				{"mData": "TGL_TRANS" },
				{"mData": "NIK" },
				{"mData": "NAMA" },
				{"mData": "ASAL" },
				{"mData": "REKOM" },
				{"mData": "HRD" },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('resign/appv_data');?>"
		});
    });
$('#cabangfilter').change(function(){
		$('#dataTables').dataTable().fnReloadAjax();

	});
function view(obj){
	var id = $(obj).attr('data-id');
	var role = $(obj).attr('data-role');
	var mylabel=""; var mytitle="";	 var myurl="";
			$.ajax({
				type: 'POST',
				url: "<?php echo base_url('resign/view/'); ?>/"+id,
				data: {ajax:'true', role:role},
				dataType: 'html',
				success: 	function(data){					 
					if (role==20 || role ==33)	{
						mylabel="Direkomendasikan RO";
						mytitle="Proses Rekomendasi RO";
					}else{
						mylabel="Disetujui Pusat";
						mytitle="Persetujuan HRD Pusat";
					}
					var dialog=bootbox.dialog({
					  message: data,
					  title: mytitle,
					  buttons: {
						success: {
						  label: mylabel,
						  className: "btn-success btn-action",
						  callback: function() {
							approveForm(myurl);
							// $.post(myurl, $('#myform').serialize(), function(data){
							// });
						  }
						},
						button: {
						  label: "Tolak",
						  className: "btn-danger btn-denied",
						  callback: function() {
							deniedForm(role);
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

					dialog.bind('shown.bs.modal', function() {
						myurl= $("#myurl").val(); //alert(myurl);
						$applyBtn = $(this).find('.btn-action');
						$denyBtn = $(this).find('.btn-denied');
						if (role==20 || role ==33)	{	//RO active
							if (parseInt($("#stsApp").val()) >0 ){
								$applyBtn.prop("disabled", true);								
								$denyBtn.prop("disabled", true);								
							}else{
								$applyBtn.prop("disabled", false);
								$denyBtn.prop("disabled", false);
							}
							alert($("#sts_approve").val());
						}else{	//pusat active
							if (parseInt($("#stsR").val()) >0 ){
								$applyBtn.prop("disabled", false);	
								$denyBtn.prop("disabled", false);								
							}else{
								$applyBtn.prop("disabled", true);
								$denyBtn.prop("disabled", true);								
							}
							alert($("#sts_rekom").val());
						}
						
						$compile($applyBtn)($s);
					});

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

function approveForm(myurl){
	var form_data = $('#myform').serialize();
		
		$.ajax({
			type: 'POST',
			url: myurl,
			data: form_data,				
			dataType: 'json',
			success: function(msg) {
				 $("#errorHandler").html('&nbsp;').hide();
				 console.log(msg);
				if(msg.status =='success'){
					$().showMessage('Data berhasil disimpan.','success',1000);
					//$("#divformkel").fadeSlide("hide");
					$('#dataTables').dataTable().fnReloadAjax();
					window.location.reload();				
				} else{
					bootbox.alert("Terjadi kesalahan. "+ msg.errormsg+". Data gagal disimpan.");				
					$("#errorHandler").html(msg.errormsg).show();
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				bootbox.alert("Terjadi kesalahan. Data gagal disimpan."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});
}

function deniedForm(role){
	var form_data = $('#myform').serialize();
		
		$.ajax({
			type: 'POST',
			url: "<?php echo base_url('resign/denied/');?>"+"/"+role,
			data: form_data,				
			dataType: 'json',
			success: function(msg) {
				 $("#errorHandler").html('&nbsp;').hide();
				 console.log(msg);
				if(msg.status =='success'){
					$().showMessage('Data berhasil disimpan.','success',1000);
					//$("#divformkel").fadeSlide("hide");
					$('#dataTables').dataTable().fnReloadAjax();
					window.location.reload();				
				} else{
					bootbox.alert("Terjadi kesalahan. "+ msg.errormsg+". Data gagal disimpan.");				
					$("#errorHandler").html(msg.errormsg).show();
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				bootbox.alert("Terjadi kesalahan. Data gagal disimpan."+	textStatus + " - " + errorThrown );
			},
			cache: false
		});
}
</script>