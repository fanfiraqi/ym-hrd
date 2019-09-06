<p><?php echo anchor('lembur/create','Permohonan Lembur',array('id'=>'btsubmit','class'=>'btn btn-primary'));?> </p>
<!-- </div> -->
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
	<table class="table table-striped table-bordered table-hover dataTable" id="dataTables">
		<thead>
			<tr>
				<th>No Permohonan</th>
				<th>Tanggal Pemohonan</th>
				<th>NIK</th>
				<th>Nama</th>
				<th>Cabang/Div/Jab</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
<!-- /.table-responsive -->

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

        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
		<a href="" class="btn btn-primary" id="mbtedit"><i class="fa fa-pencil" title="Edit"></i> Edit</a>
      </div>
    </div>
  </div>
</div>



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
				{"mData": "NO_TRANS" },
				{"mData": "TGL_TRANS" },
				{"mData": "NIK" },
				{"mData": "NAMA" },
				{"mData": "CABANG", "sortable":false },
				{"mData": "ACTION", "sortable":false }
			],
			"sAjaxSource": "<?php echo base_url('lembur/json_data');?>"
		});
    });
	
	setInterval(function(){$('#dataTables').dataTable().fnReloadAjax();},60000);
	$('#cabangfilter').change(function(){
		$('#dataTables').dataTable().fnReloadAjax();

	});
	
function view(obj){
	var notrans = $(obj).attr('data-id');
			$.ajax({
				type: 'GET',
				url: $(obj).attr('data-url'),
				data: {view:'true',notrans:notrans},
				dataType: 'html',
				success: function(msg) {
					$('#mnotrans').html('No. Dokumen Lembur : '+notrans);
					$('#mcontent').html(msg);
					$('#mbtedit').attr('href',"<?php echo base_url('lembur/edit?notrans=');?>"+notrans);
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
</script>