var defaultPage = 1;
$(document).ready(function(){
	//$("#logOutModal").modal();
	DashControl.initialize();
	var tempHtml = '<form class="navbar-search" role="search">'+
		'<div class="form-group">'+
			'<input id="search-even-world" type="text" class="form-control" name="contactSearch" placeholder="Enter your keyword">'+
		'</div>'+
		'<button id="search-member-button" type="submit" class="btn btn-icon-toggle ink-reaction"><i class="fa fa-search"></i></button>'+
	'</form>';
	$('#add-search-world').html(tempHtml);
	NavSearchControl.initialize(
		function(val){
			DashVariabelGlobal['keyWord']=val;
			DashControl.refreshContent();
		},
		function(){
			$("#search-even-world").val(DashVariabelGlobal['keyWord']);
		}
	);
	$('#dashboard').click(function(){
		//alert(defaultPage);
		if(defaultPage == 1) return;
		MainLayout.open();
		defaultPage = 1;
		DashControl.refreshContent();
	});
	$("#myProfile").click(function(){
		ModalControl.openFormModal("Setting",function(){
			$("#ubahProfile").click(function(){
				if(this.checked){
					$(
						"#idline,#nama,#nip,#nohp,#email,#formModalButtonYes"
					).removeAttr("disabled");
				}else{
					$(
						"#idline,#nama,#nip,#nohp,#email,#formModalButtonYes"
					).attr("disabled","true");
				}
			});
		},function(){
			$(
				"#idline,#nama,#nip,#nohp,#email,#formModalButtonNo,#formModalButtonYes,#ubahProfile"
			).attr("disabled","true");
			ToasterControl.openInfoMessage({	message : "memproses...",clear : true});
			var nama = $("#nama").val();
			var nip = $("#nip").val();
			var email = $("#email").val();
			var nohp = $("#nohp").val();
			var idline = $("#idline").val();
			var e = new jaservAjax({
				url : prefixUrl+'Setting/update.jsp',
				targetPath : prefixUrl+"",
				codeReloadToTargetPath : '&',
				codeReloadFuncTrue : '0',
				codeReloadFuncFalse : '6',
				reloadFunc : false,
				content : "kodeForm=J453RVT3CH@W3N4@FORM&"+
					"nama="+nama+"&"+
					"email="+email+"&"+
					"nip="+nip+"&"+
					"nohp="+nohp+"&"+
					"idline="+idline
					,
				funcTrue : function(message){
					ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 2000});
					$(
						"#idline,#nama,#nip,#nohp,#email,#formModalButtonNo,#formModalButtonYes,#ubahProfile"
					).removeAttr("disabled");
					$("#namaOnTitle").html(nama);
					ModalControl.closeFormModal();
				},
				funcFalse : function(message){
					ToasterControl.openErrorMessage({	message : message+"...",clear : true,timeOut : 2000});
					$(
						"#idline,#nama,#nip,#nohp,#email,#formModalButtonNo,#formModalButtonYes,#ubahProfile"
					).removeAttr("disabled");
				},
				funcAlternate : function(message){
					ToasterControl.openWarningMessage({	message : message+"...",clear : true});
				},
				funcProcess : function(message){
					ToasterControl.openWarningMessage({	message : "memproses...",clear : true});
				}
			});
			e.postTrue();
		});
	});
	$('#dashboard').click(function(){
		//alert(defaultPage);
		if(defaultPage == 1) return;
		MainLayout.open();
		defaultPage = 1;
	});
	$('#akun').click(function(){
		if(defaultPage == 2) return;
		var e = new jaservAjax({
			url : prefixUrl+'Akun.jsp',
			targetPath : prefixUrl+"",
			codeReloadToTargetPath : '&',
			codeReloadFuncTrue : '0',
			codeReloadFuncFalse : '6',
			reloadFunc : false,
			content : "kodeForm=J453RVT3CH@W3N4",
			funcTrue : function(message){
				if(defaultPage == 1)
					MainLayout.close(message,function(){
						AkunAdd.initialize();
						AkunControl.initialize();
						NavSearchControl.initialize(
							function(val){
								AkunControl.getMid(val);
							},
							function(){
								$("#search-member").val(AkunControl.key);
							}
						);
						$('#sch-id-list-member').val(AkunControl.option);
						$('#sch-id-list-member').select2({
							dropdownParent : $('core_modal')
						});
					});
				else
					MainLayout.reload(message,function(){
						AkunAdd.initialize();
						AkunControl.initialize();
						NavSearchControl.initialize(
							function(val){
								AkunControl.getMid(val);
							},
							function(){
								$("#search-member").val(AkunControl.key);
							}
						);
						$('#sch-id-list-member').val(AkunControl.option);
						$('#sch-id-list-member').select2({
							dropdownParent : $('core_modal')
						});
					});
				defaultPage = 2;
				//loading.setMessage(message+'...').close();
			},
			funcFalse : function(message){
				//loading.setMessage(message+'...').close();
			},
			funcAlternate : function(message){
				//loading.setMessage(message+'...').close();
			},
			funcProcess : function(message){
				//loading.setMessage('process ...');
			}
		});
		e.postTrue();
	});
	$('#even').click(function(){
		if(defaultPage == 3) return;
		var e = new jaservAjax({
			url : prefixUrl+'Even.jsp',
			targetPath : prefixUrl+"",
			codeReloadToTargetPath : '&',
			codeReloadFuncTrue : '0',
			codeReloadFuncFalse : '6',
			reloadFunc : false,
			content : "kodeForm=J453RVT3CH@W3N4",
			funcTrue : function(message){
				if(defaultPage == 1)
					MainLayout.close(message,function(){
						//CardControl.initialize();
						EvenAddControl.initialize();
						EvenControl.initialize();
						$('#sub-event-s, #teach-id-list-member, #main-event').select2({
							dropdownParent : $('core_modal')
						});
						NavSearchControl.initialize(
							function(val){
								EvenVariabelGlobal['keyWord']=val;
								EvenControl.refreshContent();
							},
							function(){
								$("#search-even").val(EvenVariabelGlobal['keyWord']);
							}
						);
					});
				else
					MainLayout.reload(message,function(){
						//CardControl.initialize();
						EvenAddControl.initialize();
						EvenControl.initialize();
						$('#sub-event-s, #teach-id-list-member, #main-event').select2({
							dropdownParent : $('core_modal')
						});
						NavSearchControl.initialize(
							function(val){
								EvenVariabelGlobal['keyWord']=val;
								EvenControl.refreshContent();
							},
							function(){
								$("#search-even").val(EvenVariabelGlobal['keyWord']);
							}
						);
					});
				defaultPage = 3;
				//loading.setMessage(message+'...').close();
			},
			funcFalse : function(message){
				//loading.setMessage(message+'...').close();
			},
			funcAlternate : function(message){
				//loading.setMessage(message+'...').close();
			},
			funcProcess : function(message){
				//loading.setMessage('process ...');
			}
		});
		e.postTrue();
	});
	ModalControl.initialOpenFormModal();
});