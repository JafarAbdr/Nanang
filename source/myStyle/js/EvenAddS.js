EvenAddControlClass = function(){
	this.initialize = function(){
		var tempAdd = this;
		$("#add_even").on('click', function(){
			tempAdd.add();
		});
	};
	this.add = function(){
		ModalControl.openListModal("Menambahkan",{
			1:{
				nama : "Anda",
				ico : "md md-mood",
				act : function(){
					ModalControl.openFormModal("Schedule/us",
						function(){
							
						},function(){
							$(
								"#judul,#deskripsi,#status,#formModalButtonNo,#formModalButtonYes"
							).attr("disabled","true");
							ToasterControl.openInfoMessage({	message : "memproses...",clear : true});
							//alert($("#kategori").val());
							var judul = $("#judul").val();
							var deskripsi = $("#deskripsi").val();
							var kategori = $("#kategori").val();
							var guru = $("#guru").val();
							var e = new jaservAjax({
								url : prefixUrl+'Schedule/add.jsp',
								targetPath : prefixUrl+"",
								codeReloadToTargetPath : '&',
								codeReloadFuncTrue : '0',
								codeReloadFuncFalse : '6',
								reloadFunc : false,
								content : "kodeForm=J453RVT3CH@W3N4@FORM&"+
									"judul="+judul+"&"+
									"deskripsi="+deskripsi+"&"+
									"kategori="+kategori+"&"+
									"me=J453RVT3CH@W3N4@FORMME"
									,
								funcTrue : function(message){
									ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 2000});
									$(
										"#judul,#deskripsi,#status,#formModalButtonNo,#formModalButtonYes"
									).removeAttr("disabled");
									ModalControl.closeFormModal();
								},
								funcFalse : function(message){
									ToasterControl.openErrorMessage({	message : message+"...",clear : true,timeOut : 2000});
									$(
										"#judul,#deskripsi,#status,#formModalButtonNo,#formModalButtonYes"
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
						}
					);
				}
			},
			2:{
				nama : "Guru",
				ico : "md md-people",
				act : function(){
					ModalControl.openFormModal("Schedule",
						function(){
							$('#kategori').select2({
								dropdownParent : $('#formModal')
							});
							
						},function(){
							$(
								"#guru,#judul,#deskripsi,#status,#formModalButtonNo,#formModalButtonYes"
							).attr("disabled","true");
							ToasterControl.openInfoMessage({	message : "memproses...",clear : true});
							//alert($("#kategori").val());
							var judul = $("#judul").val();
							var deskripsi = $("#deskripsi").val();
							var kategori = $("#kategori").val();
							var guru = $("#guru").val();
							var e = new jaservAjax({
								url : prefixUrl+'Schedule/add.jsp',
								targetPath : prefixUrl+"",
								codeReloadToTargetPath : '&',
								codeReloadFuncTrue : '0',
								codeReloadFuncFalse : '6',
								reloadFunc : false,
								content : "kodeForm=J453RVT3CH@W3N4@FORM&"+
									"judul="+judul+"&"+
									"deskripsi="+deskripsi+"&"+
									"kategori="+kategori+"&"+
									"guru="+guru
									,
								funcTrue : function(message){
									ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 2000});
									$(
										"#guru,#judul,#deskripsi,#status,#formModalButtonNo,#formModalButtonYes"
									).removeAttr("disabled");
									ModalControl.closeFormModal();
								},
								funcFalse : function(message){
									ToasterControl.openErrorMessage({	message : message+"...",clear : true,timeOut : 2000});
									$(
										"#guru,#judul,#deskripsi,#status,#formModalButtonNo,#formModalButtonYes"
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
						}
					);
				}
			}
		});
	};
};
EvenAddControl = new EvenAddControlClass();
