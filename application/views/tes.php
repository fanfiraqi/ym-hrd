<button id="doprogress" class="btn btn-success">Email All</button>
<p>&nbsp;</p>
<div class="row">
	<div class="col-md-6">
		<div class="progress no-display">
			<div class="progress-bar" id="progressBar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
			0%
			</div>
		</div>
	</div>
</div>
ss
<script>


function emailprogress(cnt,step){
	if(typeof cnt === 'undefined'){
		var data = {cabang:2,divisi:6};
	} else {
		var data = {cabang:2,divisi:6,cnt:cnt,step:step};
	}
	$.ajax({
		url: "<?php echo base_url('tes/emailcount'); ?>",
		dataType: 'json',
		type: 'GET',
		data: data,
		success: function(respon){
			if (respon.status==1){
				$('.progress').show();
				if(respon.jumlah){
					nextcnt = respon.jumlah;
				} else {
					nextcnt = cnt;
				}
				
				if(typeof respon.nextstep === 'undefined'){
					nextstep = 1;
				} else {
					nextstep = respon.nextstep;
				}
				
				if(typeof respon.percent === 'undefined'){
					percent = 0;
				} else {
					percent = respon.percent;
				}
				
				
				if (respon.complete != 1){
					$('#progressBar').css('width',percent+'%').html(percent+'%');
					emailprogress(nextcnt,nextstep);
				}
				/*var jum = respon.jumlah;
				$('.progress').show();
				for(var i=1;i<=jum;i++){
					
				}*/
			} else {
				$('.progress').hide();
			}
		}
	});
}

$('#doprogress').click(function(){
	emailprogress();
	/*$.ajax({
		url: "<?php echo base_url('tes/emailcount'); ?>",
		dataType: 'json',
		type: 'GET',
		data: {cabang:2,divisi:6},
		success: function(respon){
			if (respon.status==1){
				console.log('jumlah',respon.jumlah);
				var jum = respon.jumlah;
				$('.progress').show();
				for(var i=1;i<=jum;i++){
					
				}
			} else {
				$('.progress').hide();
			}
		}
	});*/
});

function doIncrement(increment) {
  w = parseInt(document.getElementById('progressBar').style.width);
  document.getElementById('progressBar').style.width= (w + increment) +'%';
}


</script>
sandbox