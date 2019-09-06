$(document).ready(function(){
	$('#myform input').keydown(function(event) {
		if(event.keyCode == 13) {
		  event.preventDefault();
		  return false;
		}
	});

	//$("[data-mask]").inputmask();

});
$(document).ready(function(){
	$('#yourform input').keydown(function(event) {
		if(event.keyCode == 13) {
		  event.preventDefault();
		  return false;
		}
	});
});

$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
    // DataTables 1.10 compatibility - if 1.10 then versionCheck exists.
    // 1.10s API has ajax reloading built in, so we use those abilities
    // directly.
    if ( $.fn.dataTable.versionCheck ) {
        var api = new $.fn.dataTable.Api( oSettings );
 
        if ( sNewSource ) {
            api.ajax.url( sNewSource ).load( fnCallback, !bStandingRedraw );
        }
        else {
            api.ajax.reload( fnCallback, !bStandingRedraw );
        }
        return;
    }
 
    if ( sNewSource !== undefined && sNewSource !== null ) {
        oSettings.sAjaxSource = sNewSource;
    }
 
    // Server-side processing should just call fnDraw
    if ( oSettings.oFeatures.bServerSide ) {
        this.fnDraw();
        return;
    }
 
    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];
 
    this.oApi._fnServerParams( oSettings, aData );
 
    oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable( oSettings );
 
        /* Got the data - add it to the table */
        var aData =  (oSettings.sAjaxDataProp !== "") ?
            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
 
        for ( var i=0 ; i<aData.length ; i++ )
        {
            that.oApi._fnAddData( oSettings, aData[i] );
        }
         
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
 
        that.fnDraw();
 
        if ( bStandingRedraw === true )
        {
            oSettings._iDisplayStart = iStart;
            that.oApi._fnCalculateEnd( oSettings );
            that.fnDraw( false );
        }
 
        that.oApi._fnProcessingDisplay( oSettings, false );
 
        /* Callback user function - for event handlers etc */
        if ( typeof fnCallback == 'function' && fnCallback !== null )
        {
            fnCallback( oSettings );
        }
    }, oSettings );
};

$.fn.showMessage = function(str,mode,hide)
{
	if (!mode) mode='success';
	if ($('#loading').length==0){
	$('<div/>').attr({
		'class': "modal fade",
		'id': "loading",
		'tabindex': "-1",
		'role': "dialog",
		'aria-labelledby': "myloading",
		'aria-hidden': "true"
	})
	.html('<div class="modal-dialog">' +
		'<div class="modal-content">' +
		'<div class="modal-body alert-'+  mode +'">' +
		'</div>' +
		'</div>' +
		'</div>')
	.appendTo('body');
	
	}
	
	$('#loading .modal-body').removeClass (function (index, css) {
		return (css.match (/\balert-\S+/g) || []).join(' ');
	})
	.addClass('alert-'+mode)
	.html(str);
	$('#loading').modal('show');
	
	if (hide!=undefined) {
		window.setTimeout(function(){
			$('#loading').modal('hide');
		}, hide);
	}
}


$.fn.saveForm = function(url,redirect)
{ 
	var data = $(this).serializeObject();
	$().showMessage('Processing.. Please wait','info');
	
    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'json',
        success: function(msg) {
			$().showMessage('','info',1);
            $("#errorHandler").html('&nbsp;').hide();
            if(msg.status =='success' ){
                $("#loading").fadeOut();
		
				bootbox.alert("Data berhasil disimpan.", function() {
					if (!redirect=='') {
						window.location.replace(redirect);
					} else {
						window.location.reload();
					}
				});
            } else {
               // $().showMessage('Terjadi kesalahan. Data gagal disimpan.','danger');
				bootbox.alert("Terjadi kesalahan. Data gagal disimpan.");
                $("#errorHandler").html(msg.errormsg).show();
            }
        },
        complete: function(msg){
            $('html,body').animate({
                scrollTop: $('#page-wrapper').offset().top
            }, 500);
			//$('body').scrollTop();
			//console.log('scrollTop');
            return false;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            $("#errorHandler").html('&nbsp;');
            $().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger');
        },
        cache: false
    });
	
}

