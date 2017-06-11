var AkunAddVariabelGlobal = [];
AkunAddClass = function(){
	var xx;
	this.initialize = function(){
		var tempAdd = this;
		$("#add_member").on('click', function(){
			tempAdd.add();
		});
	}
	this.add = function(){
		ModalControl.openListModal("Menambahkan",{
			1:{
				nama : "Wali",
				ico : "md md-school",
				act : function(){
					ModalControl.openFormModal("Wali",
					function(){
						$("#nip").on("blur",function(){
							//alert($(this).val());
							var nips = $(this).val();
							var cs = new jaservAjax({
								url : prefixUrl+"Wali/getDataByNip/"+$('#nama').val()+".jsp",
								targetPath : prefixUrl+"",
								codeReloadToTargetPath : '&',
								codeReloadFuncTrue : '0',
								codeReloadFuncFalse : '6',
								reloadFunc : false,
								content : "kodeForm=J453RVT3CH@W3N4@FORM&"+"nip="+nips,
								funcTrue : function(message){
									//alert(message);
									var datas = JSON.parse(message);
									//alert(datas.disable);
									if(!datas.disable){
										$(
											"#idline,#nohp,#email,#wali"
										).removeAttr("disabled");
									}else{
										$("#idline").val(datas.idline);
										$("#email").val(datas.email);
										$("#nohp").val(datas.nohp);
										$("#wali").val(datas.nama);
										$(
											"#idline,#nohp,#email,#wali"
										).attr("disabled","true");
									}
								}
							});
							cs.postTrue();
						});
					},function(){
						$(
							"#idline,#nip,#nohp,#email,#formModalButtonNo,#formModalButtonYes,#kepsek"
						).attr("disabled","true");
						ToasterControl.openInfoMessage({	message : "memproses...",clear : true});
						var wali = $("#wali").val();
						var guru = $("#guru").val();
						var nip = $("#nip").val();
						var email = $("#email").val();
						var nohp = $("#nohp").val();
						var idline = $("#idline").val();
						var e = new jaservAjax({
							url : prefixUrl+'Wali/add.jsp',
							targetPath : prefixUrl+"",
							codeReloadToTargetPath : '&',
							codeReloadFuncTrue : '0',
							codeReloadFuncFalse : '6',
							reloadFunc : false,
							content : "kodeForm=J453RVT3CH@W3N4@FORM&"+
								"wali="+wali+"&"+
								"guru="+guru+"&"+
								"email="+email+"&"+
								"nip="+nip+"&"+
								"nohp="+nohp+"&"+
								"idline="+idline
								,
							funcTrue : function(message){
								ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 2000});
								$(
									"#idline,#wali,#nip,#nohp,#email,#formModalButtonNo,#formModalButtonYes,#kepsek"
								).removeAttr("disabled");
								ModalControl.closeFormModal();
							},
							funcFalse : function(message){
								ToasterControl.openErrorMessage({	message : message+"...",clear : true,timeOut : 2000});
								$(
									"#idline,#wali, #nip,#nohp,#email,#formModalButtonNo,#formModalButtonYes,#kepsek"
								).removeAttr("disabled");
								$('#nip').trigger('blur');
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
				}
			}
		});
	};
	this.addOld = function(){
		ToasterControl.openInfoMessage({message : "Mohon menunggu ..."});
		var e = new jaservAjax({
			url : prefixUrl+'member/form',
			targetPath : prefixUrl+"",
			codeReloadToTargetPath : '&',
			codeReloadFuncTrue : '0',
			codeReloadFuncFalse : '6',
			reloadFunc : false,
			content : "kodeExit=J453RVT3CH_W3N4",
			funcTrue : function(message){
				ModalControl.headBodyFooterFunctions({
					width :0,
					button : "&nbsp;",
					header : "Tambah member dengan kategori",
					body : message,
					functions : function(){
						FormControl.initialize();
						CardControl.initialize();
						$('#sch-teach-id').select2({
							dropdownParent : $('core_modal')
						});
						$('#sch-parent-id').select2({
							dropdownParent : $('core_modal')
						});
						if(kodeJREWOKJSKSJAKSJKJSKAJSSAJK == 1 || kodeJREWOKJSKSJAKSJKJSKAJSSAJK == 2 || kodeJREWOKJSKSJAKSJKJSKAJSSAJK == 3){
							$("#add-new-parent").click(function(){
								$(this).attr("disabled","true");
								var idSch = $('#sch-parent-id').val();
								var nipParent = $('#sch-parent-nip').val();
								var nameParent = $('#sch-parent-name').val();
								var emailParent = $('#sch-parent-email').val();
								var noTelpParent = $('#sch-parent-no-telp').val();
								var idSch = null;
								var content = "";
								if(kodeJREWOKJSKSJAKSJKJSKAJSSAJK == 1){
									idSch = $('#sch-teach-id').val();
									content += "kodeExit=J453RVT3CH_W3N4&idSch="+
										idSch+"&nipParent="+
										nipParent+"&nameParent="+
										nameParent+"&emailParent="+
										emailParent+"&noTelpParent="+
										noTelpParent;
								}else{
									content += "kodeExit=J453RVT3CH_W3N4&nipParent="+
										nipParent+"&nameParent="+
										nameParent+"&emailParent="+
										emailParent+"&noTelpParent="+
										noTelpParent;
								}
								var e = new jaservAjax({
									url : prefixUrl+'member/form/parent',
									targetPath : prefixUrl+"",
									codeReloadToTargetPath : "&",
									codeReloadFuncTrue : '0',
									codeReloadFuncFalse : '6',
									reloadFunc : false,
									content : content,
									funcTrue : function(message){
										$('#add-new-parent').removeAttr("disabled");
										ModalControl.closeActive();
										MemberContentControl.getCoul(false);
										ToasterControl.openInfoMessage({message : message, timeOut : 4000, clear : true});
									},
									funcFalse : function(message){
										$('#add-new-parent').removeAttr("disabled");
										ToasterControl.openInfoMessage({message : message, timeOut : 4000, clear : true});
									},
									funcProcess : function(message){},funcAlternate : function(message){}
								});
								e.postTrue();
							});
						}
						if(kodeJREWOKJSKSJAKSJKJSKAJSSAJK == 1 || kodeJREWOKJSKSJAKSJKJSKAJSSAJK == 2){
							$("#add-new-teach").click(function(){
								$(this).attr("disabled","true");
								var nipTeach = $('#sch-teach-nip').val();
								var nameTeach = $('#sch-teach-name').val();
								var emailTeach = $('#sch-teach-email').val();
								var noTelpTeach = $('#sch-teach-no-telp').val();
								var idSch = null;
								var content = "";
								if(kodeJREWOKJSKSJAKSJKJSKAJSSAJK == 1){
									idSch = $('#sch-teach-id').val();
									content += "kodeExit=J453RVT3CH_W3N4&idSch="+
										idSch+"&nipTeach="+
										nipTeach+"&nameTeach="+
										nameTeach+"&emailTeach="+
										emailTeach+"&noTelpTeach="+
										noTelpTeach;
								}else{
									content += "kodeExit=J453RVT3CH_W3N4&nipTeach="+
										nipTeach+"&nameTeach="+
										nameTeach+"&emailTeach="+
										emailTeach+"&noTelpTeach="+
										noTelpTeach;
								}
								var e = new jaservAjax({
									url : prefixUrl+'member/form/teach',
									targetPath : prefixUrl+"",
									codeReloadToTargetPath : "&",
									codeReloadFuncTrue : '0',
									codeReloadFuncFalse : '6',
									reloadFunc : false,
									content : content,
									funcTrue : function(message){
										$('#add-new-teach').removeAttr("disabled");
										ModalControl.closeActive();
										MemberContentControl.getCoul(false);
										ToasterControl.openInfoMessage({message : message, timeOut : 4000, clear : true});
									},
									funcFalse : function(message){
										$('#add-new-teach').removeAttr("disabled");
										ToasterControl.openInfoMessage({message : message, timeOut : 4000, clear : true});
									},
									funcProcess : function(message){},funcAlternate : function(message){}
								});
								e.postTrue();
							});
						}
						if(kodeJREWOKJSKSJAKSJKJSKAJSSAJK == 1){
							$('#add-new-head').click(function(){
								$(this).attr("disabled","true");
								var nameSch = $('#sch-name').val();
								var nipHead = $('#sch-head-mr-nip').val();
								var nameHead = $('#sch-head-mr-name').val();
								var emailHead = $('#sch-head-mr-email').val();
								var noTelpHead = $('#sch-head-mr-no-telp').val();
								var e = new jaservAjax({
									url : prefixUrl+'member/form/head',
									targetPath : prefixUrl+"",
									codeReloadToTargetPath : "&",
									codeReloadFuncTrue : '0',
									codeReloadFuncFalse : '6',
									reloadFunc : false,
									content : "kodeExit=J453RVT3CH_W3N4&nameSch="+
										nameSch+"&nipHead="+
										nipHead+"&nameHead="+
										nameHead+"&emailHead="+
										emailHead+"&noTelpHead="+
										noTelpHead,
									funcTrue : function(message){
										$('#add-new-head').removeAttr("disabled");
										ModalControl.closeActive();
										MemberContentControl.getCoul(false);
										ToasterControl.openInfoMessage({message : message, timeOut : 4000, clear : true});
									},
									funcFalse : function(message){
										$('#add-new-head').removeAttr("disabled");
										ToasterControl.openInfoMessage({message : message, timeOut : 4000, clear : true});
									},
									funcProcess : function(message){},funcAlternate : function(message){}
								});
								e.postTrue();
							});
						}
					}
				});
				ToasterControl.clear();
				//loading.setMessage(message+'...').close();
			},
			funcFalse : function(message){
				ToasterControl.openInfoMessage({
					message : message, 
					timeOut : 4000, 
					clear : true
				});
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
	};
	this.view = function(a, x){
		
	};
};

var AkunAdd = new AkunAddClass();
//MemberControl.initialize();