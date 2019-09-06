<ul class="nav nav-tabs" id="myTab">
  <li><a href="#pribadi" data-toggle="tab">DATA PRIBADI</a></li>
  <li><a href="#pekerjaan" data-toggle="tab">DATA PEKERJAAN</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane" id="pribadi">
	<br>
	<?php $this->load->view('fhrdReport/pd_dataPribadi'); ?>	
	</div>
	
	<div class="tab-pane" id="pekerjaan">
	<br>
	<?php $this->load->view('fhrdReport/pd_dataPekerjaan'); ?>	
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('#myTab a:first').tab('show');

});
</script>