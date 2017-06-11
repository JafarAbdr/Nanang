EvenAddControlClass = function(){
	this.initialize = function(){
		var tempAdd = this;
		$("#add_even").on('click', function(){
			tempAdd.add();
		});
	};
	this.add = function(){
		ModalControl.openFormModal("Schedule",
			function(){
				$('#kategori').select2({
					dropdownParent : $('#formModal')
				});
				
			},function(){
				$(
					"#judul,#deskripsi,#status,#formModalButtonNo,#formModalButtonYes"
				).attr("disabled","true");
				ToasterControl.openInfoMessage({	message : "memproses...",clear : true});
				//alert($("#kategori").val());
				var judul = $("#judul").val();
				var deskripsi = $("#deskripsi").val();
				var kategori = $("#kategori").val();
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
						"kategori="+kategori
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
	};
};
EvenAddControl = new EvenAddControlClass();