$.fn.serializeObject = function()
{
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function btback(){
	location.history.back();
	return false;
}



function approve(obj){
	var base_url=$(obj).attr('data-base');
	//alert(base_url);
	bootbox.confirm("Anda yakin menyetujui data ini?", function(result) {
		if (result==true){
			if($('#myModal').hasClass('in')){
				$('#myModal').modal('hide');
			}
			$().showMessage('Sedang diproses.. Harap tunggu..','info');
			$.ajax({
				type: 'POST',
				url: $(obj).attr('data-url'),
				data: {approve:'true',notrans:$(obj).attr('data-id')},
				dataType: 'json',
				success: function(msg) {
					if(msg.status =='success'){
						$("#loading").fadeOut();
						$().showMessage('Data berhasil disimpan.','success',1000);
						$('#loading').on('hidden.bs.modal', function () {
							//alert(msg.sts);
							//window.location.reload();
							$('#dataTables').dataTable().fnReloadAjax();
							ceknotif(base_url);
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

function denied(obj){
	var base_url=$(obj).attr('data-base');
	//alert(base_url);
	bootbox.confirm("Anda yakin menolak pengajuan data ini?", function(result) {
		if (result==true){
			if($('#myModal').hasClass('in')){
				$('#myModal').modal('hide');
			}
			$().showMessage('Sedang diproses.. Harap tunggu..','info');
			$.ajax({
				type: 'POST',
				url: $(obj).attr('data-url'),
				data: {approve:'false',notrans:$(obj).attr('data-id')},
				dataType: 'json',
				success: function(msg) {
					if(msg.status =='success'){
						$("#loading").fadeOut();
						$().showMessage('Data berhasil disimpan.','success',2000);
						$('#loading').on('hidden.bs.modal', function () {
							//alert(msg.sts);
							//window.location.reload();
							$('#dataTables').dataTable().fnReloadAjax();
							ceknotif(base_url);
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

function ceknotif(base_url){
		$.ajax({
			type: 'POST',
			url: base_url+'/notif',
			//dataType: 'json',
			success: function(msg) {
				if (msg=='none'){
					$('#notif').removeClass('notif');
					$('#notifitem').remove();
				} else {
					$('#notifitem').remove();
					$('#notif').addClass('notif').after(msg);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger',2000);
			},
			cache: false
		});
	}

$.fn.fadeSlide = function(state,speed){
	if(!state) state = "toggle";
	if (!speed) speed = "normal";
	this.animate({"height": state, "opacity": state},speed);
}

$.fn.reset = function () {
  $(this).each (function() { this.reset(); });
}

function approveDash(obj, oDt){
	bootbox.confirm("Anda yakin menyetujui data ini?", function(result) {
		if (result==true){
			if($('#myModal').hasClass('in')){
				$('#myModal').modal('hide');
			}
			$().showMessage('Sedang diproses.. Harap tunggu..','info');
			$.ajax({
				type: 'POST',
				url: $(obj).attr('data-url'),
				data: {approve:'true',notrans:$(obj).attr('data-id')},
				dataType: 'json',
				success: function(msg) {
					if(msg.status =='success'){
						$("#loading").fadeOut();
						$().showMessage('Data berhasil disimpan.','success',2000);
						$('#loading').on('hidden.bs.modal', function () {
							window.location.reload();
							//$('#'+oDt).dataTable().fnReloadAjax();
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


function singleEmail(obj, key){
	bootbox.confirm("Anda yakin mengirim data ini?", function(result) {
		if (result==true){
			$().showMessage('Sedang diproses.. Harap tunggu..','info');
			$.ajax({
			url: $(obj).attr('data-url'),
			dataType: 'json',
			type: 'GET',
			data: {nik: $(obj).attr('data-id'), kunci : key},
			success: function(respon){
				$().showMessage('','info',1);
				if(respon.status==1){
					$("#loading").fadeOut();
					bootbox.alert("Email berhasil dikirim.", function() {						
							window.location.reload();
						
					});
				
				}else {
               // $().showMessage('Terjadi kesalahan. Data gagal disimpan.','danger');
					bootbox.alert("Terjadi kesalahan. Email gagal dikirim.");
					$("#errorHandler").html(respon.errormsg).show();
				}
			},
			
			complete: function(respon){
				$('html,body').animate({
					scrollTop: $('#page-wrapper').offset().top
				}, 500);
				//$('body').scrollTop();
				//console.log('scrollTop');
				return false;
			}
			
			});//ajax end

		}
	});
	
	

}

function updKontrak(obj, oDt){
	bootbox.confirm("Anda yakin menyetujui data ini?", function(result) {
		if (result==true){
			if($('#myModal').hasClass('in')){
				$('#myModal').modal('hide');
			}
			$().showMessage('Sedang diproses.. Harap tunggu..','info');
			$.ajax({
				type: 'POST',
				url: $(obj).attr('data-url'),
				data: {upgrade:'true',nik:$(obj).attr('data-id')},
				dataType: 'json',
				success: function(msg) {
					if(msg.status =='success'){
						$("#loading").fadeOut();
						$().showMessage('Data berhasil disimpan.','success',2000);
						$('#loading').on('hidden.bs.modal', function () {
							window.location.reload();
							//$('#'+oDt).dataTable().fnReloadAjax();
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


function sendEmailSlip(obj, nik, bln, thn){
	bootbox.confirm("Anda yakin mengirim data ini?", function(result) {
		if (result==true){
			$().showMessage('Sedang diproses.. Harap tunggu..','info');
			$.ajax({
			url: $(obj).attr('data-url'),
			dataType: 'json',
			type: 'GET',
			data: {nik: nik, bln : bln, thn:thn},
			success: function(respon){
				//alert(respon.str);
				$().showMessage('','info',1);
				if(respon.status==1){
					$("#loading").fadeOut();
					bootbox.alert("Email berhasil dikirim.", function() {						
							window.location.reload();
						
					});
				
				}else {
               // $().showMessage('Terjadi kesalahan. Data gagal disimpan.','danger');
					bootbox.alert("Terjadi kesalahan. Email gagal dikirim."+respon.errormsg);
					$("#errorHandler").html(respon.errormsg).show();
				}
			},
			
			complete: function(respon){
				$('html,body').animate({
					scrollTop: $('#page-wrapper').offset().top
				}, 500);
				//$('body').scrollTop();
				//console.log('scrollTop');
				return false;
			}
			
			});//ajax end

		}
	});
}


function backTo(url){
	bootbox.confirm("Anda yakin akan meninggalkan halaman ini?", function(result) {
		if (result==true){window.location.replace(url);}
	});
}

function singleSlip(obj){
	bootbox.confirm("Anda yakin mencetak data ini?", function(result) {
		if (result==true){
			if($('#myModal').hasClass('in')){
				$('#myModal').modal('hide');
			}
			$().showMessage('Sedang diproses.. Harap tunggu..','info');
			$.ajax({
				type: 'GET',
				url: $(obj).attr('data-url'),
				data: {param : $(obj).attr('data-id')},
				dataType: 'json',
				success: function(data) {
					$("#loading").fadeOut();					
					$().showMessage('Slip berhasil Dicetak.','success',2000);	
					window.location.reload();
					
				},
				complete: function(data){
					$('html').animate({
						scrollTop: $('#page-wrapper').offset().top
					}, 500);
					
					return false;
				},
				/*error: function(XMLHttpRequest, textStatus, errorThrown) {
					$().showMessage('Terjadi kesalahan.<br />'+	textStatus + ' - ' + errorThrown ,'danger',2000);
				},*/
				cache: false
			});
		}
	});
}


function print_down(obj){
	bootbox.confirm("Anda yakin mendownload data ini?", function(result) {
		if (result==true){
			if($('#myModal').hasClass('in')){
				$('#myModal').modal('hide');
			}
			$().showMessage('Sedang diproses.. Harap tunggu..','info');
			$.ajax({
				type: 'GET',
				url: $(obj).attr('data-url'),
				data: {param : $(obj).attr('data-id')},
				dataType: 'json',
				success: function(data) {
					$("#loading").fadeOut();
					$().showMessage('Slip berhasil Didownload.','success',2000);					
				},
				complete: function(data){
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

function numericVal(object, evt) {
		evt = (evt) ? evt : window.event
		var chr = (evt.charCode) ? evt.charCode : evt.keyCode	
		return !(chr > 31 && (chr < 48 || chr > 57) )
	}

function blurObj(obj) {
	$(obj).val($(obj).unmask());
}

function clickObj(obj) {
	$(obj).priceFormat({
                    prefix: '',
                    centsSeparator: ',',
                    thousandsSeparator: '.',
					centsLimit: 0
    });	
}

/*
function blurObj(obj) {
	//alert(obj.id);		
	//alert($(obj).val());	
	var num = $(obj).maskMoney('unmasked')[0];
		$(obj).val(num);
		$(obj).maskMoney('destroy');
		//alert($('#nominal').val());
}

function clickObj(obj) {
	//alert(obj.id);		
	//alert($(obj).val());	
	$(obj).maskMoney({thousands:'.', decimal:',', allowZero:true, precision:0});
	$(obj).maskMoney('mask', parseFloat($(obj).val()));
}
*/