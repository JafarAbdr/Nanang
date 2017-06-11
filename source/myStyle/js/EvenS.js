var EvenVariabelGlobal = [];
EvenVariabelGlobal['keyWord']="";
EvenVariabelGlobal['idActive'] = "*";
EvenVariabelGlobal['index'] = "all-plan";
EvenVariabelGlobal['change'] = false;
EvenVariabelGlobal['url'] = "allPlan";
EvenVariabelGlobal['indexBody'] = "all-plan-body";
EvenControlClass = function(){
	this.refreshContent = function(){
		if(EvenVariabelGlobal['idActive'] == "*"){
			EvenVariabelGlobal['idActive'] = $("#teach-id-list-member").val();
		}
		///console.log(EvenVariabelGlobal['idActive']);
		var e = new jaservAjax({
			url : prefixUrl+'Even/getListData/'+EvenVariabelGlobal['url']+'.jsp',
			targetPath : prefixUrl+"",
			codeReloadToTargetPath : '&',
			codeReloadFuncTrue : '0',
			codeReloadFuncFalse : '6',
			reloadFunc : false,
			content : "kodeForm=J453RVT3CH@W3N4@FORM&keyword="+EvenVariabelGlobal['keyWord']+"&guru="+EvenVariabelGlobal['idActive'],
			funcTrue : function(message){
				ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 2000});
				var dataS = JSON.parse(message);
				$("#"+EvenVariabelGlobal['indexBody']).html("");
				if(dataS.jumlah > 0){
					xX = "";
					for(var i=1; i<=dataS.jumlah;i++){
						xX += EvenControl.createList(dataS[i]);
					}
					$("#"+EvenVariabelGlobal['indexBody']).html(xX);
					CardControl.initialize();
				}else{
					$("#"+EvenVariabelGlobal['indexBody']).html("<p>data tidak ditemukan</p>");
				}
				
			},
			funcFalse : function(message){
				ToasterControl.openWarningMessage({	message : message+"...",clear : true});
			},
			funcAlternate : function(message){
				ToasterControl.openWarningMessage({	message : message+"...",clear : true});
			},
			funcProcess : function(message){
				ToasterControl.openWarningMessage({	message : "memproses...",clear : true});
			}
		});
		e.postTrue();
	};
	this.initialize = function(){
		var x = this;
		x.eventFunc();
		EvenVariabelGlobal['change']=false;
		$("#"+EvenVariabelGlobal['index']).trigger('click');
	};
	this.editThisEvent = function(a){
		ModalControlVariabelGlobal['tempFormModal']="id="+a;
		ModalControl.openFormModal("Even/getFormEdit",
			function(){
				ModalControlVariabelGlobal['tempFormModal']="";
			},function(){
				$(
					"#judul,#deskripsi,#status,#formModalButtonNo,#formModalButtonYes"
				).attr("disabled","true");
				ToasterControl.openInfoMessage({	message : "memproses...",clear : true});
				//alert($("#kategori").val());
				var judul = $("#judul").val();
				var id = $("#id").val();
				var deskripsi = $("#deskripsi").val();
				var kategori = $("#kategori").val();
				var e = new jaservAjax({
					url : prefixUrl+'Even/update.jsp',
					targetPath : prefixUrl+"",
					codeReloadToTargetPath : '&',
					codeReloadFuncTrue : '0',
					codeReloadFuncFalse : '6',
					reloadFunc : false,
					content : "kodeForm=J453RVT3CH@W3N4@FORM&"+
						"judul="+judul+"&"+
						"deskripsi="+deskripsi+"&"+
						"kategori="+kategori+"&"+
						"id="+id
						,
					funcTrue : function(message){
						ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 2000});
						$(
							"#judul,#deskripsi,#status,#formModalButtonNo,#formModalButtonYes"
						).removeAttr("disabled");
						ModalControl.closeFormModal();
						EvenControl.refreshContent();
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
	this.deleteThisEvent = function(a){
		alert(a);
	};
	this.createList = function(data){
		var a="";
		var b="";
		console.log(data.operation);
		if(data.operation == 'true'){
			a = '<a class="btn btn-icon-toggle" onclick="EvenControl.editThisEvent('+"'"+data.id+"'"+')"><i class="md md-mode-edit"></i></a>';
			b = '<a class="btn btn-icon-toggle" onclick="EvenControl.deleteThisEvent('+"'"+data.id+"'"+')"><i class="md md-close"></i></a>';
		}
		return '<div class="col-md-6">'+
			'<div class="card style-default-dark">'+
				'<div class="card-head  card-head-xs style-primary">'+
					'<header>'+data.judul+'</header>'+
					'<div class="tools">'+
						'<div class="btn-group">'+
							a+
							'<a class="btn btn-icon-toggle btn-collapse"><i class="fa fa-angle-down"></i></a>'+
							b+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="card-body" style="display:none;">'+
					'<p>'+data.deskripsi+'</p>'+
				'</div>'+
			'</div>'+
		'</div>';
	};
	this.eventFunc = function(){
		$("#all-plan").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(EvenVariabelGlobal['change']){
				EvenVariabelGlobal['index'] = "all-plan";
				EvenVariabelGlobal['url'] = "allPlan";
				EvenVariabelGlobal['keyWord'] = "";
				EvenVariabelGlobal['indexBody'] = "all-plan-body";	
			}else{
				EvenVariabelGlobal['change']=true;
			}
			EvenControl.refreshContent();
		});
		$("#list-of-plan").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(EvenVariabelGlobal['change']){
				EvenVariabelGlobal['index'] = "list-of-plan";
				EvenVariabelGlobal['url'] = "listOfPlan";
				EvenVariabelGlobal['keyWord'] = "";
				EvenVariabelGlobal['indexBody'] = "list-of-plan-body";
			}else{
				EvenVariabelGlobal['change']=true;
			}
			EvenControl.refreshContent();
		});
		$("#doing-of-plan").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(EvenVariabelGlobal['change']){
				EvenVariabelGlobal['index'] = "doing-of-plan";
				EvenVariabelGlobal['url'] = "doingOfPlan";
				EvenVariabelGlobal['keyWord'] = "";
				EvenVariabelGlobal['indexBody'] = "doing-of-plan-body";
			}else{
				EvenVariabelGlobal['change']=true;
			}
			EvenControl.refreshContent();
		});
		$("#dissmis-of-plan").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(EvenVariabelGlobal['change']){
				EvenVariabelGlobal['index'] = "dissmis-of-plan";
				EvenVariabelGlobal['url'] = "dissmisOfPlan";
				EvenVariabelGlobal['keyWord'] = "";
				EvenVariabelGlobal['indexBody'] = "dissmis-of-plan-body";
			}else{
				EvenVariabelGlobal['change']=true;
			}
			EvenControl.refreshContent();
		});
		$("#delay-of-plan").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(EvenVariabelGlobal['change']){
				EvenVariabelGlobal['index'] = "delay-of-plan";
				EvenVariabelGlobal['url'] = "delayOfPlan";
				EvenVariabelGlobal['keyWord'] = "";
				EvenVariabelGlobal['indexBody'] = "delay-of-plan-body";
			}else{
				EvenVariabelGlobal['change']=true;
			}
			EvenControl.refreshContent();
		});
		$("#finish-of-plan").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(EvenVariabelGlobal['change']){
				EvenVariabelGlobal['index'] = "finish-of-plan";
				EvenVariabelGlobal['url'] = "finishOfPlan";
				EvenVariabelGlobal['keyWord'] = "";
				EvenVariabelGlobal['indexBody'] = "finish-of-plan-body";
			}else{
				EvenVariabelGlobal['change']=true;
			}
			EvenControl.refreshContent();
		});
	};
};
EvenControl = new EvenControlClass();
