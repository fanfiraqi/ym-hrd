<?php 
$role=$this->session->userdata('auth')->ROLE;
 if ($status!="")	errorHandler(); ?>
<?php echo form_open('pengguna/edit',array('class'=>'form-horizontal','id'=>'myform'));?>
<?php echo form_hidden('id',$row->ID);?>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">USERNAME</label>
			<div class="col-sm-8"><? 
				if (trim($role)=='Admin'){
					echo form_input(array('name'=>'username','id'=>'username','class'=>'form-control', 'value'=>$row->USERNAME));
				}else{
						echo '<B>'.$row->USERNAME.'</B>'; 
				}
				?></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label  class="col-sm-4 control-label">TYPE NEW PASSWORD</label>
			<div class="col-sm-8"><?=form_password(array('name'=>'password','id'=>'password','class'=>'form-control'));?>	</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<div class="form-group"><label class="col-sm-4 control-label">NIK</label>
			<div class="col-sm-8"><?=form_input(array('name'=>'nik','id'=>'nik','class'=>'form-control', 'value'=>$row->NIK));?>	</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">ROLE AKSES</label>
			<div class="col-sm-8">
				<?php $data = array('Operator HRD'=>'Operator HRD', 'Manager HRD'=>'Manager HRD','Direktur HRD'=>'Direktur HRD','Operator ZIS'=>'Operator ZIS','Manager Keuangan'=>' Manager Keuangan','Direktur Keuangan'=>'Direktur Keuangan','Admin'=>'Admin Program');
				
					if ($role=='Admin'){
						echo form_dropdown('role',$data,$row->ROLE,'id="role" class="form-control"');
					}else{
						echo '<B>'.$data[$role].'</B>'; 
					}
				?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label for="sex" class="col-sm-4 control-label">STATUS</label>
			<div class="col-sm-8">
				<?php $data = array('1'=>'Aktif', '0'=>'Tidak Aktif');
					if ($role=='Admin'){
						echo form_dropdown('status',$data,$row->ISACTIVE,'id="status" class="form-control"');
					}else{
						echo '<B>'.$data[$row->ISACTIVE].'</B>'; 
					}					
				?></div>
		</div>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-6">
		
			<?php 
			$btsubmit = array(
					'name'=>'btsubmit',
					'id'=>'btsubmit',
					'value'=>'Simpan',
					'class'=>'btn btn-primary'
				);
			echo form_submit($btsubmit);?>  
			<?php 
			if ($role=='Admin'){
				$btback = array(
					'name'=>'btback',
					'id'=>'btback',
					'content'=>'Batal',
					'onclick'=>'history.back();return false;',
					'class'=>'btn btn-danger'
				);
				echo form_button($btback);
			}
			
			
			?>
	</div>
</div>
<?php echo form_close();?>

<script type="text/javascript">
$('#myform').submit(function(event) {
	if ('<?=$role?>'=='Admin')
	{	$(this).saveForm('<?php echo base_url('pengguna/edit');?>','<?php echo base_url('pengguna');?>');
	}else{
		$(this).saveForm('<?php echo base_url('pengguna/edit/'.$row->ID);?>','<?php echo base_url('pengguna/edit/'.$row->ID);?>');
	}
	
	event.preventDefault();
});


$(document).ready(function(){
});


</script>