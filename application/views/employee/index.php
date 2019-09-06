<p>
	<button class="btn btn-primary" id="btsubmit_add" onclick="doToggle()">Tambah Data</button>
	<span id="entrystep" class="no-display">
		<?php
		echo anchor('employee/create','<i class="fa fa-plus-square-o"></i> Data Karyawan Baru',array('id'=>'btsubmit','class'=>'btn btn-success'));
		echo '&nbsp;';
		echo anchor('employee/copydata','<i class="fa fa-copy"></i> Salin Data Karyawan',array('id'=>'btsubmit','class'=>'btn btn-warning'));
		?>
	</span>
	<button class="btn btn-success" id="btxls"><i class="fa fa-printer"></i> Cetak XLS</button>
</p>
<hr />
<div class="row">
	<div class="col-sm-6">
		<label for="cabang" class="col-sm-4 control-label">Cabang </label>
		<div class="col-sm-8">
			<?php
				if ($this->session->userdata('auth')->id_cabang=="1"){
					echo form_dropdown('cabangfilter',$cabang,'1','id="cabangfilter" class="form-control" ');
				}else{
					echo '<input type="hidden" name="cabangfilter" id ="cabangfilter" value="'.$cabang->id_cabang.'"/>';
					echo '<label  class="col-sm-4 control-label">'.$cabang->kota.'</label>';
				}
			?>	
		</div>
	</div>
</div>

<div class="row" style="margin-top: 12px; margin-bottom: 25px;">
	<div class="col-sm-6">
		<label for="cabang" class="col-sm-4 control-label">Status Pegawai </label>
		<div class="col-sm-8">
			<?php
				echo '<select name="statusfilter" id="statusfilter" class="form-control">';
				foreach ($genref as $row) {
					echo '<option value="'.$row->ID_REFF.'">'.$row->VALUE1.'</option>';
				}
				echo '</select>';
			?>	
		</div>
	</div>
</div>
<hr />
 <div class="row" >
	<div class="col-xs-12">
	<table class="table table-striped table-bordered table-hover" id="dataTables">
		<thead>
			<tr>
				<th>NIK</th>
				<th>Nama</th>
				<th>Cabang</th>
				<th>Divisi</th>
				<th>Jabatan</th>
				<th>Kelompok Jabatan</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>
</div>
<!-- /.table-responsive -->
<script>
$('#dataTables').dataTable({
	"bProcessing": true,
	"bServerSide": true,
	"iDisplayLength": 25,
	"bJQueryUI": true,
	"sPaginationType": "full_numbers",
	"fnServerParams": function ( aoData ) {
		aoData.push( { "name": "cabang", "value": $('#cabangfilter').val() },
					{ "name": "divisi", "value": $('#divisi').val() });
	},
	"aoColumns": [
		{"mData": "NIK" },
		{"mData": "NAMA" },
		{"mData": "NAMA_CABANG" },
		{"mData": "NAMA_DIV" },
		{"mData": "NAMA_JAB" },
		{"mData": "LAZ_TASHARUF"},
		{"mData": "ACTION", "sortable":false }
	],
	"sAjaxSource": "<?php echo base_url('employee/json_data');?>"
});
		
$('#cabangfilter').change(function(){
	if ($(this).val()==''){
		$('#divisi').find('option').remove().end().attr('disabled',true);
		$('#dataTables').dataTable().fnReloadAjax();
		return false;
	}
		
	$.ajax({
		url: "<?php echo base_url('employee/comboDivByCab'); ?>",
		dataType: 'json',
		type: 'POST',
		data: {cabang:$(this).val()},
		success: function(respon){
			$('#divisi').find('option').remove().end();
			if (respon.status==1){
				var item = respon.data;
				for (opt=0;opt<item.length;opt++){
					$('#divisi').append('<option value="'+item[opt].ID_DIV+'">'+item[opt].NAMA_DIV+'</option>');
				}
			}
			$('#divisi').attr('disabled',false);
			$('#dataTables').dataTable().fnReloadAjax();
		}
	});
}).trigger('change');

$('#divisi').change(function(){
    $('#dataTables').dataTable().fnReloadAjax();
});
function doToggle(){	
	("#entrystep").toggle();
}

$(document).ready(function(){
  var dataTable = $('#dataTables').DataTable({
    'processing': true,
    'serverSide': true,
    'serverMethod': 'post',
    //'searching': false, // Remove default Search Control
    'ajax': {
       'url':'ajaxfile.php',
       'data': function(data){
          // Read values
          var status = $('#statusFilter').val();

          // Append to data
          data.statusFilter = status;
       }
    },
    'columns': [
       { data: 'emp_name' }, 
       { data: 'email' },
       { data: 'gender' },
       { data: 'salary' },
       { data: 'city' },
    ]
  });

  $('#statusFilter').change(function(){
    dataTable.draw();
  });
});

$(document).ready(function() {
	$('#btsubmit_add').click(function(){ 		
		$("#entrystep").toggle();		
	});
});
	
	$('#btxls').click(function(){
		var cabang = $('#cabangfilter').val();
		//var divisi = $('#divisi').val();
		var search = $('#dataTables_wrapper input[type="search"]').val();
		var url = '<?php echo base_url('employee/xlsx');?>?cabang='+cabang+'&search='+search;
		window.open('<?php echo base_url('employee/xlsx');?>?cabang='+cabang+'&search='+search);
	});
</script>