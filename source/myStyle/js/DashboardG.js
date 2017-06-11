var DashVariabelGlobal = [];
DashVariabelGlobal['keyWord']="";
DashVariabelGlobal['index'] = "all-plan-world";
DashVariabelGlobal['change'] = false;
DashVariabelGlobal['url'] = "allPlan";
DashVariabelGlobal['indexBody'] = "all-plan-world-body";
DashControlClass = function(){
	this.refreshContent = function(){
		var e = new jaservAjax({
			url : prefixUrl+'Dashboard/getListData/'+DashVariabelGlobal['url']+'.jsp',
			targetPath : prefixUrl+"",
			codeReloadToTargetPath : '&',
			codeReloadFuncTrue : '0',
			codeReloadFuncFalse : '6',
			reloadFunc : false,
			content : "kodeForm=J453RVT3CH@W3N4@FORM&keyword="+DashVariabelGlobal['keyWord'],
			funcTrue : function(message){
				ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 2000});
				var dataS = JSON.parse(message);
				$("#"+DashVariabelGlobal['indexBody']).html("");
				if(dataS.jumlah > 0){
					xX = "";
					for(var i=1; i<=dataS.jumlah;i++){
						xX += DashControl.createList(dataS[i]);
					}
					$("#"+DashVariabelGlobal['indexBody']).html(xX);
					CardControl.initialize();
				}else{
					$("#"+DashVariabelGlobal['indexBody']).html("<p>data tidak ditemukan</p>");
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
		DashVariabelGlobal['change']=false;
		$("#"+DashVariabelGlobal['index']).trigger('click');
		//alert();
	};
	this.createList = function(data){
		return '<div class="col-md-6">'+
			'<div class="card style-default-dark">'+
				'<div class="card-head  card-head-sm style-primary-dark">'+
					
					'<header>'+
						
						'<img style="margin-right : 10px;" class="img-circle img-responsive pull-left width-1" src="source/assets/img/avatar2.jpg?1404026449" alt="" />'+
						data.author+"<br>"+data.update+
					'</header>'+
					'<div class="tools">'+
						'<div class="btn-group">'+
							'<a onclick="DashControl.showComment('+"'"+data.id+"'"+')" class="btn btn-icon-toggle"><i class="md md-comment"></i></a>'+
							'<a class="btn btn-icon-toggle btn-collapse"><i class="fa fa-angle-down"></i></a>'+
						'</div>'+
					'</div>'+
				'</div>'+
				'<div class="card-body" style="display:none;">'+
					'<h3 class="text-light">'+data.judul+'</h3>'+
					'<p>'+data.deskripsi+'</p>'+
				'</div>'+
			'</div>'+
		'</div>';
	};
	this.showComment = function(id){
		DashVariabelGlobal['tempIdCommentActive'] = id;
		DashVariabelGlobal['tempSendComment'] = false;
		ModalControl.openFlushModal("Dashboard/getCommentOfThis",function(){
			$("#add-comment-to-this").click(function(){
				if(DashVariabelGlobal['tempSendComment']) return;
				DashVariabelGlobal['tempSendComment'] = true;
				$("#text-comment").attr("disabled","true");
				console.log($("#text-comment").val());
				//return;
				var comment = $("#text-comment").val();
				ToasterControl.openWarningMessage({	message : "memproses ...",clear : true});
				var e = new jaservAjax({
					url : prefixUrl+'Dashboard/addCommentOfThis.jsp',
					targetPath : prefixUrl+"",
					codeReloadToTargetPath : '&',
					codeReloadFuncTrue : '0',
					codeReloadFuncFalse : '6',
					reloadFunc : false,
					content : "kodeForm=J453RVT3CH@W3N4@FORM&id="+DashVariabelGlobal['tempIdCommentActive']+"&comment="+comment,
					funcTrue : function(message){
						ToasterControl.openSuccessMessage({	message : "berhasil ...",clear : true,timeOut : 500});
						ModalControl.closeFlushModal();
						setTimeout(function(){
							DashControl.showComment(DashVariabelGlobal['tempIdCommentActive']);
						},500);
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
			});
		},"id="+id);
	};
	this.eventFunc = function(){
		$("#all-plan-world").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(DashVariabelGlobal['change']){
				DashVariabelGlobal['index'] = "all-plan-world";
				DashVariabelGlobal['url'] = "allPlan";
				DashVariabelGlobal['keyWord'] = "";
				DashVariabelGlobal['indexBody'] = "all-plan-world-body";	
			}else{
				DashVariabelGlobal['change']=true;
			}
			DashControl.refreshContent();
		});
		$("#list-of-plan-world").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(DashVariabelGlobal['change']){
				DashVariabelGlobal['index'] = "list-of-plan-world";
				DashVariabelGlobal['url'] = "listOfPlan";
				DashVariabelGlobal['keyWord'] = "";
				DashVariabelGlobal['indexBody'] = "list-of-plan-world-body";
			}else{
				DashVariabelGlobal['change']=true;
			}
			DashControl.refreshContent();
		});
		$("#doing-of-plan-world").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(DashVariabelGlobal['change']){
				DashVariabelGlobal['index'] = "doing-of-plan-world";
				DashVariabelGlobal['url'] = "doingOfPlan";
				DashVariabelGlobal['keyWord'] = "";
				DashVariabelGlobal['indexBody'] = "doing-of-plan-world-body";
			}else{
				DashVariabelGlobal['change']=true;
			}
			DashControl.refreshContent();
		});
		$("#dissmis-of-plan-world").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(DashVariabelGlobal['change']){
				DashVariabelGlobal['index'] = "dissmis-of-plan-world";
				DashVariabelGlobal['url'] = "dissmisOfPlan";
				DashVariabelGlobal['keyWord'] = "";
				DashVariabelGlobal['indexBody'] = "dissmis-of-plan-world-body";
			}else{
				DashVariabelGlobal['change']=true;
			}
			DashControl.refreshContent();
		});
		$("#delay-of-plan-world").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(DashVariabelGlobal['change']){
				DashVariabelGlobal['index'] = "delay-of-plan-world";
				DashVariabelGlobal['url'] = "delayOfPlan";
				DashVariabelGlobal['keyWord'] = "";
				DashVariabelGlobal['indexBody'] = "delay-of-plan-world-body";
			}else{
				DashVariabelGlobal['change']=true;
			}
			DashControl.refreshContent();
		});
		$("#finish-of-plan-world").click(function(){
			var ariaExpanded = $(this).attr('aria-expanded');
			if(ariaExpanded == 'true') return;
			if(DashVariabelGlobal['change']){
				DashVariabelGlobal['index'] = "finish-of-plan-world";
				DashVariabelGlobal['url'] = "finishOfPlan";
				DashVariabelGlobal['keyWord'] = "";
				DashVariabelGlobal['indexBody'] = "finish-of-plan-world-body";
			}else{
				DashVariabelGlobal['change']=true;
			}
			DashControl.refreshContent();
		});
	};
};
var DashControl = new DashControlClass();
